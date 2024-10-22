<?php

namespace App\Filament\Resources\AprendizResource\Pages;

use App\Filament\Resources\AprendizResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\ButtonAction;

class CreateAprendiz extends CreateRecord
{
    
    protected static string $resource = AprendizResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        $this->redirect($this->getRedirectUrl());
    }

    
}
