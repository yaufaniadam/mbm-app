<?php

namespace App\Filament\Sppg\Resources\ProductionSchedules\Pages;

use App\Filament\Sppg\Resources\ProductionSchedules\ProductionScheduleResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditProductionSchedule extends EditRecord
{
    protected static string $resource = ProductionScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
