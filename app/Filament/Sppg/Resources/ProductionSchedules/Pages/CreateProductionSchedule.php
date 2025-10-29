<?php

namespace App\Filament\Sppg\Resources\ProductionSchedules\Pages;

use App\Filament\Sppg\Resources\ProductionSchedules\ProductionScheduleResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateProductionSchedule extends CreateRecord
{
    protected static string $resource = ProductionScheduleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();

        $sppgId = User::find($user->id)->unitTugas()->first()->id;

        $data['sppg_id'] = $sppgId;
        return $data;
    }
}
