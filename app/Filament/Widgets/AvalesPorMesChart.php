<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Aval;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        $years = DB::table('avales')
            ->selectRaw('DISTINCT YEAR(created_at) as year')
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->mapWithKeys(function ($year) {
                return [$year => (string) $year];
            })
            ->toArray();
    
        return $years ?: null;
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
