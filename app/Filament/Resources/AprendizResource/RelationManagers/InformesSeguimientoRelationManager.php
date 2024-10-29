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
                    'Sin Revision' => 'Sin Revision',
                    'RE - Errores' => 'RE - Errores',
                    'RE - Correcto' => 'RE - Correcto',
                ]),
                MarkdownEditor::make('observaciones')->columnSpan('full'),
                
        
               
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nombre')
            ->columns([
                TextColumn::make('nombre')->label('Nombre'),
                TextColumn::make('fecha_inicio')->label('Fecha de Inicio')
                ->formatStateUsing(fn ($state) => Carbon::parse($state)->format('d M Y')),
                TextColumn::make('fecha_entrega')->label('Fecha de Entrega')
                ->formatStateUsing(fn ($state) => Carbon::parse($state)->format('d M Y')),
                BadgeColumn::make('estado_informe') 
                    ->label('Estado')
                    ->colors([
                        'warning' => 'Sin Revision',
                        'danger' => 'RE - Errores',
                        'success' => 'RE - Correcto',
                    ])
                    ->icons([
                        'heroicon-s-eye' => 'Sin Revision',
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
                    $correoDestinatario = $aprendiz->correo_institucional ?? $aprendiz->correo_personal;

                    // Verifica que el correo exista antes de enviar
                    if ($correoDestinatario) {
                        // Enviar el correo de notificación al aprendiz
                        Mail::to($correoDestinatario)->send(new AprendizParaCertificacion($aprendiz));

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
                    // La condición de visibilidad que ya implementaste
                    return $this->getOwnerRecord()
                    ->informesSeguimiento()
                    ->where('estado_informe', '!=', 'RE - Correcto')
                    ->doesntExist();
                }),
            
                
                
                Tables\Actions\Action::make('generarInformes')
                ->icon('heroicon-s-newspaper')
                ->visible(! $this->ownerRecord->informesSeguimiento()->exists())
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
                                'estado_informe' => 'Sin Revision',
                            ]);
                            
                    
                            $parentRecord->informesSeguimiento()->create([
                                'nombre' => 'Form 023 - 02 - Parcial',
                                'fecha_inicio' => $etapaProductivaFechaInicio,
                                'fecha_entrega' => $informeParcialFechaEntrega,
                                'estado_informe' => 'Sin Revision',
                            ]);
            
                            $parentRecord->informesSeguimiento()->create([
                                'nombre' => 'Form 023 - 02 - Final',
                                'fecha_inicio' => $etapaProductivaFechaInicio,
                                'fecha_entrega' => $etapaProductivaFechaFinal,
                                'estado_informe' => 'Sin Revision',
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
                                    'estado_informe' => 'Sin Revision',
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
