<?php

namespace App\Filament\Sppg\Resources\Volunteers\Pages;

use App\Filament\Sppg\Resources\Volunteers\VolunteerResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateVolunteer extends CreateRecord
{
    protected static string $resource = VolunteerResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();

        $organizationId = User::find($user->id)->unitTugas()->first()->id;

        return array_merge($data, ['sppg_id' => $organizationId]);
    }
}
