<?php

namespace App\Filament\Sppg\Resources\Volunteers\Schemas;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
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
                Radio::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ])
                    ->required(),
                TextInput::make('posisi')
                    ->label('Posisi')
                    ->required(),
                TextInput::make('kontak')
                    ->label('No HP')
                    ->tel()
                    ->required(),
                Textarea::make('address')
                    ->label('Alamat')
                    ->rows(3),
            ]);
    }
}
