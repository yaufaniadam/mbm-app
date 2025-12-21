<?php

namespace App\Filament\Imports;

use App\Models\Volunteer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class VolunteerImporter extends Importer
{
    protected static ?string $model = Volunteer::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('sppg')
                ->label('Unit SPPG')
                ->relationship()
                ->requiredMapping(fn ($livewire) => !isset($livewire->options['sppg_id']))
                ->rules(['required_without_options:sppg_id']),
            ImportColumn::make('nama_relawan')
                ->label('Nama Relawan')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nik')
                ->label('NIK')
                ->rules(['max:255']),
            ImportColumn::make('gender')
                ->label('Jenis Kelamin')
                ->rules(['max:255']),
            ImportColumn::make('address')
                ->label('Alamat'),
            ImportColumn::make('posisi')
                ->label('Posisi / Jabatan')
                ->rules(['max:255']),
            ImportColumn::make('category')
                ->label('Kategori')
                ->rules(['max:255']),
            ImportColumn::make('kontak')
                ->label('Kontak / No. HP')
                ->rules(['max:255']),
            ImportColumn::make('daily_rate')
                ->label('Upah Harian')
                ->numeric()
                ->rules(['integer']),
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

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Impor relawan telah selesai. ' . Number::format($import->successful_rows) . ' data berhasil diimpor.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' data gagal diimpor.';
        }

        return $body;
    }
}
