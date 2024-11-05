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
use Illuminate\Support\Facades\Gate;


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
            })->visible(fn () => Gate::allows('importar_aprendiz')),
            

            Actions\Action::make('export')
            ->label('Exportar')
            ->icon('heroicon-s-document-arrow-down')
            ->color('secondary')
            ->action(function () {
                // Llamar a la exportación con Maatwebsite Excel
                return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\AprendizExport(), 'Cuadro de Seguimiento EP.xlsx');
            })->visible(fn () => Gate::allows('exportar_aprendiz')),
            
            Actions\CreateAction::make()
            ->label('Nuevo Aprendiz')
            ->icon('heroicon-s-user-plus'),
        ];
    }

    public function getTabs () : array 
    {
        return [
            null => Tab::make('All')->badge($this->aprendicesPorEstado() ?? 0)->label('Total Aprendices'),

            'Activo' => Tab::make()->query(fn ($query) => $query->where('estado', 'ACTIVO'))->badge($this->aprendicesPorEstado('ACTIVO') ?? 0)->badgeColor('info'),

            'Por Certificar' => Tab::make()->query(fn ($query) => $query->where('estado', 'POR CERTIFICAR'))->badge($this->aprendicesPorEstado('POR CERTIFICAR') ?? 0)->badgeColor('warning'),

            'Certificado' => Tab::make()->query(fn ($query) => $query->where('estado', 'CERTIFICADO'))->badge($this->aprendicesPorEstado('CERTIFICADO') ?? 0),
            
            'Cancelado/Retirado' => Tab::make()->query(fn ($query) => $query->where('estado', 'CANCELADO/RETIRADO'))->badge($this->aprendicesPorEstado('CANCELADO/RETIRADO') ?? 0)->badgeColor('danger'),
        ];
    }

    private function aprendicesPorEstado(string $estado = null){
        if(blank($estado)){
            return Aprendiz::count();
        }
        return Aprendiz::where('estado', $estado)->count();
    }
}
