<?php

namespace TravisObregon\FilamentDiffs;

use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentDiffsPlugin implements Plugin
{
    protected ?string $defaultFileName = null;

    protected ?string $defaultLanguage = null;

    protected ?array $defaultOptions = null;

    public function getId(): string
    {
        return 'filament-diffs';
    }

    public function register(Panel $panel): void
    {
        //
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    public function defaultFileName(?string $fileName): static
    {
        $this->defaultFileName = $fileName;

        return $this;
    }

    public function getDefaultFileName(): ?string
    {
        return $this->defaultFileName;
    }

    public function defaultLanguage(?string $language): static
    {
        $this->defaultLanguage = $language;

        return $this;
    }

    public function getDefaultLanguage(): ?string
    {
        return $this->defaultLanguage;
    }

    public function defaultOptions(array $options): static
    {
        $this->defaultOptions = $options;

        return $this;
    }

    public function getDefaultOptions(): ?array
    {
        return $this->defaultOptions;
    }
}
