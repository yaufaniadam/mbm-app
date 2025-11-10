<?php

namespace App\Filament\Sppg\Resources\Staff;

use App\Filament\Sppg\Resources\Staff\Pages\CreateStaff;
use App\Filament\Sppg\Resources\Staff\Pages\EditStaff;
use App\Filament\Sppg\Resources\Staff\Pages\ListStaff;
use App\Filament\Sppg\Resources\Staff\Schemas\StaffForm;
use App\Filament\Sppg\Resources\Staff\Tables\StaffTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StaffResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Staff'; // ✅ label shown in sidebar

    protected static ?string $slug = 'staff';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return StaffForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StaffTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStaff::route('/'),
            'create' => CreateStaff::route('/create'),
            'edit' => EditStaff::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Staff'; // ✅ used in page titles like “Edit Staff”
    }

    public static function getEloquentQuery(): Builder
    {
        $user = User::find(Auth::user()->id);

        $sppgId = $user->sppgDiKepalai?->id;

        return parent::getEloquentQuery()
            ->whereHas('unitTugas', function (Builder $query) use ($sppgId) {
                $query->where('sppg_id', $sppgId);
            });
    }
}
