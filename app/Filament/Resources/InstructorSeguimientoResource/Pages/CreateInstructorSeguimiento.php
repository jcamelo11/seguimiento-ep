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

    protected function afterCreate() { 
        $instructor = $this->record; 
        $user = User::create([ 
            'name' => $instructor->nombres . ' ' . $instructor->apellidos,
            'email' => $instructor->correo_institucional, 
            'password' => Hash::make('password_secreta'), 
        ]); // Asignar el usuario al instructor $instructor->user()->associate($user); $instructor->save(); }
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
