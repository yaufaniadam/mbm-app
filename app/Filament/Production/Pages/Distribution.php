<?php

namespace App\Filament\Production\Pages;

use App\Models\FoodVerification;
use App\Models\ProductionSchedule;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Distribution extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.production.pages.distribution';
    protected static ?string $navigationLabel = 'Pengantaran';
    protected ?string $heading = '';

    public ?array $data = [];
    public ?ProductionSchedule $record = null;
    protected bool $isEditable = true;
    protected ?FoodVerification $verificationNote = null;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-truck';
    }

    public function mount(): void
    {
        $user = Auth::user();
        $organizationId = $user->unitTugas()->first()->id;

        $this->record = ProductionSchedule::where([
            ['sppg_id', $organizationId],
            ['status', 'Terverifikasi'],
        ])->with('sppg', 'sppg.schools')
            ->latest()
            ->first();

        if (! $this->record) {
            Notification::make()
                ->title('Data tidak ditemukan.')
                ->danger()
                ->send();
            return;
        }


        $this->isEditable = $this->record->status === 'Direncanakan';

        // load previous verification note if exists
        $this->verificationNote = FoodVerification::where('jadwal_produksi_id', $this->record->id)->latest()->first();

        $this->form->fill([
            'status' => $this->record->status,
            'catatan' => $this->verificationNote?->catatan,
        ]);
    }
}
