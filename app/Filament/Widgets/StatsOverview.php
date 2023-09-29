<?php

namespace App\Filament\Widgets;

use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $total = SuratMasuk::all()->count() + SuratKeluar::all()->count();

        return [
            Stat::make('Total Surat',$total),
            Stat::make('Surat Masuk',SuratMasuk::all()->count()),
            Stat::make('Surat Keluar',SuratKeluar::all()->count()),
        ];
    }
}
