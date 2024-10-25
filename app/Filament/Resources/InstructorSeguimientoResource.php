<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstructorSeguimientoResource\Pages;
use App\Filament\Resources\InstructorSeguimientoResource\RelationManagers;
use App\Models\InstructorSeguimiento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;

class InstructorSeguimientoResource extends Resource
{
    protected static ?string $model = InstructorSeguimiento::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $label = 'Instructor';
    protected static ?string $pluralLabel = 'Instructores';
    protected static ?string $slug = 'Instructores';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)
                ->schema([
                    Forms\Components\TextInput::make('nombres')
                        ->label('Nombres')
                        ->required(),
                    Forms\Components\TextInput::make('apellidos')
                        ->label('Apellidos')
                        ->required(),
                    Forms\Components\TextInput::make('correo_personal')
                        ->label('Correo')
                        ->email()
                        ->required(),
                    Forms\Components\TextInput::make('telefono')
                        ->label('Número de Telefono')
                        ->required(),
                    Forms\Components\TextInput::make('area')
                        ->label('Area'),
                    Forms\Components\TextInput::make('profesion')
                        ->label('Profesión'),
                    Forms\Components\Select::make('tipo_contrato')
                        ->label('Tipo de Contrato')
                        ->options([
                            'Planta' => 'Planta',
                            'Contratista' => 'Contratista',
                        ])
                        ->required(),
                        
                ])
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombres')
                    ->label('Nombres'),
                TextColumn::make('apellidos')
                    ->label('Apellidos'),
                TextColumn::make('correo_personal')
                    ->label('Correo Electrónico'),
                TextColumn::make('telefono')
                    ->label('N° de Telefono'),
                BadgeColumn::make('tipo_contrato') 
                    ->label('Tipo de Contrato')
                    ->colors([
                        'primary' => 'Contratista',
                        'info' => 'Planta',
                        
                    ]),
                    TextColumn::make('aprendices_count')
                    ->label('Aprendices asignados')
                    ->counts('aprendices'),
            
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\AprendicesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInstructorSeguimientos::route('/'),
            'create' => Pages\CreateInstructorSeguimiento::route('/create'),
            'edit' => Pages\EditInstructorSeguimiento::route('/{record}/edit'),
            'seguimiento-estado' => Pages\InstructorSeguimientoEstado::route('/estado'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) InstructorSeguimiento::count();
    }
}
