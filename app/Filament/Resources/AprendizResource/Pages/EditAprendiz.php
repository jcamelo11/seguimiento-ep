<?php

namespace App\Filament\Resources\AprendizResource\Pages;

use App\Filament\Resources\AprendizResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAprendiz extends EditRecord
{
    protected static string $resource = AprendizResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\DeleteAction::make(),
        ];
    }
}
