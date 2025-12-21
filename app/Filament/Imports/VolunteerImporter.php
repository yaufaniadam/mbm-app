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
            ImportColumn::make('nama_relawan')
                ->label('Nama')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('posisi')
                ->label('Jabatan')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('daily_rate')
                ->label('Honor')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('nik')
                ->label('NIK')
                ->rules(['max:255']),
            ImportColumn::make('gender')
                ->label('Jenis Kelamin')
                ->rules(['max:255']),
            ImportColumn::make('address')
                ->label('Alamat'),
            ImportColumn::make('kontak')
                ->label('Kontak / No. HP')
                ->rules(['max:255']),
        ];
    }

    public function beforeFill(array $data): array
    {
        // Copy Jabatan to category as well
        if (isset($data['posisi'])) {
            $data['category'] = $data['posisi'];
        }

        // Clean Indonesian number format (remove dots as thousand separators, keep as integer)
        if (isset($data['daily_rate'])) {
            $cleaned = str_replace(['.', ',', ' '], '', trim($data['daily_rate']));
            $data['daily_rate'] = (int) $cleaned;
        }

        return $data;
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
