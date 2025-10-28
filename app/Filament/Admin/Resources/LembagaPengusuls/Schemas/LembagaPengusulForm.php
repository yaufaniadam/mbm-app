<?php

namespace App\Filament\Admin\Resources\LembagaPengusuls\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class LembagaPengusulForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_lembaga')
                    ->required(),
                Textarea::make('alamat_lembaga')
                    ->required()
                    ->columnSpanFull(),
                Select::make('pimpinan_id')
                    ->relationship('pimpinan', 'name'),
            ]);
    }
}
