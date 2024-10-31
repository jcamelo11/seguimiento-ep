<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Aval;
use Carbon\Carbon; // Asegúrate de importar Carbon

class AvalesPorMesChart extends ChartWidget
{
    protected static ?string $heading = 'Avales Por Mes';

    public ?string $filter = '2024';

    protected function getData(): array
    {
        $year = $this->filter;

        $data = Trend::model(Aval::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Avales por mes',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('F Y')), // Convierte a Carbon antes de formatear
        ];
    }

    protected function getFilters(): ?array
{
    return [
        2020 => '2020',
        2021 => '2021',
        2022 => '2022',
        2023 => '2023',
        2024 => '2024',
    ];
}

    protected function getType(): string
    {
        return 'bar';
    }
}
