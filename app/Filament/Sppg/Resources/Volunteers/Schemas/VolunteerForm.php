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
                \Filament\Schemas\Components\Section::make('Informasi Relawan')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(2)
                            ->schema([
                                \Filament\Forms\Components\Select::make('user_id')
                                    ->label('Akun Pengguna Sistem')
                                    ->helperText('Hubungkan jika relawan butuh akses aplikasi (misal: Kurir)')
                                    ->options(\App\Models\User::pluck('name', 'id'))
                                    ->searchable()
                                    ->nullable(),
                                TextInput::make('nama_relawan')
                                    ->label('Nama Lengkap')
                                    ->required(),
                                TextInput::make('nik')
                                    ->label('NIK / Identitas')
                                    ->required(),
                                \Filament\Forms\Components\Select::make('gender')
                                    ->label('Jenis Kelamin')
                                    ->options([
                                        'L' => 'Laki-laki',
                                        'P' => 'Perempuan',
                                    ])
                                    ->required(),
                                \Filament\Forms\Components\Select::make('posisi')
                                    ->label('Jabatan')
                                    ->options([
                                        'Asisten Lapangan' => 'Asisten Lapangan',
                                        'Koordinator Bahan' => 'Koordinator Bahan',
                                        'Koordinator Masak' => 'Koordinator Masak',
                                        'Koordinator Pemorsian' => 'Koordinator Pemorsian',
                                        'Koordinator Pencucian' => 'Koordinator Pencucian',
                                        'Persiapan' => 'Persiapan',
                                        'Masak' => 'Masak',
                                        'Pemorsian' => 'Pemorsian',
                                        'Distribusi' => 'Distribusi',
                                        'Pencucian' => 'Pencucian',
                                        'Cleaning Service' => 'Cleaning Service',
                                    ])
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('category', $state)),
                                \Filament\Forms\Components\Hidden::make('category'),
                                TextInput::make('kontak')
                                    ->label('Nomor WhatsApp/HP')
                                    ->tel(),
                                TextInput::make('daily_rate')
                                    ->label('Upah per Hari (Rate)')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->helperText('Untuk estimasi payroll otomatis'),
                            ]),
                        Textarea::make('address')
                            ->label('Alamat Lengkap')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
