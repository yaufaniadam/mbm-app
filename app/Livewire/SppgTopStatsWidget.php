<?php

namespace App\Livewire;

use App\Models\ProductionSchedule;
use App\Models\Sppg;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class SppgTopStatsWidget extends Widget
{
    use InteractsWithPageFilters;

    protected static string $view = 'livewire.sppg-top-stats-widget';

    protected int|string|array $columnSpan = 'full';

    public $sppg;
    public $isNationalView = false;
    public $pendingCount = 0;

    public function getData()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user) return;

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

        $pendingCount = 0;
        if ($sppg) {
            $pendingCount = ProductionSchedule::where('sppg_id', $sppg->id)
                ->where('status', 'Direncanakan')
                ->whereDate('tanggal', '<=', Carbon::today())
                ->count();
        }

        return [
            'sppg' => $sppg,
            'isNationalView' => $isNationalView,
            'pendingCount' => $pendingCount,
        ];
    }

    protected function getViewData(): array
    {
        return $this->getData();
    }
}
