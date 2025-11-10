<?php

namespace App\Filament\Sppg\Resources\Staff\Pages;

use App\Filament\Sppg\Resources\Staff\StaffResource;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CreateStaff extends CreateRecord
{
    protected static string $resource = StaffResource::class;

    public function mount(): void
    {
        $user = User::find(Auth::user()->id);

        $sppgId = $user->sppgDiKepalai?->id;

        if (!$sppgId) {
            Notification::make()
                ->title('Anda tidak memiliki akses ke halaman ini. Hubungi admin.')
                ->danger()
                ->send();

            $this->redirect($this->getResource()::getUrl('index'));
        }

        parent::mount();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = User::find(Auth::user()->id);

        $sppg = $user->sppgDiKepalai;

        if (!$sppg) {
            Notification::make()
                ->title('Anda belum ditugaskan ke sppg. Hubungi admin.')
                ->danger()
                ->send();

            throw ValidationException::withMessages([
                'sppg' => 'Anda belum ditugaskan ke sppg. Hubungi admin.',
            ]);
        }

        $data['password'] = 'p4$$w0rd'; // Set default password
        return $data;
    }

    protected function afterCreate(): void
    {
        $record = $this->record;
        $user = User::find(Auth::user()->id);

        $sppgId = $user->sppgDiKepalai?->id;

        if ($sppgId) {
            DB::table('sppg_user_roles')->insert(
                [
                    'user_id' => $record->id,
                    'sppg_id' => $sppgId,
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
