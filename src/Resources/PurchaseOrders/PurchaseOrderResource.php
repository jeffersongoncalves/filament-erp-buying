<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\PurchaseOrders;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Buying\Support\ModelResolver;
use JeffersonGoncalves\FilamentErp\Buying\FilamentErpBuyingPlugin;
use JeffersonGoncalves\FilamentErp\Buying\Resources\PurchaseOrders\Pages\CreatePurchaseOrder;
use JeffersonGoncalves\FilamentErp\Buying\Resources\PurchaseOrders\Pages\EditPurchaseOrder;
use JeffersonGoncalves\FilamentErp\Buying\Resources\PurchaseOrders\Pages\ListPurchaseOrders;
use JeffersonGoncalves\FilamentErp\Buying\Resources\PurchaseOrders\RelationManagers\ItemsRelationManager;
use JeffersonGoncalves\FilamentErp\Buying\Resources\PurchaseOrders\Schemas\PurchaseOrderForm;
use JeffersonGoncalves\FilamentErp\Buying\Resources\PurchaseOrders\Tables\PurchaseOrdersTable;

class PurchaseOrderResource extends Resource
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingCart;

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'supplier_name';

    public static function getModel(): string
    {
        return ModelResolver::purchaseOrder();
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
        return PurchaseOrderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PurchaseOrdersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPurchaseOrders::route('/'),
            'create' => CreatePurchaseOrder::route('/create'),
            'edit' => EditPurchaseOrder::route('/{record}/edit'),
        ];
    }
}
