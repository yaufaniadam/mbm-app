<?php

namespace App\Filament\Production\Pages;

use Filament\Pages\Page;
use Illuminate\Support\HtmlString;

class Verify extends Page
{
    protected string $view = 'filament.production.pages.verify';

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-check-badge';
    }
}
