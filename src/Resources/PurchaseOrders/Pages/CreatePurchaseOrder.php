<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\PurchaseOrders\Pages;

use Filament\Resources\Pages\CreateRecord;
use JeffersonGoncalves\FilamentErp\Buying\Resources\PurchaseOrders\PurchaseOrderResource;

class CreatePurchaseOrder extends CreateRecord
{
    protected static string $resource = PurchaseOrderResource::class;
}
