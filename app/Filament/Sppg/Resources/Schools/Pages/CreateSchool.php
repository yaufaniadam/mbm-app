<?php

namespace App\Filament\Sppg\Resources\Schools\Pages;

use App\Filament\Sppg\Resources\Schools\SchoolResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateSchool extends CreateRecord
{
    protected static string $resource = SchoolResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();

        $organizationId = User::find($user->id)->unitTugas()->first()->id;

        $data['sppg_id'] = $organizationId;
        return $data;
    }
}
