<?php

namespace App\Filament\Resources\InstructorSeguimientoResource\RelationManagers;

use App\Filament\Resources\AprendizResource;
use App\Models\ProgramaFormacion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AprendicesRelationManager extends RelationManager
{
    protected static string $relationship = 'aprendices';

    // public function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             Forms\Components\TextInput::make('nombres')
    //                 ->required()
    //                 ->maxLength(255),
    //         ]);
    // }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nombres')
            ->columns([
                Tables\Columns\TextColumn::make('nombres'),
                TextColumn::make('programaFormacion.ficha')
                    ->label('Ficha')
                    ->searchable()
                    ->sortable(),
                // TextColumn::make('tipo_documento')
                //     ->label('Tipo documento'),
                TextColumn::make('numero_documento')
                    ->label('Número de documento')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nombres')
                    ->label('Nombres')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('apellidos')
                    ->label('Apellidos')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('programaFormacion.nombre_programa')
                    ->label('Programa de Formación')
                    ->searchable()
                    ->sortable(),
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
                        'heroicon-s-document-text' => 'POR CERTIFICADO',
                        'heroicon-s-check-badge' => 'CERTIFICADO',
                        'heroicon-s-x-circle' => 'CANCELADO/RETIRADO',
                    ])
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                ->label('Estado')
                ->options([
                    'ACTIVO' => 'ACTIVO',
                    'POR CERTIFICAR' => 'POR CERTIFICAR',
                    'CERTIFICADO' => 'CERTIFICADO',
                    'CANCELADO/RETIRADO' => 'CANCELADO/RETIRADO',
                ]),
    
                // Filtrar por programa de formación
                Tables\Filters\SelectFilter::make('programa_formacion_id')
                ->label('N° de ficha')
                ->relationship('programaFormacion', 'ficha') // Relación para filtrar
                ->searchable(),
            ])
            ->headerActions([
                
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                ->label('Ver')
                ->icon('heroicon-o-eye')
                ->url(fn ($record) => AprendizResource::getUrl('view', ['record' => $record->id])) // Redirigir al AprendizResource
                ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
