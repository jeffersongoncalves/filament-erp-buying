<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierScorecards\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierScorecards\SupplierScorecardResource;

class EditSupplierScorecard extends EditRecord
{
    protected static string $resource = SupplierScorecardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
