<?php

namespace App\Filament\Resources\InstructorSeguimientoResource\Pages;

use App\Filament\Resources\InstructorSeguimientoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInstructorSeguimiento extends EditRecord
{
    protected static string $resource = InstructorSeguimientoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\DeleteAction::make(),
        ];
    }
}
