<?php

namespace App\Filament\Resources\InstructorSeguimientoResource\Pages;

use App\Filament\Resources\InstructorSeguimientoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateInstructorSeguimiento extends CreateRecord
{
    protected static string $resource = InstructorSeguimientoResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        $this->redirect($this->getRedirectUrl());
    }
}
