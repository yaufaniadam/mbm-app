<?php

namespace App\Filament\Admin\Resources\LembagaPengusuls\Pages;

use App\Filament\Admin\Resources\LembagaPengusuls\LembagaPengusulResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLembagaPengusul extends EditRecord
{
    protected static string $resource = LembagaPengusulResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
