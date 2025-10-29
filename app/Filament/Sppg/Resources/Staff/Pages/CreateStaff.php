<?php

namespace App\Filament\Sppg\Resources\Staff\Pages;

use App\Filament\Sppg\Resources\Staff\StaffResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateStaff extends CreateRecord
{
    protected static string $resource = StaffResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = 'p4$$w0rd'; // Set default password
        return $data;
    }

    protected function afterCreate(): void
    {
        $record = $this->record;
        $manager = Auth::user();

        $organizationId = $manager->unitTugas()->first()?->id;

        if ($organizationId) {
            DB::table('sppg_user_roles')->insert(
                [
                    'user_id' => $record->id,
                    'sppg_id' => $organizationId,
                ],
            );
        }
        // if ($organizationId) {
        //     DB::table('sppg_user_roles')->upsert(
        //         [
        //             [
        //                 'user_id' => $record->id,
        //                 'sppg_id' => $organizationId,
        //             ],
        //         ],
        //         ['user_id'], // unique key
        //         ['sppg_id'] // columns to update if exists
        //     );
        // }
    }
}
