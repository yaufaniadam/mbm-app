<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UsersForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
                TextInput::make('email')
                    ->label('email')
                    ->email()
                    ->required(),
                TextInput::make('telepon')
                    ->label('Telepon')
                    ->tel()
                    ->required(),
                Textarea::make('alamat')
                    ->label('Alamat')
                    ->required(),
                TextInput::make('nik')
                    ->label('NIK')
                    ->required(),
                Select::make('role')
                    ->label('Role')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->required(),

            ]);
    }
}
