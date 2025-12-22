<?php

namespace App\Filament\Admin\Resources\Holidays\Pages;

use App\Filament\Admin\Resources\Holidays\HolidayResource;
use App\Filament\Imports\HolidayImporter;
use App\Models\Holiday;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListHolidays extends ListRecords
{
    protected static string $resource = HolidayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            
            // Multi-day action - for adding date ranges
            Action::make('addMultipleDays')
                ->label('Tambah Rentang Tanggal')
                ->icon('heroicon-o-calendar-days')
                ->color('info')
                ->form([
                    TextInput::make('nama')
                        ->label('Nama Hari Libur')
                        ->required()
                        ->placeholder('Contoh: Cuti Bersama Idul Fitri'),
                    DatePicker::make('tanggal_mulai')
                        ->label('Tanggal Mulai')
                        ->required(),
                    DatePicker::make('tanggal_selesai')
                        ->label('Tanggal Selesai')
                        ->required()
                        ->afterOrEqual('tanggal_mulai'),
                ])
                ->action(function (array $data) {
                    $start = Carbon::parse($data['tanggal_mulai']);
                    $end = Carbon::parse($data['tanggal_selesai']);
                    $period = CarbonPeriod::create($start, $end);
                    
                    $created = 0;
                    $skipped = 0;
                    
                    foreach ($period as $date) {
                        // Skip if already exists
                        if (Holiday::whereDate('tanggal', $date)->exists()) {
                            $skipped++;
                            continue;
                        }
                        
                        Holiday::create([
                            'tanggal' => $date,
                            'nama' => $data['nama'],
                        ]);
                        $created++;
                    }
                    
                    Notification::make()
                        ->title('Hari libur berhasil ditambahkan')
                        ->body("{$created} hari libur dibuat. {$skipped} hari sudah ada sebelumnya.")
                        ->success()
                        ->send();
                }),
            
            // Import CSV action
            ImportAction::make()
                ->importer(HolidayImporter::class)
                ->label('Import CSV'),
        ];
    }
}
