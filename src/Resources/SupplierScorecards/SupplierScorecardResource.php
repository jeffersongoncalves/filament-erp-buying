<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierScorecards;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Buying\Models\SupplierScorecard;
use JeffersonGoncalves\FilamentErp\Buying\FilamentErpBuyingPlugin;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierScorecards\Pages\CreateSupplierScorecard;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierScorecards\Pages\EditSupplierScorecard;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierScorecards\Pages\ListSupplierScorecards;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierScorecards\RelationManagers\CriteriaRelationManager;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierScorecards\Schemas\SupplierScorecardForm;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierScorecards\Tables\SupplierScorecardsTable;

class SupplierScorecardResource extends Resource
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static ?int $navigationSort = 7;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModel(): string
    {
        return SupplierScorecard::class;
    }

    public static function getNavigationGroup(): ?string
    {
        try {
            return FilamentErpBuyingPlugin::get()->getNavigationGroup();
        } catch (\Throwable) {
            return config('filament-erp-buying.navigation_group', 'ERP — Buying');
        }
    }

    public static function form(Schema $schema): Schema
    {
        return SupplierScorecardForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SupplierScorecardsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            CriteriaRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSupplierScorecards::route('/'),
            'create' => CreateSupplierScorecard::route('/create'),
            'edit' => EditSupplierScorecard::route('/{record}/edit'),
        ];
    }
}
