<?php

namespace App\Filament\Resources\ProductionSchedules\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductionScheduleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('tanggal')
                    ->label('Tanggal')
                    ->date(),
                TextEntry::make('menu_hari_ini')
                    ->label('Menu Hari Ini'),
                TextEntry::make('status')
                    ->label('Status')
                    ->badge() // This line makes it a badge
                    ->color(static function (string $state): string {
                        // Dynamically set color based on the status value
                        return match ($state) {
                            'Direncanakan' => 'warning',
                            'Berlangsung' => 'info',
                            'Selesai' => 'success',
                            'Dibatalkan' => 'danger',
                            default => 'gray',
                        };
                    })
                    ->icon(static function (string $state): string {
                        // Dynamically set an icon based on the status value
                        return match ($state) {
                            'Direncanakan' => 'heroicon-o-clock',
                            'Berlangsung' => 'heroicon-o-arrow-path',
                            'Selesai' => 'heroicon-o-check-circle',
                            'Dibatalkan' => 'heroicon-o-x-circle',
                            default => 'heroicon-o-question-mark-circle',
                        };
                    }),
            ])
            ->columns(1);
    }
}
