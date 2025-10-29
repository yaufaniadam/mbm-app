<?php

namespace App\Filament\Sppg\Resources\ProductionSchedules\Pages;

use App\Filament\Sppg\Resources\ProductionSchedules\ProductionScheduleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProductionSchedules extends ListRecords
{
    protected static string $resource = ProductionScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
