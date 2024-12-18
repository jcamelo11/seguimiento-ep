<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AprendizResource\Pages;
use App\Models\Aprendiz;
use App\Models\InstructorSeguimiento;
use App\Models\ProgramaFormacion;
use App\Models\EtapaProductiva;
use App\Models\InstructorHistorial;
use App\Models\Aval;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select; 
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\RelationManagers\RelationManagerConfiguration;
use App\Filament\Resources\AprendizResource\RelationManagers;
use Illuminate\Database\Eloquent\Model; 
use Filament\Tables\Actions\BulkAction;
use App\Exports\AprendizExport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Tables\Actions\Action;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;

class AprendizResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Aprendiz::class;
    protected static ?string $recordTitleAttribute = 'nombres';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $label = 'Aprendiz';
    protected static ?string $pluralLabel = 'Aprendices';
    protected static ?string $slug = 'aprendices';

    protected static ?string $navigationGroup = 'Seguimiento';
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make('Datos Personales')
                    ->icon('heroicon-o-identification')
                    ->schema([
                        Forms\Components\Select::make('tipo_documento')
                            ->label('Tipo de Documento')
                            ->options([
                                'CC' => 'Cédula de Ciudadanía',
                                'TI' => 'Tarjeta de Identidad',
                                'PPT' => 'Permiso por Protección Temporal',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('numero_documento')
                            ->label('Número de Documento')
                            ->required(),
                        Forms\Components\TextInput::make('nombres')
                            ->label('Nombres')
                            ->required(),
                        Forms\Components\TextInput::make('apellidos')
                            ->label('Apellidos')
                            ->required(),
                        
                        Forms\Components\TextInput::make('celular1')
                            ->label('Celular 1')
                            ->required(),
                        Forms\Components\TextInput::make('celular2')
                            ->label('Celular 2'),
                        Forms\Components\TextInput::make('correo_personal')
                            ->label('Correo Personal')
                            ->email()
                            ->required(),
                        Forms\Components\TextInput::make('correo_institucional')
                            ->label('Correo Institucional')
                            ->email(),
                        Forms\Components\Select::make('genero')
                            ->label('Género')
                            ->options([
                                'M' => 'Masculino',
                                'F' => 'Femenino',
                                'Otro' => 'Otro',
                            ])
                            ->required(),
                        Forms\Components\Select::make('pruebas_tyt')
                            ->label('¿Ya realizó Pruebas TyT?')
                            ->options([
                                'SI' => 'SI',
                                'NO' => 'NO',
                            ])
                                
                            
                        
                    ])->collapsible()
                    ->columns(2),

                    Forms\Components\Section::make('Programa de formación')
                    ->icon('heroicon-o-academic-cap')
                    ->schema([
                        Select::make('programa_formacion_id')
                            ->label('Programa de Formación')
                            ->options(ProgramaFormacion::all()->pluck('nombre_con_ficha', 'id')) // Cargar las opciones
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                if ($state) {
                                    $programa = ProgramaFormacion::find($state);
                                    if ($programa) {
                                        // Asigna los valores del programa seleccionado
                                        $set('nombre_programa', $programa->nombre_programa);
                                        $set('ficha', $programa->ficha);
                                        $set('nivel_formacion', $programa->nivel_formacion);
                                        $set('modalidad', $programa->modalidad);
                                        $set('municipio_ficha', $programa->municipio_ficha);
                                        $set('lider_programa', $programa->lider_programa);
                                        $set('fecha_final', $programa->fecha_final);
                                    }
                                }
                            })
                            ->createOptionForm([ 
                                // Permitir crear un nuevo programa si no existe
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('ficha')
                                            ->label('Ficha')
                                            ->required(),
                                        TextInput::make('nombre_programa')
                                            ->label('Programa de Formación')
                                            ->required(),
                                        Select::make('nivel_formacion')
                                            ->label('Nivel de Formacion')
                                            ->options([
                                                'TECNOLOGO' => 'TECNOLOGO',
                                                'TECNICO' => 'TECNICO',
                                                'AUXILIAR' => 'AUXILIAR',
                                                'OPERARIO' => 'OPERARIO',
                                            ])
                                            ->required(),
                                        Select::make('modalidad')
                                            ->label('Modalidad')
                                            ->options([
                                                'PRESENCIAL' => 'PRESENCIAL',
                                                'VIRTUAL' => 'VIRTUAL',
                                            ])
                                            ->required(),
                                        TextInput::make('municipio_ficha')
                                            ->label('Municipio de la Ficha')
                                            ->required(),
                                        TextInput::make('lider_programa')
                                            ->label('Líder del Programa')
                                            ->required(),
                                        DatePicker::make('fecha_final')
                                            ->label('Fecha Final')
                                            ->required(),
                                    ]),
                                    
                            ])
                            ->createOptionUsing(function ($data) {
                                // Crear el nuevo programa
                                $programaFormacion = ProgramaFormacion::create([
                                    'nombre_programa' => $data['nombre_programa'],
                                    'ficha' => $data['ficha'],
                                    'nivel_formacion' => $data['nivel_formacion'],
                                    'modalidad' => $data['modalidad'],
                                    'municipio_ficha' => $data['municipio_ficha'],
                                    'lider_programa' => $data['lider_programa'],
                                    'fecha_final' => $data['fecha_final'],
                                ]);
                                return $programaFormacion->id; 
                                // Retornar el ID del nuevo programa
                            })
                            ->required(),

                        // Los demás campos cargados dinámicamente
                        TextInput::make('ficha')
                            ->label('Ficha')
                            ->disabled()
                            ->required()
                            ->reactive(),
                            
                        TextInput::make('nombre_programa')
                            ->label('Nombre del Programa')
                            ->disabled()
                            ->required()
                            ->reactive(),
                        TextInput::make('nivel_formacion')
                            ->label('Nivel de Formacion')
                            ->disabled()
                            ->reactive(),

                        TextInput::make('modalidad')
                            ->label('Modalidad')
                            ->disabled()
                            ->required()
                            ->reactive(),

                        TextInput::make('municipio_ficha')
                            ->label('Municipio de la Ficha')
                            ->disabled()
                            
                            ->reactive(),

                        TextInput::make('lider_programa')
                            ->label('Líder del Programa')
                            ->disabled()
                            ->reactive(),

                        DatePicker::make('fecha_final')
                            ->label('Fecha Final Etapa Lectiva')
                            ->disabled()
                            ->reactive(),
                    ])->collapsible()
                    ->columns(2)

                    ->afterStateHydrated(function ($set, $get) {
                        // Cargar los valores cuando se esté visualizando un registro existente
                        $programa = ProgramaFormacion::find($get('programa_formacion_id'));
                        if ($programa) {
                            $set('nombre_programa', $programa->nombre_programa);
                            $set('ficha', $programa->ficha);
                            $set('nivel_formacion', $programa->nivel_formacion);
                            $set('modalidad', $programa->modalidad);
                            $set('municipio_ficha', $programa->municipio_ficha);
                            $set('lider_programa', $programa->lider_programa);
                            $set('fecha_final', $programa->fecha_final);
                        }
                    })
                ])
                ->columnSpan(['lg' => 2]),


                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Estado del Aprendiz')
                            ->icon('heroicon-o-arrows-up-down')
                            ->schema([
                                Forms\Components\Select::make('estado')
                                ->label('Estado')
                                ->options([
                                    'ACTIVO' => 'ACTIVO',
                                    'POR CERTIFICAR' => 'POR CERTIFICAR',
                                    'CERTIFICADO' => 'CERTIFICADO',
                                    'CANCELADO/RETIRADO' => 'CANCELADO/RETIRADO',
                                ])
                                ->required(),
                            ])->collapsible(),

                        Forms\Components\Section::make('Instrutor de seguimiento')
                        ->icon('heroicon-o-presentation-chart-line')
                        ->schema([
                            Select::make('instructor_seguimiento_id')
                                ->label('Nombre y apellido')
                                ->options(InstructorSeguimiento::all()->pluck('nombre_completo', 'id'))
                                ->searchable()
                                ->preload(),
                        ])->visibleOn('edit')
                        ->collapsible(),

                        Forms\Components\Section::make('Instructor de seguimiento Anterior')
                        ->icon('heroicon-o-user-minus')
                        ->schema([
                            Forms\Components\Placeholder::make('instructor_anterior')
                                ->label('Instructor Anterior')
                                ->content(fn ($record) => $record?->instructorHistorial && $record->instructorHistorial->isNotEmpty()
                                    ? optional($record->instructorHistorial->last()->instructorSeguimiento)->nombre_completo
                                    : 'N/A'),

                            Forms\Components\Placeholder::make('fecha_asignacion_anterior')
                                ->label('Fecha de Asignación')
                                ->content(fn ($record) => $record?->instructorHistorial && $record->instructorHistorial->isNotEmpty()
                                    ? $record->instructorHistorial->last()->fecha_asignacion
                                    : 'N/A'),
                        ])->collapsible()
                        ->hidden(fn ($record) => !$record?->instructorHistorial || $record->instructorHistorial->count() < 2),

                        Forms\Components\Section::make('Aval')
                            ->icon('heroicon-o-clipboard-document-check')
                            ->schema([
                                Forms\Components\Placeholder::make('fecha')
                                    ->label('Fecha de Aval')
                                    ->content(fn ($record) => $record?->aval?->fecha 
                                        ? \Carbon\Carbon::parse($record->aval->fecha)->format('d M Y')
                                        : 'N/A'),
                            ])->collapsible()
                            ->hidden(fn ($record) => is_null($record?->aval?->fecha)),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('programaFormacion.ficha')
                    ->label('Ficha')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                BadgeColumn::make('estado') 
                ->label('Estado')
                ->colors([
                    'primary',
                    'info' => 'ACTIVO',
                    'warning' => 'POR CERTIFICAR',
                    'success' => 'CERTIFICADO',
                    'danger' => 'CANCELADO/RETIRADO',
                ])
                ->icons([
                    'heroicon-s-sparkles' => 'ACTIVO',
                    'heroicon-s-document-text' => 'POR CERTIFICAR',
                    'heroicon-s-check-badge' => 'CERTIFICADO',
                    'heroicon-s-x-circle' => 'CANCELADO/RETIRADO',
                ])
                ->sortable(),
                TextColumn::make('tipo_documento')
                  ->label('Tipo documento')
                  ->toggleable(),
                TextColumn::make('numero_documento')
                    ->label('Número de documento')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('nombres')
                    ->label('Nombres')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('apellidos')
                    ->label('Apellidos')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('programaFormacion.nombre_programa')
                    ->label('Programa de Formación')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\BadgeColumn::make('etapaProductiva.modalidad_etapa')
                    ->label('Etapa Productiva')
                    ->sortable()
                    ->toggleable()
                    ->colors([ 
                        'contrato' => 'CONTRATO DE APRENDIZAJE', 
                        'info' => function ($state) { 
                            return $state !== 'CONTRATO DE APRENDIZAJE'; 
                        },
                    ]),
                Tables\Columns\TextColumn::make('instructorSeguimiento.nombre_completo')
                ->label('Instructor de Seguimiento')
                  // Permitir ordenar
                ->searchable(query: function (Builder $query, string $search) {
                    return $query->whereHas('instructorSeguimiento', function (Builder $query) use ($search) {
                        // Concatenar 'nombres' y 'apellidos' para buscar por nombre completo
                        $query->whereRaw("CONCAT(nombres, ' ', apellidos) like ?", ["%{$search}%"]);
                    });
                })->toggleable(),

                
            ])
            ->filters([
                //Tables\Filters\Filter::make('assigned') ->query(function ($query) { $user = Auth::user(); if ($user && $user->instructorSeguimiento) { return $query->where('instructor_seguimiento_id', $user->instructorSeguimiento->id); } return $query; }) ->label('Mis Aprendices') ->default(),
                Tables\Filters\SelectFilter::make('estado')
                ->label('Estado')
                ->options([
                    'Activo' => 'Activo',
                    'Por Certificar' => 'Por Certificar',
                    'Certificado' => 'Certificado',
                    'Cancelado/Retirado' => 'Cancelado/Retirado',
                ]),

                Tables\Filters\SelectFilter::make('programa_formacion_id')
                ->label('N° de ficha')
                ->relationship('programaFormacion', 'ficha') // Relación para filtrar
                ->searchable(),

                Tables\Filters\SelectFilter::make('instructor_seguimiento_id')
                ->label('Instructor seguimiento')
                ->relationship('instructorSeguimiento', 'nombres') // Relación para filtrar
                ->searchable()
                ->visible(fn () => Gate::allows('filtrar_instructor_instructor::seguimiento')),
            ])
            ->actions([
                //Tables\Actions\ViewAction::make(),
                // ->label('Ver'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                
                // ExportAction::make()
                //     ->exporter(AprendizExporter::class)
                //     ->label('Descargar Aprendices')
                 
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('export')
                    ->label('Exportar a Excel')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action(function () {
                        return Excel::download(new AprendizExport, 'aprendices.xlsx');
                    })->visible(fn () => Gate::allows('exportar_aprendiz')),

                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->schema([
            Components\Group::make()
                ->schema([
                    Components\Section::make('Datos Personales')
                        ->icon('heroicon-o-identification')
                        ->schema([
                            Components\TextEntry::make('tipo_documento')->label('Tipo de Documento'),
                            Components\TextEntry::make('numero_documento')->label('Número de Documento'),
                            Components\TextEntry::make('nombres')->label('Nombres'),
                            Components\TextEntry::make('apellidos')->label('Apellidos'),
                            Components\TextEntry::make('celular1')
                            ->label('Celular 1')
                            ->state(fn ($record) => $record?->celular1 ?? 'N/A'),
                            Components\TextEntry::make('celular2')
                                ->label('Celular 2')
                                ->state(fn ($record) => $record?->celular2 ?? 'N/A'),
                            Components\TextEntry::make('correo_personal')
                                ->label('Correo Personal')
                                ->state(fn ($record) => $record?->correo_personal ?? 'N/A'),
                            Components\TextEntry::make('correo_institucional')
                                ->label('Correo Institucional')
                                ->state(fn ($record) => $record?->correo_institucional ?? 'N/A'),
                            Components\TextEntry::make('genero')->label('Género'),
                           
                        ])
                        ->columns(2)
                        ->collapsible(),

                    Components\Section::make('Programa de formación')
                        ->icon('heroicon-o-academic-cap')
                        ->schema([
                            Components\TextEntry::make('programaFormacion.ficha')->label('N° de Ficha'),
                            Components\TextEntry::make('programaFormacion.nombre_programa')->label('Nombre del Programa'),
                            Components\TextEntry::make('programaFormacion.nivel_formacion')->label('Nivel de Formacion'),
                            Components\TextEntry::make('programaFormacion.modalidad')->label('Modalidad'),
                            Components\TextEntry::make('programaFormacion.municipio_ficha')->label('Municipio de la Ficha'),
                            Components\TextEntry::make('programaFormacion.lider_programa')->label('Líder del Programa'),
                            Components\TextEntry::make('programaFormacion.fecha_final')->label('Fecha Final Etapa Lectiva')->date(),
                            Components\TextEntry::make('pruebas_tyt')
                            ->label('¿Ya realizó Pruebas TyT?')
                            ->state(fn($record) => $record->pruebas_tyt ? 'SI' : 'NO'),
                        ])
                        ->columns(2)
                        ->collapsible()
                ])
                ->columnSpan(['lg' => 2]),

            Components\Group::make()
                ->schema([
                    Components\Section::make('Estado del Aprendiz')
                        ->icon('heroicon-o-arrows-up-down')
                        ->schema([
                            Components\TextEntry::make('estado')
                                ->label('Estado')
                                ->badge()
                                ->colors([
                                    'primary',
                                    'info' => 'ACTIVO',
                                    'warning' => 'POR CERTIFICAR',
                                    'success' => 'CERTIFICADO',
                                    'danger' => 'CANCELADO/RETIRADO',
                                ])
                                ->icons([
                                    'heroicon-s-sparkles' => 'ACTIVO',
                                    'heroicon-s-document-text' => 'POR CERTIFICAR',
                                    'heroicon-s-check-badge' => 'CERTIFICADO',
                                    'heroicon-s-x-circle' => 'CANCELADO/RETIRADO',
                                ])
                        ])->collapsible(),

                        Components\Section::make('Instructor de seguimiento')
                        ->icon('heroicon-o-presentation-chart-line')
                        ->schema([
                            Components\TextEntry::make('instructorSeguimiento.nombre_completo')->label('Nombre y apellido'),
                            Components\TextEntry::make('fecha_asignacion')->label('Fecha de Asignación')->date()
                        ])
                        ->collapsible()
                        ->hidden(fn ($record) => is_null($record?->instructorSeguimiento)),
                    

                    Components\Section::make('Instructor de seguimiento Anterior')
                        ->icon('heroicon-o-user-minus')
                        ->schema([
                            Components\TextEntry::make('instructor_anterior')
                                ->label('Instructor Anterior')
                                ->state(fn ($record) => $record?->instructorHistorial && $record->instructorHistorial->isNotEmpty()
                                    ? optional($record->instructorHistorial->last()->instructorSeguimiento)->nombre_completo
                                    : 'N/A'),

                            Components\TextEntry::make('fecha_asignacion_anterior')
                                ->label('Fecha de Asignación')
                                ->state(fn ($record) => $record?->instructorHistorial && $record->instructorHistorial->isNotEmpty()
                                    ? $record->instructorHistorial->last()->fecha_asignacion
                                    : 'N/A')->date(),
                        ])->collapsible()
                        ->hidden(fn ($record) => !$record?->instructorHistorial || $record->instructorHistorial->count() < 2),


                    Components\Section::make('Aval')
                        ->icon('heroicon-o-clipboard-document-check')
                        ->schema([
                            Components\TextEntry::make('fecha')
                                ->label('Fecha de Aval')
                                ->state(fn ($record) => $record?->aval?->fecha 
                                    ? \Carbon\Carbon::parse($record->aval->fecha)->format('d M Y')
                                    : 'N/A'),
                        ])->collapsible()
                        ->hidden(fn ($record) => is_null($record?->aval?->fecha)),
                ])
                ->columnSpan(['lg' => 1]),
        ])->columns(3);
}


    
    public static function getRelations(): array
    {
        return [
            RelationManagers\EtapaProductivaRelationManager::class,
            RelationManagers\InformesSeguimientoRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAprendizs::route('/'),
            'create' => Pages\CreateAprendiz::route('/create'),
            'edit' => Pages\EditAprendiz::route('/{record}/edit'),
            'view' => Pages\ViewAprendiz::route('/{record}'),
    
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
    
        // Obtener el usuario autenticado
        $user = Auth::user();
    
        // Verificar si el usuario tiene el rol de instructor
        if ($user->hasRole('instructor_seguimiento')) {
            // Si es instructor, filtrar solo sus aprendices asignados
            return $query->whereHas('instructorSeguimiento', function (Builder $subQuery) use ($user) {
                $subQuery->where('user_id', $user->id);
            });
        }
    
        // Si no es instructor, devolver todos los registros
        return $query;
    }

    public static function getNavigationBadge(): ?string
    {
        $user = Auth::user();
    
        if ($user->hasRole('instructor_seguimiento')) {
            // Si es instructor, contar solo los aprendices asignados
            return (string) Aprendiz::whereHas('instructorSeguimiento', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->count();
        }
        // Si no es instructor, contar todos los aprendices
        return (string) Aprendiz::count();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nombres', 'apellidos', 'correo_personal', 'programaFormacion.ficha', 'numero_documento'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        // Concatenar nombres y apellidos para mostrar el nombre completo
        return "{$record->nombres} {$record->apellidos}";
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            $record->tipo_documento => $record->numero_documento,
            'Ficha' => $record->programaFormacion->ficha ?? 'No asignado',
           
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'exportar',
            'importar',
            'generar_informes',
            'generar_aval',
            'editar_etapa_productiva',
            'eliminar_etapa_productiva',
            'editar_informes_seguimiento',
            'eliminar_informes_seguimiento',
        ];
    }
}
