<?php

namespace TravisObregon\FilamentDiffs\Infolists\Components\Concerns;

use Closure;
use TravisObregon\FilamentDiffs\FilamentDiffsPlugin;

trait HasDiffsConfiguration
{
    protected string | Closure | null $fileName = null;

    protected string | Closure | null $language = null;

    protected array | Closure $options = [];

    public function fileName(string | Closure | null $fileName): static
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function language(string | Closure | null $language): static
    {
        $this->language = $language;

        return $this;
    }

    public function options(array | Closure $options): static
    {
        $this->options = $options;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->evaluate($this->fileName);
    }

    public function getLanguage(): ?string
    {
        return $this->evaluate($this->language);
    }

    public function getTheme(): ?string
    {
        return $this->getPlugin()?->getDefaultTheme()
            ?? config('filament-diffs.default_theme');
    }

    protected function getPlugin(): ?FilamentDiffsPlugin
    {
        try {
            return FilamentDiffsPlugin::get();
        } catch (\Exception) {
            return null;
        }
    }
}
