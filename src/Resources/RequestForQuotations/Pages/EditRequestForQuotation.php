<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\RequestForQuotations\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use JeffersonGoncalves\FilamentErp\Buying\Resources\RequestForQuotations\RequestForQuotationResource;

class EditRequestForQuotation extends EditRecord
{
    protected static string $resource = RequestForQuotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
