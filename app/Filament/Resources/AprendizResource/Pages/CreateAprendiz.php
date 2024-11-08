<?php

namespace App\Filament\Resources\AprendizResource\Pages;

use App\Filament\Resources\AprendizResource;
use Filament\Actions;
use App\Models\Aprendiz;
use App\Models\ProgramaFormacion;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\ButtonAction;
use Filament\Notifications\Notification; 

class CreateAprendiz extends CreateRecord
{
    
    protected static string $resource = AprendizResource::class;

    protected function beforeValidate()
    {
        $numeroFicha = $this->data['ficha'] ?? null; // Este es el número de ficha ingresado
        $documento = $this->data['numero_documento'] ?? null;
    
        if ($numeroFicha && $documento) {
            // Buscar el ID del programa de formación con el número de ficha proporcionado
            $programaFormacion = ProgramaFormacion::where('ficha', $numeroFicha)->first();
    
            if ($programaFormacion) {
                $fichaId = $programaFormacion->id;
    
                // Verificar si ya existe un aprendiz con ese documento y programa de formación
                $aprendizExistente = Aprendiz::where('numero_documento', $documento)
                    ->where('programa_formacion_id', $fichaId)
                    ->first();
    
                // Si el aprendiz ya está registrado en este programa, mostrar notificación
                if ($aprendizExistente) {
                    Notification::make()
                        ->title('Registro duplicado')
                        ->body('El aprendiz ya está registrado en esta ficha.')
                        ->warning()
                        ->send();
    
                    // Detener la validación para evitar el registro duplicado
                    $this->halt();
                }
            } else {
                // Notificación si el número de ficha no existe en la base de datos
                Notification::make()
                    ->title('Ficha no encontrada')
                    ->body('El número de ficha proporcionado no existe en los programas de formación.')
                    ->danger()
                    ->send();
    
                $this->halt();
            }
        }
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
