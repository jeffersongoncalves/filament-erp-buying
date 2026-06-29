<div class="filament-hidden">

![Filament ERP Buying](https://raw.githubusercontent.com/jeffersongoncalves/filament-erp-buying/3.x/art/jeffersongoncalves-filament-erp-buying.png)

</div>

# Filament ERP Buying

Filament v5 panel resources for the [Laravel ERP buying module](https://github.com/jeffersongoncalves/laravel-erp-buying) — suppliers, RFQs, supplier quotations and purchase orders.

This package is the UI layer for the `jeffersongoncalves/laravel-erp-buying` domain package (namespace `JeffersonGoncalves\Erp\Buying\`). It wires the procurement models into ready-to-use Filament resources, relation managers and a purchasing dashboard widget.

## Features

- **Master resources** — Supplier groups and suppliers (with address & contact relation managers)
- **Transaction resources** — Requests for quotation, supplier quotations and purchase orders, each with an Items relation manager
- **Document lifecycle** — Submit/Cancel record actions wired to the domain `submit()` / `cancel()` methods
- **Dashboard widget** — `PurchaseOrderStatsWidget` with open/submitted purchase order counts and value
- **Configurable** — Swap resource classes, change the navigation group or assign a cluster via config

## Compatibility

| Package | PHP | Filament | Laravel |
|---------|-----|----------|---------|
| `^3.0`  | `^8.2` | `^5.0` | `^11.0 \| ^12.0 \| ^13.0` |

## Installation

Install the package via Composer:

```bash
composer require jeffersongoncalves/filament-erp-buying
```

Register the plugin on a Filament panel:

```php
use JeffersonGoncalves\FilamentErp\Buying\FilamentErpBuyingPlugin;

$panel->plugin(
    FilamentErpBuyingPlugin::make()
        ->navigationGroup('ERP — Buying'),
);
```

## Resources

| Resource | Purpose |
|----------|---------|
| `SupplierGroupResource` | Supplier groups (tree via parent) |
| `SupplierResource` | Suppliers (with Address & Contact relation managers) |
| `RequestForQuotationResource` | Requests for quotation (+ Items RM, Suppliers RM, Submit/Cancel) |
| `SupplierQuotationResource` | Supplier quotations (+ Items RM, Submit/Cancel) |
| `PurchaseOrderResource` | Purchase orders (+ Items RM, Submit/Cancel) |

Transaction resources expose **Submit** and **Cancel** record actions that drive the domain document lifecycle (`$record->submit()` / `$record->cancel()`).

## Widgets

| Widget | Purpose |
|--------|---------|
| `PurchaseOrderStatsWidget` | Count and total value of open/submitted purchase orders |

## Configuration

Publish the config to swap resource classes, change the navigation group, or adjust widgets:

```bash
php artisan vendor:publish --tag="filament-erp-buying-config"
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Jefferson Simão Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
