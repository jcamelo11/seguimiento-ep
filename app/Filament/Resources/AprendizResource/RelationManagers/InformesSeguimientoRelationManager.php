<?php

namespace App\Filament\Resources\AprendizResource\RelationManagers;

use App\Models\Aprendiz;
use App\Models\Aval;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification; 
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\Color;
use App\Mail\AprendizParaCertificacion;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;
use Filament\Tables\Actions\Action; 
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Str; 
use App\Notifications\CorreccionInformeNotification;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use App\Notifications\InformeSubidoNotification;

class InformesSeguimientoRelationManager extends RelationManager 
{
    protected static string $relationship = 'informesSeguimiento';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required(),
                Forms\Components\DatePicker::make('fecha_inicio')
                    ->label('Fecha de Inicio'),
                Forms\Components\DatePicker::make('fecha_entrega')
                    ->label('Fecha de Entrega'),
                Forms\Components\Select::make('estado_informe')
                ->label('Estado Informe')
                ->options([
                    'Sin Revisión' => 'Sin Revisión',
                    'RE - Errores' => 'RE - Errores',
                    'RE - Correcto' => 'RE - Correcto',
                ]),
                Toggle::make('subido_drive')
                    ->label('¿Subido al Drive?')
                    ->default(false),
                MarkdownEditor::make('observaciones')->columnSpan('full'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nombre')
            ->columns([
                TextColumn::make('nombre')
                    ->label('Nombre'),
                TextColumn::make('fecha_inicio') 
                    ->label('Fecha de Inicio') 
                    ->formatStateUsing(fn ($state) => $state ? Carbon::parse($state)->format('d M Y') : 'N/A'), 
                TextColumn::make('fecha_entrega') 
                    ->label('Fecha de Entrega') 
                    ->formatStateUsing(fn ($state) => $state ? Carbon::parse($state)->format('d M Y') : 'N/A'),
                Tables\Columns\BooleanColumn::make('subido_drive')
                ->label('Subido en Drive'),
                BadgeColumn::make('estado_informe') 
                    ->label('Estado')
                    ->colors([
                        'warning' => 'Sin Revisión',
                        'danger' => 'RE - Errores',
                        'success' => 'RE - Correcto',
                    ])
                    ->icons([
                        'heroicon-s-eye-slash' => 'Sin Revisión',
                        'heroicon-s-x-circle' => 'RE - Errores',
                        'heroicon-s-check-circle' => 'RE - Correcto',
                    ]),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make('generarAval')
                ->label('Aval')
                ->action(function () {
                    $aprendiz = $this->getOwnerRecord(); // Obtener el aprendiz actual
            
                    // Crear el aval para este aprendiz
                    Aval::create([
                        'aprendiz_id' => $aprendiz->id,
                        'fecha' => now(),  // Fecha actual
                        'observaciones' => 'Aprendiz con informes de seguimiento OK para CERTIFICACIÓN',
                    ]);

                     // Usa el correo institucional, o correo personal si el institucional no existe
                    $correoDestinatario = $aprendiz->correo_personal ?? $aprendiz->correo_institucional;

                    // Verifica que el correo exista antes de enviar
                    if ($correoDestinatario) {
                        // Enviar el correo de notificación al aprendiz
                        Mail::to($correoDestinatario)
                        ->send(new AprendizParaCertificacion($aprendiz));

                        // Notificación de éxito dentro de la aplicación
                        Notification::make()
                            ->title('Éxito')
                            ->body('Aval generado y correo enviado al aprendiz.')
                            ->success()
                            ->send();
                            
                    } else {
                        // Notificación de error si no hay correo disponible
                        Notification::make()
                            ->title('Error')
                            ->body('El aprendiz no tiene un correo registrado.')
                            ->danger()
                            ->send();
                    }
                })
                ->icon('heroicon-s-clipboard-document-check')
                ->color('secondary')
                ->visible(function () {
                    $aprendiz = $this->getOwnerRecord();
                    
                    // Verificar que existen informes y que todos estén en 'RE - Correcto'
                    return Gate::allows('generar_aval_aprendiz') && $aprendiz->informesSeguimiento()->exists() && $aprendiz->informesSeguimiento() ->where('estado_informe', '!=', 'RE - Correcto') ->doesntExist();
                })->requiresConfirmation()
                ->modalHeading('¿Estás seguro de que deseas generar el aval?')
                ->modalSubheading('Al confirmar, se enviará un correo electrónico al aprendiz notificando la aprobación de su etapa productiva y su avance al proceso de certificación.'),
    
                
                Tables\Actions\Action::make('generarInformes')
                ->icon('heroicon-s-newspaper')
                ->visible(function () { $aprendiz = $this->ownerRecord; 
                    return Gate::allows('generar_informes_aprendiz') && ! $aprendiz->informesSeguimiento()->exists();
                })
                ->action(function ($data) {
                    $parentRecord = $this->getOwnerRecord();
            
                    if ($parentRecord) {
                        $parentRecord->load('etapaProductiva');
            
                        if ($parentRecord->etapaProductiva) {
                            $etapaProductivaFechaInicio = Carbon::parse($parentRecord->etapaProductiva->fecha_inicio);
                            $etapaProductivaFechaFinal = Carbon::parse($parentRecord->etapaProductiva->fecha_final);
                            $informeParcialFechaEntrega = $etapaProductivaFechaInicio->copy()->addDays(90);

                            $parentRecord->informesSeguimiento()->create([
                                'nombre' => 'Form 023 - 01 - Concertación',
                                'fecha_inicio' => null,
                                'fecha_entrega' => null,
                                'estado_informe' => 'Sin Revisión',
                            ]);

                            $parentRecord->informesSeguimiento()->create([
                                'nombre' => 'Form 023 - 02 - Parcial',
                                'fecha_inicio' => $etapaProductivaFechaInicio,
                                'fecha_entrega' => $informeParcialFechaEntrega,
                                'estado_informe' => 'Sin Revisión',
                            ]);
            
                            $parentRecord->informesSeguimiento()->create([
                                'nombre' => 'Form 023 - 02 - Final',
                                'fecha_inicio' => $etapaProductivaFechaInicio,
                                'fecha_entrega' => $etapaProductivaFechaFinal,
                                'estado_informe' => 'Sin Revisión',
                            ]);

                            // Crear las Bitácoras
                            for ($i = 0; $i < 12; $i++) {
                                $nombreBitacora = 'Bitácora ' . ($i + 1);
                                $fechaInicioBitacora = $etapaProductivaFechaInicio->copy()->addDays($i * 15);
                                $fechaEntregaBitacora = ($i == 11) ? $etapaProductivaFechaFinal : $fechaInicioBitacora->copy()->addDays(14);

                                $parentRecord->informesSeguimiento()->create([
                                    'nombre' => $nombreBitacora,
                                    'fecha_inicio' => $fechaInicioBitacora,
                                    'fecha_entrega' => $fechaEntregaBitacora,
                                    'estado_informe' => 'Sin Revisión',
                                ]);
                            }
                            Notification::make()
                                ->title('Éxito')
                                ->body('Informes creados correctamente.')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Error')
                                ->body('La relación "etapaProductiva" no existe para este registro.')
                                ->danger()
                                ->send();
                        }
                    } else {
                        Notification::make()
                            ->title('Error')
                            ->body('Record not found.')
                            ->danger()
                            ->send();
                    }
                }),
            ])
            ->actions([
                Tables\Actions\Action::make('notificar_error')
                    ->label('Notificar corrección')
                    ->icon('heroicon-s-bell-alert')
                    ->visible(fn ($record) => $record->estado_informe === 'RE - Errores' && Gate::allows('correcion_informe_instructor::seguimiento'))
                    ->action(function ($record) {
                        $instructor = Auth::user()->instructorSeguimiento; // Obtener el instructor actual
                        $aprendiz = $record->aprendiz; // Relación con el aprendiz
                        $informe = $record; // Informe corregido
                        
                        if (!$instructor || !$aprendiz) {
                            return; // Asegurarse de que existan datos válidos
                        }
                        
                        // Datos de la notificación
                        $notificationData = [
                            'instructor' => $instructor->nombre_completo,
                            'aprendiz' => $aprendiz->nombres . ' ' . $aprendiz->apellidos,
                            'informe' => $informe->nombre,
                        ];

                        // Crear una notificación
                        $aprendiz->notify(new \App\Notifications\CorreccionInformeNotification($notificationData));
                        

                        Notification::make()
                        ->title('Notificación Enviada')
                        ->body('Se le notificado al equipo de seguimiento de las correcions del informe')
                        ->success()
                        ->send();
                    }),

                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                // CommentsAction::make()
                // ->label('Comentar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('marcar_subidos')
                        ->label('Marcar como Subidos')
                        ->icon('heroicon-s-arrow-up-on-square-stack')
                        ->color('success')
                        ->action(function (Collection $records) {
                            $instructor = Auth::user()->instructorSeguimiento; // Obtener el instructor
                            $agrupadosPorAprendiz = $records->groupBy(fn($record) => $record->aprendiz->id ?? null);

                            foreach ($agrupadosPorAprendiz as $aprendizId => $informes) {
                                if ($aprendizId) {
                                    $aprendiz = $informes->first()->aprendiz;
                                    $updatedCount = $informes->count();
                                    
                                    if ($instructor) { // Verifica si el usuario actual es un instructor de seguimiento
                                        // Enviar una notificación consolidada al aprendiz
                                        $aprendiz->notify(new InformeSubidoNotification([
                                            'instructor' => $instructor->nombre_completo ?? 'Instructor Desconocido',
                                            'updatedCount' => $updatedCount,
                                            'aprendiz' => $aprendiz->nombres . ' ' . $aprendiz->apellidos,
                                        ]));
                                    }

                                    // Actualizar todos los informes relacionados como subidos
                                    foreach ($informes as $record) {
                                        $record->update(['subido_drive' => true]);
                                    }
                                }
                            }

                            // Notificación en la interfaz de Filament
                            Notification::make()
                                ->title('Actualización completada')
                                ->body('Los informes seleccionados han sido marcados como subidos al Drive.')
                                ->success()
                                ->send();
                        })
                        ->requiresConfirmation()
                        ->visible(fn () => Gate::allows('subido_drive_instructor::seguimiento')),

                        
                ]),
            ]);
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'filtrar_instructores',
            'notify_correction', // Permiso personalizado
        ];
    }
}
