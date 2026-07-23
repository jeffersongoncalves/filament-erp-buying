<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\BlanketOrders;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Buying\Models\BlanketOrder;
use JeffersonGoncalves\FilamentErp\Buying\FilamentErpBuyingPlugin;
use JeffersonGoncalves\FilamentErp\Buying\Resources\BlanketOrders\Pages\CreateBlanketOrder;
use JeffersonGoncalves\FilamentErp\Buying\Resources\BlanketOrders\Pages\EditBlanketOrder;
use JeffersonGoncalves\FilamentErp\Buying\Resources\BlanketOrders\Pages\ListBlanketOrders;
use JeffersonGoncalves\FilamentErp\Buying\Resources\BlanketOrders\RelationManagers\ItemsRelationManager;
use JeffersonGoncalves\FilamentErp\Buying\Resources\BlanketOrders\Schemas\BlanketOrderForm;
use JeffersonGoncalves\FilamentErp\Buying\Resources\BlanketOrders\Tables\BlanketOrdersTable;

class BlanketOrderResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?int $navigationSort = 6;

    protected static ?string $recordTitleAttribute = 'party_type';

    public static function getModel(): string
    {
        return BlanketOrder::class;
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
        return BlanketOrderForm::configure($form);
    }

    public static function table(Table $table): Table
    {
        return BlanketOrdersTable::configure($table);
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
            'index' => ListBlanketOrders::route('/'),
            'create' => CreateBlanketOrder::route('/create'),
            'edit' => EditBlanketOrder::route('/{record}/edit'),
        ];
    }
}
