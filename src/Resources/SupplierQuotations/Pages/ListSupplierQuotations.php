<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierQuotations\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierQuotations\SupplierQuotationResource;

class ListSupplierQuotations extends ListRecords
{
    protected static string $resource = SupplierQuotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
