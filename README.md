# Filament Diffs

[![Latest Version on Packagist](https://img.shields.io/packagist/v/travisobregon/filament-diffs.svg?style=flat-square)](https://packagist.org/packages/travisobregon/filament-diffs)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/travisobregon/filament-diffs/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/travisobregon/filament-diffs/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/travisobregon/filament-diffs.svg?style=flat-square)](https://packagist.org/packages/travisobregon/filament-diffs)

Render visual diffs between Eloquent model versions in [Filament](https://filamentphp.com). Powered by [@pierre/diffs](https://diffs.com).

![Screenshot](https://raw.githubusercontent.com/travisobregon/filament-diffs/main/.github/screenshot.png)

## Installation

Install the plugin with Composer:

```bash
composer require travisobregon/filament-diffs
```

## Infolist Entry

Use `DiffEntry` in any [infolist](https://filamentphp.com/docs/5.x/infolists/entries/getting-started) to display a diff between two strings:

```php
use TravisObregon\FilamentDiffs\Infolists\Components\DiffEntry;

DiffEntry::make('changes')
    ->label('Changes')
    ->old(fn ($record) => $record->previousVersion?->content)
    ->new(fn ($record) => $record->content)
```

Both `old()` and `new()` accept a string or a closure that receives the current record. If either value is `null`, it is treated as an empty string.

### Setting the File Name

The file name controls syntax highlighting detection when no explicit language is set:

```php
DiffEntry::make('changes')
    ->old(fn ($record) => $record->previousVersion?->content)
    ->new(fn ($record) => $record->content)
    ->fileName('post.md')
```

### Setting the Language

You can explicitly set the syntax highlighting language using any [Shiki language identifier](https://shiki.style/languages) (e.g., `php`, `javascript`, `markdown`, `json`):

```php
DiffEntry::make('changes')
    ->old(fn ($record) => $record->previousVersion?->content)
    ->new(fn ($record) => $record->content)
    ->language('markdown')
```

When both `fileName()` and `language()` are set, the explicit language takes precedence.

### Passing Options

You can pass additional options directly to the underlying [@pierre/diffs `FileDiff` component](https://diffs.com/docs):

```php
DiffEntry::make('changes')
    ->old(fn ($record) => $record->previousVersion?->content)
    ->new(fn ($record) => $record->content)
    ->options([
        'theme' => 'github-dark',
    ])
```

See the [@pierre/diffs documentation](https://diffs.com/docs) for all available options.

## Comparing Model Versions

Use `fromModels()` to compare an attribute across two Eloquent model instances:

```php
DiffEntry::make('changes')
    ->fromModels(
        old: fn ($record) => $record->previousVersion,
        new: fn ($record) => $record,
        attribute: 'content',
    )
```

Both `old` and `new` accept a model instance or a closure that receives the current record. The `attribute` parameter defaults to `'content'` and can be a string or closure. If the old model is `null`, the diff shows the full new content as additions.

## Comparing Arrays / JSON

Use `fromArrays()` to diff structured data. This automatically sets the language to `json`:

```php
DiffEntry::make('changes')
    ->fromArrays(
        old: fn ($record) => $record->previousVersion->settings,
        new: fn ($record) => $record->settings,
    )
```

### Limiting to Specific Keys

Use the `only` parameter to limit the diff to specific keys:

```php
DiffEntry::make('changes')
    ->fromArrays(
        old: fn ($record) => $record->previousVersion->settings,
        new: fn ($record) => $record->settings,
        only: ['theme', 'notifications'],
    )
```

## Configuration

### Config File

Publish the config file to set application-wide defaults:

```bash
php artisan vendor:publish --tag="filament-diffs-config"
```

```php
// config/filament-diffs.php
return [
    'default_file_name' => null,
    'default_language' => null,
    'default_options' => [],
];
```

### Panel Plugin

Register the plugin in your [panel provider](https://filamentphp.com/docs/5.x/panels/plugins) for per-panel configuration that overrides config file defaults:

```php
use TravisObregon\FilamentDiffs\FilamentDiffsPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugin(
            FilamentDiffsPlugin::make()
                ->defaultLanguage('markdown')
                ->defaultFileName('document.md')
                ->defaultOptions([
                    'theme' => 'github-dark',
                ])
        );
}
```

### Precedence

Settings are resolved in the following order (highest priority first):

1. Per-component — `->fileName()`, `->language()`, `->options()`
2. Panel plugin — `FilamentDiffsPlugin` fluent methods
3. Config file — `config/filament-diffs.php`

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Travis Obregon](https://github.com/travisobregon)
- [@pierre/diffs](https://diffs.com) by [The Pierre Computer Co.](https://github.com/pierrecomputer)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
