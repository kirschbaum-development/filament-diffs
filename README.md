# Filament Diffs

[![Latest Version on Packagist](https://img.shields.io/packagist/v/travisobregon/filament-diffs.svg?style=flat-square)](https://packagist.org/packages/travisobregon/filament-diffs)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/travisobregon/filament-diffs/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/travisobregon/filament-diffs/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/travisobregon/filament-diffs.svg?style=flat-square)](https://packagist.org/packages/travisobregon/filament-diffs)

Render visual diffs between Eloquent model versions in Filament. Powered by [@pierre/diffs](https://diffs.com).

## Installation

```bash
composer require travisobregon/filament-diffs
```

## Usage

### Infolist Entry

Use `DiffEntry` in any infolist to display a diff between two strings:

```php
use TravisObregon\FilamentDiffs\Infolists\Components\DiffEntry;

DiffEntry::make('changes')
    ->label('Changes')
    ->old(fn ($record) => $record->previousVersion?->content)
    ->new(fn ($record) => $record->content)
    ->fileName('post.md')
    ->language('markdown')
```

### Comparing Model Versions

Use `fromModels()` to compare an attribute across two model instances:

```php
DiffEntry::make('changes')
    ->fromModels(
        old: fn ($record) => $record->previousVersion,
        new: fn ($record) => $record,
        attribute: 'content',
    )
```

### Comparing Arrays / JSON

Use `fromArrays()` to diff structured data (automatically sets language to `json`):

```php
DiffEntry::make('changes')
    ->fromArrays(
        old: fn ($record) => $record->previousVersion->settings,
        new: fn ($record) => $record->settings,
        only: ['theme', 'notifications'], // optional: limit to specific keys
    )
```

### Panel Plugin (Optional)

Register the plugin in your panel provider for per-panel configuration:

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
                    // Options passed to @pierre/diffs FileDiff component
                ])
        );
}
```

## Configuration

Publish the config file:

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

Per-component settings always take precedence over config defaults.

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
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
