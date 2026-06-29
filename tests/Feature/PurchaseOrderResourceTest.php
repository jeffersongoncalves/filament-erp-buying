<?php

use Filament\Actions\Testing\TestAction;
use JeffersonGoncalves\Erp\Accounting\Enums\AccountType;
use JeffersonGoncalves\Erp\Accounting\Models\Account;
use JeffersonGoncalves\Erp\Accounting\Models\PurchaseInvoice;
use JeffersonGoncalves\Erp\Buying\Models\PurchaseOrder;
use JeffersonGoncalves\Erp\Core\Enums\DocStatus;
use JeffersonGoncalves\Erp\Core\Models\Company;
use JeffersonGoncalves\Erp\Stock\Models\Item;
use JeffersonGoncalves\Erp\Stock\Models\PurchaseReceipt;
use JeffersonGoncalves\Erp\Stock\Models\Warehouse;
use JeffersonGoncalves\FilamentErp\Buying\Resources\PurchaseOrders\Pages\CreatePurchaseOrder;
use JeffersonGoncalves\FilamentErp\Buying\Resources\PurchaseOrders\Pages\EditPurchaseOrder;
use JeffersonGoncalves\FilamentErp\Buying\Resources\PurchaseOrders\Pages\ListPurchaseOrders;
use Livewire\Livewire;

beforeEach(function () {
    filament()->setCurrentPanel(filament()->getPanel('admin'));

    $this->company = Company::factory()->create();
    $this->warehouse = Warehouse::factory()->create(['company_id' => $this->company->id]);
    $this->item = Item::factory()->create(['item_code' => 'WIDGET-001']);
});

function makePurchaseOrder(): PurchaseOrder
{
    $order = PurchaseOrder::factory()->create([
        'company_id' => test()->company->id,
        'supplier_name' => 'Acme Supplies',
    ]);

    $order->items()->create([
        'item_code' => 'WIDGET-001',
        'item_name' => 'Widget',
        'qty' => 5,
        'rate' => 10,
        'warehouse_id' => test()->warehouse->id,
    ]);

    return $order->refresh();
}

it('can render the purchase order list page', function () {
    Livewire::test(ListPurchaseOrders::class)->assertSuccessful();
});

it('can render the purchase order create page', function () {
    Livewire::test(CreatePurchaseOrder::class)->assertSuccessful();
});

it('can render the purchase order edit page', function () {
    $order = makePurchaseOrder();

    Livewire::test(EditPurchaseOrder::class, ['record' => $order->getRouteKey()])
        ->assertSuccessful();
});

it('submits a purchase order through the UI', function () {
    $order = makePurchaseOrder();

    Livewire::test(ListPurchaseOrders::class)
        ->callAction(TestAction::make('submit')->table($order));

    expect($order->refresh()->docstatus)->toBe(DocStatus::Submitted);
});

it('creates a stock purchase receipt from a submitted purchase order through the UI', function () {
    $order = makePurchaseOrder();
    $order->submit();

    Livewire::test(ListPurchaseOrders::class)
        ->callAction(TestAction::make('createPurchaseReceipt')->table($order));

    $receipt = PurchaseReceipt::query()->first();

    expect($receipt)->not->toBeNull()
        ->and($receipt->supplier_name)->toBe('Acme Supplies')
        ->and($receipt->items)->toHaveCount(1)
        ->and($receipt->items->first()->item_id)->toBe($this->item->id)
        ->and($receipt->items->first()->qty)->toBe(5.0)
        ->and($receipt->items->first()->warehouse_id)->toBe($this->warehouse->id);
});

it('creates an accounting purchase invoice from a submitted purchase order through the UI', function () {
    Account::factory()->create([
        'company_id' => $this->company->id,
        'account_type' => AccountType::Payable,
    ]);

    $order = makePurchaseOrder();
    $order->submit();

    Livewire::test(ListPurchaseOrders::class)
        ->callAction(TestAction::make('createPurchaseInvoice')->table($order));

    $invoice = PurchaseInvoice::query()->first();

    expect($invoice)->not->toBeNull()
        ->and($invoice->supplier_name)->toBe('Acme Supplies')
        ->and($invoice->items)->toHaveCount(1)
        ->and($invoice->items->first()->item_code)->toBe('WIDGET-001')
        ->and($invoice->items->first()->qty)->toBe(5.0);
});
