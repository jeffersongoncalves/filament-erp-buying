<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\RequestForQuotations\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use JeffersonGoncalves\FilamentErp\Buying\Resources\RequestForQuotations\RequestForQuotationResource;

class ListRequestForQuotations extends ListRecords
{
    protected static string $resource = RequestForQuotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
