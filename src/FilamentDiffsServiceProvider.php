<?php

namespace TravisObregon\FilamentDiffs;

use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentDiffsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-diffs';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name);
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );
    }

    protected function getAssetPackageName(): ?string
    {
        return 'travisobregon/filament-diffs';
    }

    /**
     * @return array<\Filament\Support\Assets\Asset>
     */
    protected function getAssets(): array
    {
        return [
            Js::make('filament-diffs-scripts', __DIR__ . '/../resources/dist/filament-diffs.js'),
        ];
    }
}
