<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierGroups\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierGroups\SupplierGroupResource;

class ListSupplierGroups extends ListRecords
{
    protected static string $resource = SupplierGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
