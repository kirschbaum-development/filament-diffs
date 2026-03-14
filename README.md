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

## Infolist Entries

### File Diff Entry

Use `FileDiffEntry` in any [infolist](https://filamentphp.com/docs/5.x/infolists/entries/getting-started) to display a diff between two strings:

```php
use TravisObregon\FilamentDiffs\Infolists\Components\FileDiffEntry;

FileDiffEntry::make('changes')
    ->label('Changes')
    ->old(fn ($record) => $record->previousVersion?->content)
    ->new(fn ($record) => $record->content)
```

Both `old()` and `new()` accept a string or a closure that receives the current record. If either value is `null`, it is treated as an empty string.

### File Entry

Use `FileEntry` to render a single file with syntax highlighting:

```php
use TravisObregon\FilamentDiffs\Infolists\Components\FileEntry;

FileEntry::make('source')
    ->label('Source Code')
    ->content(fn ($record) => $record->content)
    ->fileName('app.php')
```

### Setting the File Name

The file name controls syntax highlighting detection when no explicit language is set:

```php
FileDiffEntry::make('changes')
    ->old(fn ($record) => $record->previousVersion?->content)
    ->new(fn ($record) => $record->content)
    ->fileName('post.md')
```

### Setting the Language

You can explicitly set the syntax highlighting language using any [Shiki language identifier](https://shiki.style/languages) (e.g., `php`, `javascript`, `markdown`, `json`). When set, this overrides language detection from the file name:

```php
FileDiffEntry::make('changes')
    ->old(fn ($record) => $record->previousVersion?->content)
    ->new(fn ($record) => $record->content)
    ->language('markdown')
```

### Passing Options

You can pass additional options directly to the underlying [@pierre/diffs components](https://diffs.com/docs):

```php
FileDiffEntry::make('changes')
    ->old(fn ($record) => $record->previousVersion?->content)
    ->new(fn ($record) => $record->content)
    ->options([
        'theme' => 'github-dark',
    ])
```

See the [@pierre/diffs documentation](https://diffs.com/docs) for all available options.

## Configuration

### Config File

Publish the config file to set application-wide defaults:

```bash
php artisan vendor:publish --tag="filament-diffs-config"
```

```php
// config/filament-diffs.php
return [
    'default_theme' => null,
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
                ->defaultTheme('github-dark')
        );
}
```

### Precedence

Theme is resolved in the following order (highest priority first):

1. Per-component — `->options(['theme' => '...'])`
2. Panel plugin — `FilamentDiffsPlugin::make()->defaultTheme()`
3. Config file — `config('filament-diffs.default_theme')`

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
