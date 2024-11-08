<?php

namespace App\Filament\Resources\InstructorSeguimientoResource\Pages;

use App\Filament\Resources\InstructorSeguimientoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Mail; 
use App\Mail\InstructorCredentials;

class CreateInstructorSeguimiento extends CreateRecord
{
    protected static string $resource = InstructorSeguimientoResource::class;

    protected function afterCreate() {
         $instructor = $this->record;  
         $randomPassword = Str::random(12); 

         $user = User::create([ 
            'name' => $instructor->nombres . ' ' . $instructor->apellidos,
            'email' => $instructor->correo_institucional, 
            'password' => Hash::make($randomPassword), 
        ]); 
        
        $user->assignRole('panel_user'); 
        $user->assignRole('instructor_seguimiento'); 
        
        $instructor->user_id = $user->id; 
        $instructor->save(); 
        
        Mail::to($instructor->correo_institucional)->send(new InstructorCredentials($user, $randomPassword)); 
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
