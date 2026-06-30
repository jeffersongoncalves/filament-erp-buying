<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\BlanketOrders\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use JeffersonGoncalves\FilamentErp\Buying\Resources\BlanketOrders\BlanketOrderResource;

class EditBlanketOrder extends EditRecord
{
    protected static string $resource = BlanketOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
