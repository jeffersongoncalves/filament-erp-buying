<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierGroups\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierGroups\SupplierGroupResource;

class EditSupplierGroup extends EditRecord
{
    protected static string $resource = SupplierGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
