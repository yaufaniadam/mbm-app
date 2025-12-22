<?php

namespace App\Livewire;

use App\Models\ProductionSchedule;
use App\Models\Sppg;
use App\Models\User;
use Carbon\Carbon;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class SppgTopStatsWidget extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected int|string|array $columnSpan = 'full';

    protected function getColumns(): int
    {
        return 3;
    }

    protected function getStats(): array
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user) return [];

        $sppg = null;
        $isNationalView = false;

        // 1. Get SPPG Data
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

        $stats = [];

        // 2. Info Stat (Wide: 2/3)
        $infoStat = $isNationalView
            ? Stat::make('Total SPPG Terdaftar', Sppg::count())
                ->icon('heroicon-o-home-modern', IconPosition::Before)
                ->description('Seluruh Indonesia')
                ->color('primary')
            : Stat::make('Unit SPPG', $sppg->nama_sppg ?? 'N/A')
                ->icon('heroicon-o-home', IconPosition::Before)
                ->description($sppg->kepalaSppg->name ?? 'Dikelola oleh lembaga')
                ->color('secondary');

        // 3. Alert Logic
        $sppgIdForAlert = $sppg?->id;
        $pendingCount = 0;
        if ($sppgIdForAlert) {
            $pendingCount = ProductionSchedule::where('sppg_id', $sppgIdForAlert)
                ->where('status', 'Direncanakan')
                ->whereDate('tanggal', '<=', Carbon::today())
                ->count();
        }

        if ($pendingCount > 0) {
            // SPPG Info takes 2 columns, Alert takes 1 column
            $infoStat->extraAttributes(['class' => 'md:col-span-2']);
            $stats[] = $infoStat;
            
            $stats[] = Stat::make('Perhatian', "$pendingCount Rencana Distribusi")
                ->description('Belum diverifikasi. Segera lengkapi menu.')
                ->descriptionIcon('heroicon-s-exclamation-triangle')
                ->color('warning')
                ->extraAttributes([
                    'class' => 'cursor-pointer md:col-span-1',
                    'onclick' => "window.location.href = '/sppg/production-schedules'",
                ]);
        } else {
            // No alert? Make Info full width (3 columns)
            $infoStat->extraAttributes(['class' => 'md:col-span-3']);
            $stats[] = $infoStat;
        }

        return $stats;
    }
}
