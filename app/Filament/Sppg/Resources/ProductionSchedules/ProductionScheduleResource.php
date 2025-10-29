<?php

namespace App\Filament\Sppg\Resources\ProductionSchedules;

use App\Filament\Sppg\Resources\ProductionSchedules\Pages\CreateProductionSchedule;
use App\Filament\Sppg\Resources\ProductionSchedules\Pages\EditProductionSchedule;
use App\Filament\Sppg\Resources\ProductionSchedules\Pages\ListProductionSchedules;
use App\Filament\Sppg\Resources\ProductionSchedules\Pages\ViewProductionSchedule;
use App\Filament\Sppg\Resources\ProductionSchedules\Schemas\ProductionScheduleForm;
use App\Filament\Sppg\Resources\ProductionSchedules\Schemas\ProductionScheduleInfolist;
use App\Filament\Sppg\Resources\ProductionSchedules\Tables\ProductionSchedulesTable;
use App\Models\ProductionSchedule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProductionScheduleResource extends Resource
{
    protected static ?string $model = ProductionSchedule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ProductionScheduleForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProductionScheduleInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductionSchedulesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProductionSchedules::route('/'),
            'create' => CreateProductionSchedule::route('/create'),
            'view' => ViewProductionSchedule::route('/{record}'),
            'edit' => EditProductionSchedule::route('/{record}/edit'),
        ];
    }
}
