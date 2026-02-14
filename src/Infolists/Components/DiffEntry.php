<?php

namespace TravisObregon\FilamentDiffs\Infolists\Components;

use Closure;
use Filament\Infolists\Components\Entry;
use Filament\Support\Components\Contracts\HasEmbeddedView;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Js;

class DiffEntry extends Entry implements HasEmbeddedView
{
    protected string | Closure | null $oldContent = null;

    protected string | Closure | null $newContent = null;

    protected string | Closure | null $fileName = null;

    protected string | Closure | null $language = null;

    protected array | Closure $diffOptions = [];

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

    public function diffOptions(array | Closure $options): static
    {
        $this->diffOptions = $options;

        return $this;
    }

    public function fromModels(Model | Closure $old, Model | Closure $new, string | Closure $attribute = 'content'): static
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
     * @param  array<string, mixed> | Closure  $old
     * @param  array<string, mixed> | Closure  $new
     * @param  array<int, string> | null  $only
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
        return $this->evaluate($this->fileName);
    }

    public function getLanguage(): ?string
    {
        return $this->evaluate($this->language);
    }

    public function getDiffOptions(): array
    {
        return $this->evaluate($this->diffOptions) ?? [];
    }

    public function toEmbeddedHtml(): string
    {
        $payload = Js::from([
            'old' => $this->getOldContent(),
            'new' => $this->getNewContent(),
            'fileName' => $this->getFileName(),
            'language' => $this->getLanguage(),
            'options' => $this->getDiffOptions() ?: null,
        ]);

        $wireKey = md5(($this->getOldContent() ?? '') . ($this->getNewContent() ?? '') . ($this->getFileName() ?? ''));

        ob_start(); ?>

        <div
            wire:key="<?= e($wireKey) ?>"
            x-data="diffEntry(<?= $payload ?>)"
        >
            <div x-ref="container"></div>
        </div>

        <?php return $this->wrapEmbeddedHtml(ob_get_clean());
    }
}
