<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\Suppliers;

use Filament\Forms\Form;
use Filament\Resources\Resource;
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
    protected static ?string $navigationIcon = 'heroicon-o-truck';

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

    public static function form(Form $form): Form
    {
        return SupplierForm::configure($form);
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
