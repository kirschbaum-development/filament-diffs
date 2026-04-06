<?php

use Filament\Facades\Filament;
use Filament\Panel;
use Kirschbaum\FilamentDiffs\FilamentDiffsPlugin;
use Kirschbaum\FilamentDiffs\Infolists\Components\FileEntry;

test('returns the correct plugin id', function () {
    $plugin = FilamentDiffsPlugin::make();

    expect($plugin->getId())->toBe('filament-diffs');
});

test('sets and gets default theme', function () {
    $plugin = FilamentDiffsPlugin::make();

    $plugin->defaultTheme('github-dark');

    expect($plugin->getDefaultTheme())->toBe('github-dark');
});

test('default theme is fluent', function () {
    $plugin = FilamentDiffsPlugin::make();

    $result = $plugin->defaultTheme('github-dark');

    expect($result)->toBe($plugin);
});

test('default theme accepts null', function () {
    $plugin = FilamentDiffsPlugin::make();

    $plugin->defaultTheme('github-dark');
    $plugin->defaultTheme(null);

    expect($plugin->getDefaultTheme())->toBeNull();
});

test('default theme is null by default', function () {
    $plugin = FilamentDiffsPlugin::make();

    expect($plugin->getDefaultTheme())->toBeNull();
});

test('component getTheme prefers plugin theme over config', function () {
    config()->set('filament-diffs.default_theme', 'config-theme');

    $plugin = FilamentDiffsPlugin::make()
        ->defaultTheme('plugin-theme');

    $panel = new Panel;
    $panel->id('test-panel-2');
    $panel->plugin($plugin);

    Filament::registerPanel($panel);
    Filament::setCurrentPanel($panel);

    $entry = FileEntry::make('content');

    expect($entry->getTheme())->toBe('plugin-theme');
});
