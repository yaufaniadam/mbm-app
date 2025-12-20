<?php

namespace App\Filament\Admin\Resources\Volunteers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VolunteersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_relawan')
                    ->label('Nama Relawan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('posisi')
                    ->label('Posisi')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('gender')
                    ->label('L/P')
                    ->sortable(),
                TextColumn::make('sppg.nama_sppg')
                    ->label('Unit SPPG')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('kontak')
                    ->label('Kontak'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
