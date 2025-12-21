<?php

namespace App\Filament\Admin\Resources\Volunteers\Pages;

use App\Filament\Admin\Resources\Volunteers\RelawanResource;
use App\Filament\Imports\VolunteerImporter;
use App\Models\Sppg;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;

class ListRelawan extends ListRecords
{
    protected static string $resource = RelawanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->importer(VolunteerImporter::class)
                ->form([
                    Select::make('sppg_id')
                        ->label('Unit SPPG')
                        ->options(Sppg::pluck('nama_sppg', 'id'))
                        ->required()
                        ->searchable()
                        ->helperText('Pilih SPPG tujuan impor relawan'),
                ])
                ->options(fn (array $data) => [
                    'sppg_id' => $data['sppg_id'],
                ]),
            CreateAction::make(),
        ];
    }
}
