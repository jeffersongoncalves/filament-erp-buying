<?php

namespace JeffersonGoncalves\FilamentErp\Buying;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentErpBuyingServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-erp-buying';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasConfigFile()
            ->hasTranslations();
    }
}
