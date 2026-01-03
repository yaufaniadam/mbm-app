<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Models\Sppg;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        // If user is SPPG, attach their SPPG
        $user = Auth::user();
        if ($user->hasRole('Kepala SPPG')) {
            $sppg = Sppg::where('kepala_sppg_id', $user->id)->first();
            $data['sppg_id'] = $sppg?->id;
        }

        return $data;
    }
}
