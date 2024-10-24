<?php

namespace App\Filament\Resources\AprendizResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\BadgeColumn;
use Carbon\Carbon;


class EtapaProductivaRelationManager extends RelationManager
{
    protected static string $relationship = 'etapaProductiva';

    public function form(Form $form): Form
    {
        $existeEtapaProductiva = $this->ownerRecord->etapaProductiva()->exists();
        return $form
            ->schema([
                Forms\Components\Select::make('modalidad_etapa')
                    ->label('Modelidad de etapa Productiva')
                    ->options([
                        'CONTRETO DE APRENDIZAJE' => 'CONTRETO APRENDIZAJE',
                        'MONITORIAS' => 'MONITORIAS',
                        'PASANTIA - APOYO A UNA UNIDAD PRODUCTIVA FAMILIAR' => 'PASANTIA - APOYO A UNA UNIDAD PRODUCTIVA FAMILIAR',
                        'PASANTIA - APOYO INSTITUCION ESTATAL, MUNIC, VERED, ONG' => 'PASANTIA - APOYO INSTITUCION ESTATAL, MUNIC, VERED, ONG',
                        'PASANTIA - DE ASESORIA A PYMES' => 'PASANTIA - DE ASESORIA A PYMES',
                        'PROYECTO PRODUCTIVO' => 'PROYECTO PRODUCTIVO',
                        'PROYECTO PRODUCTIVO - CREACION DE UNIDAD PRODUCTIVA' => 'PROYECTO PRODUCTIVO - CREACION DE UNIDAD PRODUCTIVA',
                        'VINCULACION LABORAL' => 'VINCULACION LABORAL',
                    ])
                    ->required(),
                Forms\Components\DatePicker::make('fecha_inicio')
                    ->label('Fecha de Inicio')
                    ->required(),
                Forms\Components\DatePicker::make('fecha_final')
                    ->label('Fecha de Finalización')
                    ->required(),
                Forms\Components\TextInput::make('empresa')
                    ->label('Empresa')
                    ->required(),
                Forms\Components\TextInput::make('ciudad_practica')
                    ->label('Ciudad de la Práctica'),
                Forms\Components\Select::make('etapa_de_la_practica')
                    ->label('Estado de la Práctica')
                    ->options([
                        'PROD' => 'PROD',
                        'LECT' => 'LECT',
                        'LECT - PROD' => 'LECT - PROD',
                        
                    ]),
                Forms\Components\DatePicker::make('patrocinio')
                    ->label('Fecha Inicio Contrato Aprendizaje - Patrocinio Etapa Lectiva'), 
                Forms\Components\DatePicker::make('fecha_final_prorroga')
                    ->label('Fecha Final Etapa Productiva (Pre-Prórroga'),  
                  
                
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('modalidad_etapa')
            ->columns([
                Tables\Columns\BadgeColumn::make('modalidad_etapa')
                    ->colors([
                        'warning' => 'CONTRETO DE APRENDIZAJE',
                        'info' => function ($state) {
                            return in_array($state, [
                                'MONITORIAS', 
                                'PASANTIA - APOYO A UNA UNIDAD PRODUCTIVA FAMILIAR', 
                                'PASANTIA - APOYO INSTITUCION ESTATAL, MUNIC, VERED, ONG', 
                                'PASANTIA - DE ASESORIA A PYMES', 
                                'PROYECTO PRODUCTIVO', 
                                'PROYECTO PRODUCTIVO - CREACION DE UNIDAD PRODUCTIVA', 
                                'VINCULACION LABORAL'
                            ]);
                        }
                    ]),
                Tables\Columns\TextColumn::make('fecha_inicio')
                    ->label('Fecha de Inicio')
                    ->formatStateUsing(fn ($state) => Carbon::parse($state)->format('d M Y')),
                Tables\Columns\TextColumn::make('fecha_final')
                    ->label('Fecha de Finalización')
                    ->formatStateUsing(fn ($state) => Carbon::parse($state)->format('d M Y')),
                Tables\Columns\TextColumn::make('empresa')
                ->label('Nombre de la Empresa'),
                Tables\Columns\TextColumn::make('etapa_de_la_practica')
                ->label('Estado de la Práctica'),
                Tables\Columns\TextColumn::make('patrocinio')
                ->label('Fecha inicio Patrocinio')
                
            
                

            
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->label('Registrar Etapa Productiva')
                ->visible(! $this->ownerRecord->etapaProductiva()->exists())
                ->icon('heroicon-s-briefcase'), 
                
            ])
            ->actions([
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
