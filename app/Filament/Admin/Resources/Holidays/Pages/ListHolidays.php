<?php

namespace App\Filament\Admin\Resources\Holidays\Pages;

use App\Filament\Admin\Resources\Holidays\HolidayResource;
use Filament\Resources\Pages\ListRecords;

class ListHolidays extends ListRecords
{
    protected static string $resource = HolidayResource::class;
}
