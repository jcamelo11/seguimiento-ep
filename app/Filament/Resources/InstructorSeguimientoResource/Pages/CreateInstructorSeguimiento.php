<?php

namespace App\Filament\Resources\InstructorSeguimientoResource\Pages;

use App\Filament\Resources\InstructorSeguimientoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateInstructorSeguimiento extends CreateRecord
{
    protected static string $resource = InstructorSeguimientoResource::class;

    protected function afterCreate()
    { 
        $instructor = $this->record;
    
        // Crear un usuario para el instructor
        $user = User::create([ 
            'name' => $instructor->nombres . ' ' . $instructor->apellidos,
            'email' => $instructor->correo_institucional, 
            'password' => Hash::make('password_secreta'), 
        ]);
    
        // Asociar el usuario al instructor
        $instructor->user_id = $user->id;
        $instructor->save();
    }
    

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    
    protected function afterSave(): void
    {
        $this->redirect($this->getRedirectUrl());
    }
}
