<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\Suppliers;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Buying\Support\ModelResolver;
use JeffersonGoncalves\FilamentErp\Buying\FilamentErpBuyingPlugin;
use JeffersonGoncalves\FilamentErp\Buying\Resources\Suppliers\Pages\CreateSupplier;
use JeffersonGoncalves\FilamentErp\Buying\Resources\Suppliers\Pages\EditSupplier;
use JeffersonGoncalves\FilamentErp\Buying\Resources\Suppliers\Pages\ListSuppliers;
use JeffersonGoncalves\FilamentErp\Buying\Resources\Suppliers\RelationManagers\AddressRelationManager;
use JeffersonGoncalves\FilamentErp\Buying\Resources\Suppliers\RelationManagers\ContactRelationManager;
use JeffersonGoncalves\FilamentErp\Buying\Resources\Suppliers\Schemas\SupplierForm;
use JeffersonGoncalves\FilamentErp\Buying\Resources\Suppliers\Tables\SuppliersTable;

class SupplierResource extends Resource
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTruck;

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'supplier_name';

    public static function getModel(): string
    {
        return ModelResolver::supplier();
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
        return SupplierForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SuppliersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            AddressRelationManager::class,
            ContactRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSuppliers::route('/'),
            'create' => CreateSupplier::route('/create'),
            'edit' => EditSupplier::route('/{record}/edit'),
        ];
    }
}
