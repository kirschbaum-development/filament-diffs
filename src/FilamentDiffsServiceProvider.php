<?php

namespace Kirschbaum\FilamentDiffs;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentDiffsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-diffs';

    public static string $viewNamespace = 'filament-diffs';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasConfigFile()
            ->hasViews(static::$viewNamespace);
    }

    public function packageBooted(): void
    {
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );
    }

    protected function getAssetPackageName(): ?string
    {
        return 'kirschbaum-development/filament-diffs';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            AlpineComponent::make('file-entry', __DIR__ . '/../resources/dist/components/file-entry.js'),
            AlpineComponent::make('file-diff-entry', __DIR__ . '/../resources/dist/components/file-diff-entry.js'),
        ];
    }
}
