<?php

namespace App\Filament\Sppg\Widgets;

use App\Models\VolunteerDailyAttendance;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use App\Filament\Sppg\Pages\DailyAttendance;
use Illuminate\Support\Facades\Auth;

class DailyAttendanceStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return DailyAttendance::class;
    }

    protected function getStats(): array
    {
        // Access the Livewire component (Page) to get the property
        // InteractsWithPageTable provides $this->tablePage which is the Livewire component instance?
        // Wait, InteractsWithPageTable usually expects the widget to be used on a ListRecords page or similar.
        // On a custom page, we need to bind it.
        // Let's check if $this->livewire is available or how to access the parent.
        // Actually, InteractsWithPageTable relies on the widget being mounted with 'tablePage' or similar?
        // Let's assume the page instance is available via $this->getData()['page'] if I pass it?
        // Or simpler: $this->livewire is the widget itself.

        // If I use InteractsWithPageTable, it looks for $this->tablePage.
        // But the Page needs to pass it?
        // "getHeaderWidgets()" just returns classes.

        // Let's try to access the property dynamically if possible.
        // If this is too complex for now, I will define the stats on the Page class directly if Filament allows (some versions do).
        // But sticking to Widget:
        // I will rely on the page passing the filter? No.

        // CORRECT APPROACH FOR CUSTOM PAGE STATS:
        // Just calculate it here using the same default logic (today) or if I can access the page property.
        // Since I cannot easily guarantee access to the Page instance from a Header Widget (which is a separate Livewire component)
        // without complex hydration setup, I will assume 'today' for simplicity OR better:
        // I will put the logic in `getStats()` of `DailyAttendance.php` if it was a Resource List page, but it's a generic Page.

        // Alternative: Use `getFooterWidgets()` or just render the stats in the Blade view using `@livewire('filament.sppg.widgets.daily-attendance-stats', ['selectedDate' => $selected_date])`?
        // No, `getHeaderWidgets` renders them.

        // Let's try to pass the data via `getHeaderWidgetsData` in the Page.
        // And accepts it here.

        $date = $this->selectedDate ?? now()->format('Y-m-d');

        $user = Auth::user();
        $sppgId = null;

        if ($user->hasRole('Kepala SPPG')) {
            $sppgId = $user->sppgDikepalai?->id;
        } elseif ($user->hasRole('PJ Pelaksana')) {
            $sppgId = $user->unitTugas->first()?->id;
        }

        $query = VolunteerDailyAttendance::query()
            ->where('attendance_date', $date);

        if ($sppgId) {
            $query->where('sppg_id', $sppgId);
        }

        $stats = $query->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return [
            Stat::make('Hadir', $stats['Hadir'] ?? 0)
                ->color('success'),
            Stat::make('Izin', $stats['Izin'] ?? 0)
                ->color('warning'),
            Stat::make('Sakit', $stats['Sakit'] ?? 0)
                ->color('danger'),
            Stat::make('Alpha', $stats['Alpha'] ?? 0)
                ->color('danger'),
        ];
    }

    // Add a public property to accept the data
    public ?string $selectedDate = null;
}
