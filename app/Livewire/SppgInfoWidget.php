<?php

namespace App\Livewire;

use App\Models\Sppg;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class SppgInfoWidget extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected int|string|array $columnSpan = 1;

    protected function getStats(): array
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $sppg = null;
        $isNationalView = false;

        if ($user->hasRole('Kepala SPPG')) {
            $sppg = User::find($user->id)->sppgDikepalai;
        } elseif ($user->hasAnyRole(['PJ Pelaksana', 'Ahli Gizi', 'Staf Administrator SPPG', 'Staf Akuntan', 'Staf Gizi', 'Staf Pengantaran'])) {
            $sppg = User::find($user->id)->unitTugas->first();
        } else {
            $sppgId = $this->pageFilters['sppg_id'] ?? null;
            if ($sppgId) {
                $sppg = Sppg::find($sppgId);
            } else {
                $isNationalView = true;
            }
        }

        return [
            $isNationalView
                ? Stat::make('Total SPPG Terdaftar', Sppg::count())
                    ->icon('heroicon-o-home-modern', IconPosition::Before)
                    ->description('Seluruh Indonesia')
                    ->color('primary')
                : Stat::make('Unit SPPG', $sppg->nama_sppg ?? 'N/A')
                    ->icon('heroicon-o-home', IconPosition::Before)
                    ->description($sppg->kepalaSppg->name ?? 'Dikelola oleh lembaga')
                    ->color('secondary'),
        ];
    }
}
