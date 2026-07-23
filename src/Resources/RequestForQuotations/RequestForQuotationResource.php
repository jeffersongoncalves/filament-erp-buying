<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\RequestForQuotations;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Buying\Support\ModelResolver;
use JeffersonGoncalves\FilamentErp\Buying\FilamentErpBuyingPlugin;
use JeffersonGoncalves\FilamentErp\Buying\Resources\RequestForQuotations\Pages\CreateRequestForQuotation;
use JeffersonGoncalves\FilamentErp\Buying\Resources\RequestForQuotations\Pages\EditRequestForQuotation;
use JeffersonGoncalves\FilamentErp\Buying\Resources\RequestForQuotations\Pages\ListRequestForQuotations;
use JeffersonGoncalves\FilamentErp\Buying\Resources\RequestForQuotations\RelationManagers\ItemsRelationManager;
use JeffersonGoncalves\FilamentErp\Buying\Resources\RequestForQuotations\RelationManagers\SuppliersRelationManager;
use JeffersonGoncalves\FilamentErp\Buying\Resources\RequestForQuotations\Schemas\RequestForQuotationForm;
use JeffersonGoncalves\FilamentErp\Buying\Resources\RequestForQuotations\Tables\RequestForQuotationsTable;

class RequestForQuotationResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'naming_series';

    protected static ?string $modelLabel = 'Request for Quotation';

    public static function getModel(): string
    {
        return ModelResolver::requestForQuotation();
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
        return RequestForQuotationForm::configure($form);
    }

    public static function table(Table $table): Table
    {
        return RequestForQuotationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class,
            SuppliersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRequestForQuotations::route('/'),
            'create' => CreateRequestForQuotation::route('/create'),
            'edit' => EditRequestForQuotation::route('/{record}/edit'),
        ];
    }
}
