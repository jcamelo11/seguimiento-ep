<?php

namespace App\Filament\Resources\InstructorseguimientoResource\Pages;

use App\Filament\Resources\InstructorseguimientoResource;
use App\Models\InstructorSeguimiento;
use App\Models\Aprendiz;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;

class InstructorSeguimientoEstado extends Page
{
    protected static string $resource = InstructorseguimientoResource::class;

    protected static string $view = 'filament.resources.instructorseguimiento-resource.pages.instructor-seguimiento-estado';


    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Instructores X Estado';
    protected static ?string $navigationLabel = 'Instructores X Estado';
    protected static ?string $title = 'Instructores X Estado';
    protected static ?int $navigationSort = -1;



    // Obtener datos de los instructores y aprendices
    public function getInstructoresData()
    {
        // Consultar instructores y contar aprendices por estado
        return InstructorSeguimiento::withCount([
            'aprendices as total_asignados',
            'aprendices as total_activos' => function ($query) {
                $query->where('estado', 'Activo');
            },
            'aprendices as total_por_certificar' => function ($query) {
                $query->where('estado', 'Por Certificar');
            },
            'aprendices as total_certificados' => function ($query) {
                $query->where('estado', 'Certificado');
            },
            'aprendices as total_retirados_cancelados' => function ($query) {
                $query->where('estado', 'Cancelado/Retirado');
            },
        ])->get();
    }
}
