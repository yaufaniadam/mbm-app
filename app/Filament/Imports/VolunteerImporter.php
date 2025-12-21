<?php

namespace App\Filament\Imports;

use App\Models\Sppg;
use App\Models\Volunteer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Filament\Forms\Components\Select;
use Illuminate\Support\Number;

class VolunteerImporter extends Importer
{
    protected static ?string $model = Volunteer::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('posisi')
                ->label('Jabatan')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nama_relawan')
                ->label('Nama')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('daily_rate')
                ->label('Honor')
                ->requiredMapping()
                ->castStateUsing(function ($state) {
                    // Clean Indonesian number format (remove dots as thousand separators)
                    $cleaned = str_replace(['.', ',', ' '], '', trim($state ?? ''));
                    return (int) $cleaned;
                }),
            ImportColumn::make('nik')
                ->label('NIK')
                ->rules(['max:255']),
            ImportColumn::make('gender')
                ->label('JK')
                ->rules(['max:255']),
            ImportColumn::make('kontak')
                ->label('HP')
                ->rules(['max:255']),
            ImportColumn::make('address')
                ->label('Alamat'),
        ];
    }

    public static function getOptionsFormComponents(): array
    {
        return [
            Select::make('sppg_id')
                ->label('Unit SPPG')
                ->options(Sppg::pluck('nama_sppg', 'id'))
                ->required()
                ->searchable()
                ->helperText('Pilih SPPG tujuan impor relawan'),
        ];
    }

    public function resolveRecord(): Volunteer
    {
        $volunteer = new Volunteer();

        if (isset($this->options['sppg_id'])) {
            $volunteer->sppg_id = $this->options['sppg_id'];
        }

        return $volunteer;
    }

    protected function afterFill(): void
    {
        // Category = Jabatan (apa adanya)
        $this->record->category = $this->record->posisi ?? '';
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Impor relawan telah selesai. ' . Number::format($import->successful_rows) . ' data berhasil diimpor.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' data gagal diimpor.';
        }

        return $body;
    }
}
