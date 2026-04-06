<?php

namespace Kirschbaum\FilamentDiffs\Infolists\Components;

use Filament\Infolists\Components\Entry;
use Kirschbaum\FilamentDiffs\Infolists\Components\Concerns\HasDiffsConfiguration;

class FileEntry extends Entry
{
    use HasDiffsConfiguration;

    protected string $view = 'filament-diffs::file-entry';

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
