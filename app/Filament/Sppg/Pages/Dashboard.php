<?php

namespace App\Filament\Sppg\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    // protected string $view = 'filament.pages.dashboard';



    public function getColumns(): int | array
    {
        return 2;
    }
}
