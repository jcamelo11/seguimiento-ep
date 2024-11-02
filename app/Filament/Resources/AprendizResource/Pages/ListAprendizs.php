<?php

namespace App\Filament\Resources\AprendizResource\Pages;

use App\Filament\Resources\AprendizResource;
use App\Models\Aprendiz;
use Filament\Forms\Components\FileUpload;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification; 
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AprendizImport;


class ListAprendizs extends ListRecords
{
    protected static string $resource = AprendizResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('AprendizImport')
            ->label('Importar')
            ->icon('heroicon-s-document-arrow-up')
            ->color('tertiary')
            ->form([
                FileUpload::make('attachment'),
            ])
            ->action(function(array $data) {
                try {
                    $file = public_path('storage/' . $data['attachment']);
            
                    Excel::import(new AprendizImport, $file);
            
                    Notification::make()
                        ->title('Éxito')
                        ->body('Los aprendices han sido importados correctamente')
                        ->success()
                        ->send();
                } catch (\Exception $e) {
                    Notification::make()
                        ->title('Error')
                        ->body('No se pudieron importar los aprendices: ' . $e->getMessage())
                        ->danger()
                        ->send();
                }
            }),
            

            Actions\Action::make('export')
            ->label('Exportar')
            ->icon('heroicon-s-document-arrow-down')
            ->color('secondary')
            ->action(function () {
                // Llamar a la exportación con Maatwebsite Excel
                return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\AprendizExport(), 'Cuadro de Seguimiento EP.xlsx');
            }),
            
            Actions\CreateAction::make()
            ->label('Nuevo Aprendiz')
            ->icon('heroicon-s-user-plus'),
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
