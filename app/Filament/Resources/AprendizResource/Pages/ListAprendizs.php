<?php

namespace App\Filament\Resources\AprendizResource\Pages;

use App\Filament\Resources\AprendizResource;
use App\Models\Aprendiz;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;


class ListAprendizs extends ListRecords
{
    protected static string $resource = AprendizResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Nuevo Aprendiz'),
        ];
    }

    public function getTabs () : array 
    {
        return [
            null => Tab::make('All')->badge($this->aprendicesPorEstado() ?? 0)->label('Total Aprendices'),
            'Activo' => Tab::make()->query(fn ($query) => $query->where('estado', 'Activo'))->badge($this->aprendicesPorEstado('Activo') ?? 0)->badgeColor('info'),
            'Por Certificar' => Tab::make()->query(fn ($query) => $query->where('estado', 'Por Certificar'))->badge($this->aprendicesPorEstado('Por Certificar') ?? 0)->badgeColor('warning'),
            'Certificado' => Tab::make()->query(fn ($query) => $query->where('estado', 'Certificado'))->badge($this->aprendicesPorEstado('Certificado') ?? 0),
            'Cancelado/Retirado' => Tab::make()->query(fn ($query) => $query->where('estado', 'Cancelado/Retirado'))->badge($this->aprendicesPorEstado('Cancelado/Retirado') ?? 0)->badgeColor('danger'),
        ];
    }

    private function aprendicesPorEstado(string $estado = null){
        if(blank($estado)){
            return Aprendiz::count();
        }
        return Aprendiz::where('estado', $estado)->count();
    }
}
