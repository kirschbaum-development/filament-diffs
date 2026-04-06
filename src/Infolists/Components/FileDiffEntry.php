<?php

namespace Kirschbaum\FilamentDiffs\Infolists\Components;

use Closure;
use Filament\Infolists\Components\Entry;
use Kirschbaum\FilamentDiffs\Infolists\Components\Concerns\HasDiffsConfiguration;

class FileDiffEntry extends Entry
{
    use HasDiffsConfiguration;

    protected string $view = 'filament-diffs::file-diff-entry';

    protected string | Closure | null $oldContent = null;

    protected string | Closure | null $newContent = null;

    public function old(string | Closure | null $content): static
    {
        $this->oldContent = $content;

        return $this;
    }

    public function new(string | Closure | null $content): static
    {
        $this->newContent = $content;

        return $this;
    }

    public function getOldContent(): ?string
    {
        return $this->evaluate($this->oldContent);
    }

    public function getNewContent(): ?string
    {
        return $this->evaluate($this->newContent);
    }

    public function getPayload(): array
    {
        return [
            'old' => $this->getOldContent() ?? '',
            'new' => $this->getNewContent() ?? '',
            'fileName' => $this->getFileName(),
            'language' => $this->getLanguage(),
            'options' => $this->getOptions(),
        ];
    }
}
