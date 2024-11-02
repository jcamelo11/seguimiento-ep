<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Aval;
use Carbon\Carbon;

class AvalesPorMesChart extends ChartWidget
{
    protected static ?string $heading = 'Avales Por Mes';

    public ?string $filter = null;

    protected function setUp(): void
    {
        parent::setUp();

        // Establece el filtro al año actual si no está definido
        $this->filter = $this->filter ?? now()->year;
    }


    protected int | string | array $columnSpan = 2;

    protected function getData(): array
    {
        $year = $this->filter;

        // Ajustar el rango de fechas basado en el año seleccionado en el filtro
        $startOfYear = Carbon::createFromDate($year)->startOfYear();
        $endOfYear = Carbon::createFromDate($year)->endOfYear();

        $data = Trend::model(Aval::class)
            ->between(
                start: $startOfYear,
                end: $endOfYear,
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
            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('F')),
        ];
    }

    protected function getFilters(): ?array
    {
        $currentYear = now()->year;
        $startYear = 2021; // Puedes ajustar el año de inicio según tus necesidades
    
        $years = [];
        for ($year = $startYear; $year <= $currentYear; $year++) {
            $years[$year] = (string) $year;
        }
    
        return $years;
    }
    

    protected function getType(): string
    {
        return 'bar';
    }
}
