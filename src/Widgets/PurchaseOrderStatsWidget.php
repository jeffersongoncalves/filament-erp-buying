<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use JeffersonGoncalves\Erp\Buying\Support\ModelResolver;
use JeffersonGoncalves\Erp\Core\Enums\DocStatus;

/**
 * Open purchasing commitment: how many purchase orders are submitted and the
 * total value committed across them.
 */
class PurchaseOrderStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $orderModel = ModelResolver::purchaseOrder();

        $query = $orderModel::query()->where('docstatus', DocStatus::Submitted->value);

        $count = (clone $query)->count();
        $total = (float) (clone $query)->sum('grand_total');

        return [
            Stat::make('Submitted Orders', (string) $count)
                ->description('purchase orders awaiting fulfilment')
                ->color('primary'),
            Stat::make('Committed Value', number_format($total, 2))
                ->description('total grand total of submitted orders')
                ->color('gray'),
        ];
    }
}
