<?php

namespace TravisObregon\FilamentDiffs\Infolists\Components;

use Closure;
use Filament\Infolists\Components\Entry;
use TravisObregon\FilamentDiffs\Infolists\Components\Concerns\HasDiffsConfiguration;

class FileEntry extends Entry
{
    use HasDiffsConfiguration;

    protected string $view = 'filament-diffs::file-entry';

    protected string | Closure | null $content = null;

    public function content(string | Closure | null $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->evaluate($this->content);
    }

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
            'content' => $this->getContent() ?? '',
            'fileName' => $this->getFileName(),
            'language' => $this->getLanguage(),
            'options' => $this->getOptions(),
        ];
    }
}
