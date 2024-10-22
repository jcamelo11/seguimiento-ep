<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AprendizResource\Pages;
use App\Models\Aprendiz;
use App\Models\ProgramaFormacion;
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


class AprendizResource extends Resource
{
    protected static ?string $model = Aprendiz::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $label = 'Aprendiz';
    protected static ?string $pluralLabel = 'Aprendices';
    protected static ?string $slug = 'aprendices';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)
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
                            Select::make('programa_formacion_id')
                            ->label('Programa de Formación')
                            ->options(ProgramaFormacion::all()->pluck('nombre_con_ficha', 'id'))
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('nombre_programa')
                                            ->label('Nombre del Programa')
                                            ->required(),
                                        TextInput::make('ficha')
                                            ->label('Ficha')
                                            ->required(),
                                        Select::make('nivel_formacion')
                                        ->label('Nivel de Formacion')
                                        ->options([
                                            'Tecnologo' => 'Tecnologo',
                                            'Tecnico' => 'Tecnico',
                                            'Auxilar' => 'Auxilar',
                                            'Operativo' => 'Operativo',
                                        ])
                                        ->required(),
                                        TextInput::make('nivel_formacion')
                                            ->label('Nivel de Formación')
                                            ->required(),
                                        Select::make('modalidad')
                                            ->label('Modalidad')
                                            ->options([
                                                'Presencial' => 'Presencial',
                                                'Virtual' => 'Virtual',
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
                                $programaFormacion = ProgramaFormacion::create($data);
                        
                                return $programaFormacion->id;
                            })
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
                                'Masculino' => 'Masculino',
                                'Femenino' => 'Femenino',
                                'Otro' => 'Otro',
                            ])
                            ->required(),
                            Forms\Components\Select::make('estado')
                            ->label('Estado')
                            ->options([
                                'Activo' => 'Activo',
                                'Por Certificar' => 'Por Certificar',
                                'Certificado' => 'Certificado',
                                'Cancelado/Retirado' => 'Cancelado/Retirado',
                            ])
                            ->required(),
                        Forms\Components\Toggle::make('pruebas_tyt')
                        ->label('¿Ya realizó Pruebas TyT?')
                        ->default(false),   
                    ])
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // define tus columnas aquí
                TextColumn::make('programaFormacion.ficha')
                    ->label('Ficha'),
                // TextColumn::make('tipo_documento')
                //     ->label('Tipo documento'),
                TextColumn::make('numero_documento')
                    ->label('Número de documento'),

                TextColumn::make('nombres')
                    ->label('Nombres'),

                TextColumn::make('apellidos')
                    ->label('Apellidos'),
                TextColumn::make('programaFormacion.nombre_programa')
                    ->label('Programa de Formación'),
                BadgeColumn::make('estado') 
                    ->label('Estado')
                    ->colors([
                        'primary',
                        'info' => 'Activo',
                        'warning' => 'Por Certificar',
                        'success' => 'Certificado',
                        'danger' => 'Cancelado/Retirado',
                    ])
                    ->icons([
                        'heroicon-s-sparkles' => 'Activo',
                        'heroicon-s-document-text' => 'Por Certificar',
                        'heroicon-s-check-badge' => 'Certificado',
                        'heroicon-s-x-circle' => 'Cancelado/Retirado',
                    ]),
            ])
            ->filters([
                // define tus filtros aquí
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->label('Ver'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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

    public static function getNavigationBadge(): ?string
    {
        return (string) Aprendiz::count();
    }

}
