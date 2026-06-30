<?php

use JeffersonGoncalves\Erp\Buying\Models\BlanketOrder;
use JeffersonGoncalves\Erp\Core\Enums\DocStatus;
use JeffersonGoncalves\Erp\Core\Models\Company;
use JeffersonGoncalves\FilamentErp\Buying\Resources\BlanketOrders\Pages\CreateBlanketOrder;
use JeffersonGoncalves\FilamentErp\Buying\Resources\BlanketOrders\Pages\EditBlanketOrder;
use JeffersonGoncalves\FilamentErp\Buying\Resources\BlanketOrders\Pages\ListBlanketOrders;
use Livewire\Livewire;

beforeEach(function () {
    filament()->setCurrentPanel(filament()->getPanel('admin'));

    $this->company = Company::factory()->create();
});

function makeBlanketOrder(): BlanketOrder
{
    $order = BlanketOrder::factory()->create([
        'company_id' => test()->company->id,
    ]);

    $order->items()->create([
        'item_code' => 'WIDGET-001',
        'qty' => 100,
        'rate' => 10,
        'ordered_qty' => 0,
    ]);

    return $order->refresh();
}

it('can render the blanket order list page', function () {
    Livewire::test(ListBlanketOrders::class)->assertSuccessful();
});

it('can render the blanket order create page', function () {
    Livewire::test(CreateBlanketOrder::class)->assertSuccessful();
});

it('can render the blanket order edit page', function () {
    $order = makeBlanketOrder();

    Livewire::test(EditBlanketOrder::class, ['record' => $order->getRouteKey()])
        ->assertSuccessful();
});

it('can create a blanket order', function () {
    Livewire::test(CreateBlanketOrder::class)
        ->fillForm([
            'order_type' => 'Purchasing',
            'party_type' => 'Supplier',
            'company_id' => $this->company->id,
            'from_date' => now()->toDateString(),
            'to_date' => now()->addYear()->toDateString(),
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(BlanketOrder::query()->where('party_type', 'Supplier')->exists())->toBeTrue();
});

it('submits a blanket order through the UI', function () {
    $order = makeBlanketOrder();

    Livewire::test(ListBlanketOrders::class)
        ->callTableAction('submit', $order);

    expect($order->refresh()->docstatus)->toBe(DocStatus::Submitted);
});
