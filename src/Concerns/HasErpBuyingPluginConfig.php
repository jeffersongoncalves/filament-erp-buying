<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Concerns;

use JeffersonGoncalves\FilamentErp\Core\Concerns\HasErpPluginConfig;

trait HasErpBuyingPluginConfig
{
    use HasErpPluginConfig;

    protected function getConfigKey(): string
    {
        return 'filament-erp-buying';
    }

    protected function getDefaultNavigationGroup(): string
    {
        return 'ERP — Buying';
    }
}
