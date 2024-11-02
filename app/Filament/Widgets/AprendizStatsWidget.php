<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Aprendiz;
use App\Models\Aval;
use Carbon\Carbon;

class AprendizStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $newAprendicesLastMonth = Aprendiz::where('created_at', '>=', Carbon::now()->subMonth())->count();

        $avalesLastMonth = Aval::where('created_at', '>=', Carbon::now()->subMonth())->count();

        return [
            Stat::make('Total Aprendices', Aprendiz::count())
            ->color('primary')
            ->description($newAprendicesLastMonth . '  nuevos aprendices este mes')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75, 80, 85, 90, 95, 100]),


            Stat::make('Aprendices en seguimiento', Aprendiz::where('estado', 'Activo')->count())
            ->description('Activos')
            ->descriptionIcon('heroicon-o-sparkles')
            ->color('info'),

            Stat::make('Avales', $avalesLastMonth)
            ->color('primary')
            ->description('Avales generado el ultimo mes')
            ->descriptionIcon('heroicon-o-document-check')
            ->chart([5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75, 80, 85, 90, 95, 100]),


        ];
    }
}
