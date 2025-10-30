<?php

namespace App\Filament\Production\Pages;

use App\Models\ProductionSchedule;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

class Verify extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.production.pages.verify';

    protected ?string $heading = '';

    public ?array $data = [];

    public $menuData = null;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-check-badge';
    }

    public function getFormSchema()
    {
        return [
            // TextEntry::make('menu_hari_ini')->color('primary'),
            Select::make('status')
                ->options([
                    "Ditolak" => "Ditolak",
                    "Terverifikasi" => "Terverifikasi",
                ])
        ];
    }

    public function mount()
    {
        $user = Auth::user();

        $organizationId = $user->unitTugas()->first()->id;

        $this->menuData = ProductionSchedule::where('sppg_id', $organizationId)->first();
    }
}
