<?php

use JeffersonGoncalves\FilamentErp\Buying\Resources\BlanketOrders\BlanketOrderResource;
use JeffersonGoncalves\FilamentErp\Buying\Resources\PurchaseOrders\PurchaseOrderResource;
use JeffersonGoncalves\FilamentErp\Buying\Resources\RequestForQuotations\RequestForQuotationResource;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierGroups\SupplierGroupResource;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierQuotations\SupplierQuotationResource;
use JeffersonGoncalves\FilamentErp\Buying\Resources\Suppliers\SupplierResource;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierScorecards\SupplierScorecardResource;
use JeffersonGoncalves\FilamentErp\Buying\Widgets\PurchaseOrderStatsWidget;

return [

    /*
    |--------------------------------------------------------------------------
    | Navigation Group
    |--------------------------------------------------------------------------
    |
    | The navigation group under which all ERP buying resources are listed in
    | the Filament panel. Override per-plugin with ->navigationGroup('...').
    |
    */

    'navigation_group' => 'ERP — Buying',

    /*
    |--------------------------------------------------------------------------
    | Resources
    |--------------------------------------------------------------------------
    |
    | The Filament resource classes registered by the plugin. Each entry can be
    | swapped for a custom resource extending the default one.
    |
    */

    'resources' => [
        'supplier_group' => SupplierGroupResource::class,
        'supplier' => SupplierResource::class,
        'request_for_quotation' => RequestForQuotationResource::class,
        'supplier_quotation' => SupplierQuotationResource::class,
        'purchase_order' => PurchaseOrderResource::class,
        'blanket_order' => BlanketOrderResource::class,
        'supplier_scorecard' => SupplierScorecardResource::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Widgets
    |--------------------------------------------------------------------------
    |
    | The Filament widgets registered by the plugin on the panel dashboard.
    |
    */

    'widgets' => [
        'purchase_order_stats' => PurchaseOrderStatsWidget::class,
    ],

];
