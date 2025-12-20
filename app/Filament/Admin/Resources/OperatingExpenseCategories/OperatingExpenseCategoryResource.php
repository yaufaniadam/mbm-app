<?php

namespace App\Filament\Admin\Resources\OperatingExpenseCategories;

use App\Filament\Admin\Resources\OperatingExpenseCategories\Pages;
use App\Models\OperatingExpenseCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use UnitEnum;

class OperatingExpenseCategoryResource extends Resource
{
    protected static ?string $model = OperatingExpenseCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Kategori Biaya Operasional';

    protected static string|UnitEnum|null $navigationGroup = 'Master Keuangan';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListOperatingExpenseCategories::route('/'),
            'create' => Pages\CreateOperatingExpenseCategory::route('/create'),
            'edit' => Pages\EditOperatingExpenseCategory::route('/{record}/edit'),
        ];
    }
}
