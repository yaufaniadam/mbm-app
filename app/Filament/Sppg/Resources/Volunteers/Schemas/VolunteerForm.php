<?php

namespace App\Filament\Sppg\Resources\Volunteers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VolunteerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_relawan')
                    ->label('Nama Relawan')
                    ->required(),
                TextInput::make('posisi')
                    ->label('Posisi')
                    ->required(),
                TextInput::make('kontak')
                    ->label('No HP')
                    ->tel()
                    ->required(),
            ]);
    }
}
