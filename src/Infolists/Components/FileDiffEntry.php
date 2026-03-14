<?php

namespace TravisObregon\FilamentDiffs\Infolists\Components;

use Closure;
use Filament\Infolists\Components\Entry;
use Illuminate\Database\Eloquent\Model;
use TravisObregon\FilamentDiffs\Infolists\Components\Concerns\HasDiffsConfiguration;

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

    /**
     * @param  Model|Closure  $old
     * @param  Model|Closure  $new
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
     * @param  array<string, mixed>|Closure  $old
     * @param  array<string, mixed>|Closure  $new
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

    public function getOptions(): array
    {
        return array_merge(
            config('filament-diffs.default_diff_options', []),
            $this->getPlugin()?->getDefaultDiffOptions() ?? [],
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
