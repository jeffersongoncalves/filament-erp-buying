<?php

it('loads the filament-erp-buying config file', function () {
    expect(config('filament-erp-buying'))->toBeArray();
});

it('has a default navigation group', function () {
    expect(config('filament-erp-buying.navigation_group'))->toBe('ERP — Buying');
});

it('registers all resources in config', function () {
    $resources = config('filament-erp-buying.resources');

    expect($resources)->toBeArray()
        ->toHaveKeys([
            'supplier_group',
            'supplier',
            'request_for_quotation',
            'supplier_quotation',
            'purchase_order',
        ]);
});

it('registers the dashboard widgets in config', function () {
    expect(config('filament-erp-buying.widgets'))->toBeArray()
        ->toHaveKeys(['purchase_order_stats']);
});
