<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Tests\Fixtures;

use Filament\Panel;
use Filament\PanelProvider;
use JeffersonGoncalves\FilamentErp\Buying\FilamentErpBuyingPlugin;

class TestPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->plugins([
                FilamentErpBuyingPlugin::make(),
            ]);
    }
}
