<?php

namespace App\Filament\Exports;

use App\Models\Aprendiz;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class AprendizExporter extends Exporter
{
    protected static ?string $model = Aprendiz::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id'),
            ExportColumn::make('nombres'),
            ExportColumn::make('apellidos'),
            ExportColumn::make('celular1'),
            ExportColumn::make('celular2'),
            ExportColumn::make('correo_personal'),
            ExportColumn::make('correo_institucional'),


        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your aprendiz export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
