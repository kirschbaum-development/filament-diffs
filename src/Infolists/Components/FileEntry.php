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

    /**
     * @param  \Illuminate\Database\Eloquent\Model|\Closure  $model
     */
    public function fromModel(mixed $model, string | Closure $attribute = 'content'): static
    {
        $this->content(function () use ($model, $attribute): ?string {
            $model = $this->evaluate($model);
            $attr = $this->evaluate($attribute);

            return $model?->getAttribute($attr);
        });

        return $this;
    }

    /**
     * @param  array<string, mixed>|\Closure  $data
     * @param  array<int, string>|null  $only
     */
    public function fromArray(array | Closure $data, ?array $only = null): static
    {
        $this->content(function () use ($data, $only): string {
            $data = $this->evaluate($data);

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

    public function getContent(): ?string
    {
        return $this->evaluate($this->content);
    }

    public function getOptions(): array
    {
        return array_merge(
            config('filament-diffs.default_file_options', []),
            $this->getPlugin()?->getDefaultFileOptions() ?? [],
            $this->evaluate($this->options),
        );
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
