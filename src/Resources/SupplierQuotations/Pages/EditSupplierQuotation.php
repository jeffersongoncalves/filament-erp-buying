<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierQuotations\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierQuotations\SupplierQuotationResource;

class EditSupplierQuotation extends EditRecord
{
    protected static string $resource = SupplierQuotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
