<?php

namespace TravisObregon\FilamentDiffs\Infolists\Components;

use Filament\Infolists\Components\Entry;
use TravisObregon\FilamentDiffs\Infolists\Components\Concerns\HasDiffsConfiguration;

class FileEntry extends Entry
{
    use HasDiffsConfiguration;

    protected string $view = 'filament-diffs::file-entry';

    public function getOptions(): array
    {
        return array_filter([
            'theme' => $this->getTheme(),
            ...$this->evaluate($this->options),
        ], fn ($value): bool => $value !== null);
    }

    public function getPayload(): array
    {
        return [
            'content' => $this->getState() ?? '',
            'fileName' => $this->getFileName(),
            'language' => $this->getLanguage(),
            'options' => $this->getOptions(),
        ];
    }
}
