<?php

namespace TravisObregon\FilamentDiffs\Infolists\Components;

use Closure;
use Filament\Infolists\Components\Entry;

class DiffEntry extends Entry
{
    protected string $view = 'filament-diffs::diff-entry';

    protected string | Closure | null $oldContent = null;

    protected string | Closure | null $newContent = null;

    protected string | Closure | null $fileName = null;

    protected string | Closure | null $language = null;

    protected array | Closure $options = [];

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

    /**
     * @param  \Illuminate\Database\Eloquent\Model|\Closure  $old
     * @param  \Illuminate\Database\Eloquent\Model|\Closure  $new
     */
    public function fromModels(mixed $old, mixed $new, string | Closure $attribute = 'content'): static
    {
        $this->old(function () use ($old, $attribute): ?string {
            $model = $this->evaluate($old);
            $attr = $this->evaluate($attribute);

            return $model?->getAttribute($attr);
        });

        $this->new(function () use ($new, $attribute): ?string {
            $model = $this->evaluate($new);
            $attr = $this->evaluate($attribute);

            return $model?->getAttribute($attr);
        });

        return $this;
    }

    /**
     * @param  array<string, mixed>|\Closure  $old
     * @param  array<string, mixed>|\Closure  $new
     * @param  array<int, string>|null  $only
     */
    public function fromArrays(array | Closure $old, array | Closure $new, ?array $only = null): static
    {
        $this->old(function () use ($old, $only): string {
            $data = $this->evaluate($old);

            if ($only !== null) {
                $data = array_intersect_key($data, array_flip($only));
            }

            return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        });

        $this->new(function () use ($new, $only): string {
            $data = $this->evaluate($new);

            if ($only !== null) {
                $data = array_intersect_key($data, array_flip($only));
            }

            return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        });

        if ($this->language === null) {
            $this->language('json');
        }

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

    public function getFileName(): ?string
    {
        return $this->evaluate($this->fileName) ?? config('filament-diffs.default_file_name');
    }

    public function getLanguage(): ?string
    {
        return $this->evaluate($this->language) ?? config('filament-diffs.default_language');
    }

    public function getOptions(): array
    {
        return array_merge(
            config('filament-diffs.default_options', []),
            $this->evaluate($this->options),
        );
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
