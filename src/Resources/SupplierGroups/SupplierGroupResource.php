<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierGroups;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Buying\Support\ModelResolver;
use JeffersonGoncalves\FilamentErp\Buying\FilamentErpBuyingPlugin;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierGroups\Pages\CreateSupplierGroup;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierGroups\Pages\EditSupplierGroup;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierGroups\Pages\ListSupplierGroups;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierGroups\Schemas\SupplierGroupForm;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierGroups\Tables\SupplierGroupsTable;

class SupplierGroupResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModel(): string
    {
        return ModelResolver::supplierGroup();
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
        return SupplierGroupForm::configure($form);
    }

    public static function table(Table $table): Table
    {
        return SupplierGroupsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSupplierGroups::route('/'),
            'create' => CreateSupplierGroup::route('/create'),
            'edit' => EditSupplierGroup::route('/{record}/edit'),
        ];
    }
}
