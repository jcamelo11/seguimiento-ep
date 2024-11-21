<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\InstructorSeguimiento;
use App\Models\Aprendiz;
use Illuminate\Support\Facades\Gate;

class InstructorPorEstado extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Instructores X Estado';
    protected static ?string $title = 'Instructores por estado';
    protected static ?int $navigationSort = 4;

    protected static string $view = 'filament.pages.instrutor-por-estado';

    
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
