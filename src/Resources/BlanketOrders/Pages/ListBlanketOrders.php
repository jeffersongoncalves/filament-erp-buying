<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\BlanketOrders\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use JeffersonGoncalves\FilamentErp\Buying\Resources\BlanketOrders\BlanketOrderResource;

class ListBlanketOrders extends ListRecords
{
    protected static string $resource = BlanketOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
