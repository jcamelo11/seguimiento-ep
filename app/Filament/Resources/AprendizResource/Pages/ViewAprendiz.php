<?php

namespace App\Filament\Resources\AprendizResource\Pages;

use App\Filament\Resources\AprendizResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAprendiz extends ViewRecord
{
    protected static string $resource = AprendizResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
            ->icon('heroicon-s-pencil')
            ->label('Editar'),
        ];
    }
}
