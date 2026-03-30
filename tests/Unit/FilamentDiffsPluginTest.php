<?php

use Kirschbaum\FilamentDiffs\FilamentDiffsPlugin;

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
