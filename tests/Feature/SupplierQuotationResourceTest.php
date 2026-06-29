<?php

use Filament\Actions\Testing\TestAction;
use JeffersonGoncalves\Erp\Buying\Models\PurchaseOrder;
use JeffersonGoncalves\Erp\Buying\Models\SupplierQuotation;
use JeffersonGoncalves\Erp\Core\Models\Company;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierQuotations\Pages\CreateSupplierQuotation;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierQuotations\Pages\EditSupplierQuotation;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierQuotations\Pages\ListSupplierQuotations;
use Livewire\Livewire;

beforeEach(function () {
    filament()->setCurrentPanel(filament()->getPanel('admin'));

    $this->company = Company::factory()->create();
});

it('can render the supplier quotation list page', function () {
    Livewire::test(ListSupplierQuotations::class)->assertSuccessful();
});

it('can render the supplier quotation create page', function () {
    Livewire::test(CreateSupplierQuotation::class)->assertSuccessful();
});

it('can render the supplier quotation edit page', function () {
    $quotation = SupplierQuotation::factory()->create(['company_id' => $this->company->id]);

    Livewire::test(EditSupplierQuotation::class, ['record' => $quotation->getRouteKey()])
        ->assertSuccessful();
});

it('creates a purchase order from a submitted supplier quotation through the UI', function () {
    $quotation = SupplierQuotation::factory()->create([
        'company_id' => $this->company->id,
        'supplier_name' => 'Acme Supplies',
    ]);

    $quotation->items()->create([
        'item_code' => 'WIDGET-001',
        'item_name' => 'Widget',
        'qty' => 4,
        'rate' => 12.5,
    ]);

    $quotation = $quotation->refresh();
    $quotation->submit();

    Livewire::test(ListSupplierQuotations::class)
        ->callAction(TestAction::make('createPurchaseOrder')->table($quotation));

    $order = PurchaseOrder::query()->first();

    expect($order)->not->toBeNull()
        ->and($order->supplier_name)->toBe('Acme Supplies')
        ->and($order->items)->toHaveCount(1)
        ->and($order->items->first()->item_code)->toBe('WIDGET-001')
        ->and($order->items->first()->qty)->toBe(4.0)
        ->and($order->items->first()->rate)->toBe(12.5);
});
