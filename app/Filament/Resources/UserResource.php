<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Password;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Columns\BadgeColumn;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationGroup = 'Usuarios';
    protected static ?int $navigationSort = -1;
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detalles del usuarios')
                ->schema([
                    TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),

                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->maxLength(255),

                    // Para la creación del usuario, el campo de contraseña es obligatorio
                    TextInput::make('password')
                        ->label('Contraseña')
                        ->password()
                        ->required(fn ($livewire) => $livewire instanceof Pages\CreateUser)
                        ->minLength(8)
                        ->maxLength(255)
                        ->revealable()
                        ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                        ->visibleOn('create')
                        ->validationAttribute('password'),

                    Forms\Components\Select::make('roles')
                        ->relationship('roles', 'name')
                        ->multiple()
                        ->preload()
                        ->searchable()
                ])->columns(2),

                Forms\Components\Section::make('Nueva contraseña')
                    ->schema([
                        // En el modo de edición, el campo de contraseña es opcional y permite confirmación
                        TextInput::make('new_password')
                            ->label('Nueva contraseña')
                            ->password()
                            ->nullable()
                            ->minLength(8)
                            ->maxLength(255)
                            ->revealable()
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                            ->visibleOn('edit')
                            ->same('new_password_confirmation')
                            ->validationAttribute('new password'),

                        TextInput::make('new_password_confirmation')
                            ->label('Confirmar contraseña')
                            ->password()
                            ->nullable()
                            ->revealable()
                            ->minLength(8)
                            ->maxLength(255)
                            ->visibleOn('edit')
                            ->validationAttribute('new password confirmation'),
                    ])->visibleOn('edit')
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                BadgeColumn::make('roles.name')  
                    ->label('Rol'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ,
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
