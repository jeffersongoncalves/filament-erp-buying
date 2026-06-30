<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierScorecards\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierScorecards\SupplierScorecardResource;

class ListSupplierScorecards extends ListRecords
{
    protected static string $resource = SupplierScorecardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
