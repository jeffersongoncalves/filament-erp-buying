<?php

use JeffersonGoncalves\Erp\Buying\Models\Supplier;
use JeffersonGoncalves\FilamentErp\Buying\Resources\Suppliers\Pages\CreateSupplier;
use JeffersonGoncalves\FilamentErp\Buying\Resources\Suppliers\Pages\EditSupplier;
use JeffersonGoncalves\FilamentErp\Buying\Resources\Suppliers\Pages\ListSuppliers;
use Livewire\Livewire;

beforeEach(function () {
    filament()->setCurrentPanel(filament()->getPanel('admin'));
});

it('can render the supplier list page', function () {
    Livewire::test(ListSuppliers::class)->assertSuccessful();
});

it('can list suppliers in the table', function () {
    $supplier = Supplier::factory()->create();

    Livewire::test(ListSuppliers::class)
        ->assertCanSeeTableRecords([$supplier]);
});

it('can render the supplier create page', function () {
    Livewire::test(CreateSupplier::class)->assertSuccessful();
});

it('can create a supplier', function () {
    Livewire::test(CreateSupplier::class)
        ->fillForm([
            'supplier_name' => 'Acme Supplies',
            'supplier_type' => 'Company',
            'default_currency' => 'USD',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(Supplier::query()->where('supplier_name', 'Acme Supplies')->exists())->toBeTrue();
});

it('can render the supplier edit page', function () {
    $supplier = Supplier::factory()->create();

    Livewire::test(EditSupplier::class, ['record' => $supplier->getRouteKey()])
        ->assertSuccessful();
});
