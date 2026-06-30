<?php

namespace JeffersonGoncalves\FilamentErp\Buying;

use Filament\Contracts\Plugin;
use Filament\Panel;
use JeffersonGoncalves\FilamentErp\Buying\Concerns\HasErpBuyingPluginConfig;
use JeffersonGoncalves\FilamentErp\Buying\Resources\BlanketOrders\BlanketOrderResource;
use JeffersonGoncalves\FilamentErp\Buying\Resources\PurchaseOrders\PurchaseOrderResource;
use JeffersonGoncalves\FilamentErp\Buying\Resources\RequestForQuotations\RequestForQuotationResource;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierGroups\SupplierGroupResource;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierQuotations\SupplierQuotationResource;
use JeffersonGoncalves\FilamentErp\Buying\Resources\Suppliers\SupplierResource;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierScorecards\SupplierScorecardResource;

class FilamentErpBuyingPlugin implements Plugin
{
    use HasErpBuyingPluginConfig;

    public function getId(): string
    {
        return 'filament-erp-buying';
    }

    public function register(Panel $panel): void
    {
        $panel->resources($this->resolveResources([
            'supplier_group' => SupplierGroupResource::class,
            'supplier' => SupplierResource::class,
            'request_for_quotation' => RequestForQuotationResource::class,
            'supplier_quotation' => SupplierQuotationResource::class,
            'purchase_order' => PurchaseOrderResource::class,
            'blanket_order' => BlanketOrderResource::class,
            'supplier_scorecard' => SupplierScorecardResource::class,
        ]));

        $panel->widgets($this->resolveWidgets());
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
