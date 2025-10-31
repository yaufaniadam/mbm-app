<?php

namespace App\Filament\Sppg\Resources\Schools\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;

class SchoolForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_sekolah')
                    ->label('Nama Sekolah')
                    ->required(),
                Textarea::make('alamat')
                    ->label('Alamat')
                    ->rows(3)
                    ->required(),
                Select::make('province_code')
                    ->label('Provinsi')
                    ->options(function () {
                        $provinces = DB::table('indonesia_provinces')->select('code', 'name')->orderBy('name')->get();

                        return $provinces->pluck('name', 'code');
                    })
                    ->live()
                    ->searchable()
                    ->afterStateUpdated(function (callable $set) {
                        $set('city_code', null);
                        $set('district_code', null);
                        $set('village_code', null);
                    }),
                Select::make('city_code')
                    ->label('Kota/Kabupaten')
                    ->options(function (callable $get) {

                        $provinceCode = $get('province_code');

                        if (! $provinceCode) {
                            return [];
                        }

                        $cities = DB::table('indonesia_cities')
                            ->where('province_code', $provinceCode)
                            ->select('code', 'name')
                            ->orderBy('name')
                            ->get();

                        return $cities->pluck('name', 'code');
                    })
                    ->live()
                    ->searchable()
                    ->disabled(fn(callable $get) => ! $get('province_code')),
                Select::make('district_code')
                    ->label('Kecamatan')
                    ->options(function (callable $get) {

                        $cityCode = $get('city_code');

                        if (! $cityCode) {
                            return [];
                        }

                        $districts = DB::table('indonesia_districts')
                            ->where('city_code', $cityCode)
                            ->select('code', 'name')
                            ->orderBy('name')
                            ->get();

                        return $districts->pluck('name', 'code');
                    })
                    ->live()
                    ->searchable()
                    ->disabled(fn(callable $get) => ! $get('city_code')),
                Select::make('village_code')
                    ->label('Kelurahan/Desa')
                    ->options(function (callable $get) {

                        $districtCode = $get('district_code');

                        if (! $districtCode) {
                            return [];
                        }

                        $villages = DB::table('indonesia_villages')
                            ->where('district_code', $districtCode)
                            ->select('code', 'name')
                            ->orderBy('name')
                            ->get();

                        return $villages->pluck('name', 'code');
                    })
                    ->live()
                    ->searchable()
                    ->disabled(fn(callable $get) => ! $get('district_code')),
            ]);
    }
}
