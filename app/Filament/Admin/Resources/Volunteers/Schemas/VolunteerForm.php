<?php

namespace App\Filament\Admin\Resources\Volunteers\Schemas;

use App\Models\Sppg;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VolunteerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('sppg_id')
                    ->label('Unit SPPG')
                    ->options(Sppg::pluck('nama_sppg', 'id'))
                    ->searchable()
                    ->required(),
                TextInput::make('nama_relawan')
                    ->label('Nama Lengkap')
                    ->required(),
                Select::make('gender')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ])
                    ->required(),
                TextInput::make('posisi')
                    ->label('Posisi/Jabatan')
                    ->helperText('Contoh: Juru Masak, Driver, Tenaga Kebersihan')
                    ->required(),
                TextInput::make('kontak')
                    ->label('Nomor WhatsApp/HP')
                    ->tel()
                    ->required(),
                Textarea::make('address')
                    ->label('Alamat Lengkap')
                    ->columnSpanFull(),
            ]);
    }
}
