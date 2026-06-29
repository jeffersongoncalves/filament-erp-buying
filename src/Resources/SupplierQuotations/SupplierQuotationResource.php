<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierQuotations;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Buying\Support\ModelResolver;
use JeffersonGoncalves\FilamentErp\Buying\FilamentErpBuyingPlugin;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierQuotations\Pages\CreateSupplierQuotation;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierQuotations\Pages\EditSupplierQuotation;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierQuotations\Pages\ListSupplierQuotations;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierQuotations\RelationManagers\ItemsRelationManager;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierQuotations\Schemas\SupplierQuotationForm;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierQuotations\Tables\SupplierQuotationsTable;

class SupplierQuotationResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-document-currency-dollar';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'supplier_name';

    public static function getModel(): string
    {
        return ModelResolver::supplierQuotation();
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
        return SupplierQuotationForm::configure($form);
    }

    public static function table(Table $table): Table
    {
        return SupplierQuotationsTable::configure($table);
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
            'index' => ListSupplierQuotations::route('/'),
            'create' => CreateSupplierQuotation::route('/create'),
            'edit' => EditSupplierQuotation::route('/{record}/edit'),
        ];
    }
}
