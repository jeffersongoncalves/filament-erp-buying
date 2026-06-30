<?php

use JeffersonGoncalves\Erp\Buying\Models\Supplier;
use JeffersonGoncalves\Erp\Buying\Models\SupplierScorecard;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierScorecards\Pages\CreateSupplierScorecard;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierScorecards\Pages\EditSupplierScorecard;
use JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierScorecards\Pages\ListSupplierScorecards;
use Livewire\Livewire;

beforeEach(function () {
    filament()->setCurrentPanel(filament()->getPanel('admin'));
});

it('can render the supplier scorecard list page', function () {
    Livewire::test(ListSupplierScorecards::class)->assertSuccessful();
});

it('can list supplier scorecards in the table', function () {
    $scorecard = SupplierScorecard::factory()->create();

    Livewire::test(ListSupplierScorecards::class)
        ->assertCanSeeTableRecords([$scorecard]);
});

it('can render the supplier scorecard create page', function () {
    Livewire::test(CreateSupplierScorecard::class)->assertSuccessful();
});

it('can create a supplier scorecard', function () {
    $supplier = Supplier::factory()->create();

    Livewire::test(CreateSupplierScorecard::class)
        ->fillForm([
            'supplier_id' => $supplier->id,
            'name' => 'FY2026 Q1',
            'disabled' => false,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(SupplierScorecard::query()->where('name', 'FY2026 Q1')->exists())->toBeTrue();
});

it('can render the supplier scorecard edit page', function () {
    $scorecard = SupplierScorecard::factory()->create();

    Livewire::test(EditSupplierScorecard::class, ['record' => $scorecard->getRouteKey()])
        ->assertSuccessful();
});

it('refreshes the score and standing through the UI', function () {
    $scorecard = SupplierScorecard::factory()->create();

    $scorecard->criteria()->create([
        'criteria_name' => 'On-time delivery',
        'weight' => 100,
        'max_score' => 100,
        'score' => 90,
    ]);

    Livewire::test(ListSupplierScorecards::class)
        ->callTableAction('refreshScore', $scorecard);

    $scorecard->refresh();

    expect($scorecard->score)->toBe(90.0)
        ->and($scorecard->standing)->toBe('A');
});
