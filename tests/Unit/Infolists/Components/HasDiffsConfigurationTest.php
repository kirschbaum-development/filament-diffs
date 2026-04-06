<?php

use Kirschbaum\FilamentDiffs\Infolists\Components\FileDiffEntry;
use Kirschbaum\FilamentDiffs\Infolists\Components\FileEntry;

dataset('diff components', [
    'FileEntry' => fn () => FileEntry::make('content'),
    'FileDiffEntry' => fn () => FileDiffEntry::make('content'),
]);

test('fileName is fluent', function ($component) {
    $result = $component->fileName('app.php');

    expect($result)->toBe($component);
})->with('diff components');

test('language is fluent', function ($component) {
    $result = $component->language('php');

    expect($result)->toBe($component);
})->with('diff components');

test('options is fluent', function ($component) {
    $result = $component->options(['tabSize' => 4]);

    expect($result)->toBe($component);
})->with('diff components');

test('getFileName returns literal string', function ($component) {
    $component->fileName('app.php');

    expect($component->getFileName())->toBe('app.php');
})->with('diff components');

test('getFileName evaluates closure', function ($component) {
    $component->fileName(fn () => 'dynamic.php');

    expect($component->getFileName())->toBe('dynamic.php');
})->with('diff components');

test('getFileName returns null when unset', function ($component) {
    expect($component->getFileName())->toBeNull();
})->with('diff components');

test('getLanguage returns literal string', function ($component) {
    $component->language('php');

    expect($component->getLanguage())->toBe('php');
})->with('diff components');

test('getLanguage evaluates closure', function ($component) {
    $component->language(fn () => 'javascript');

    expect($component->getLanguage())->toBe('javascript');
})->with('diff components');

test('getLanguage returns null when unset', function ($component) {
    expect($component->getLanguage())->toBeNull();
})->with('diff components');

test('theme falls back to config when plugin is unavailable', function ($component) {
    config()->set('filament-diffs.default_theme', 'github-dark');

    $options = $component->getOptions();

    expect($options['theme'])->toBe('github-dark');
})->with('diff components');

test('theme returns null when neither plugin nor config provide a value', function ($component) {
    config()->set('filament-diffs.default_theme', null);

    $options = $component->getOptions();

    expect($options)->not->toHaveKey('theme');
})->with('diff components');

test('missing plugin does not throw', function ($component) {
    config()->set('filament-diffs.default_theme', null);

    expect($component->getOptions())->toBeArray();
})->with('diff components');

test('per-component options theme overrides config theme', function ($component) {
    config()->set('filament-diffs.default_theme', 'github-dark');

    $component->options(['theme' => 'min-light']);

    $options = $component->getOptions();

    expect($options['theme'])->toBe('min-light');
})->with('diff components');

test('options accepts a closure returning array', function ($component) {
    $component->options(fn () => ['tabSize' => 2]);

    $options = $component->getOptions();

    expect($options['tabSize'])->toBe(2);
})->with('diff components');

test('getOptions filters only null values, preserving falsy values', function ($component) {
    config()->set('filament-diffs.default_theme', null);

    $component->options([
        'showLineNumbers' => false,
        'tabSize' => 0,
        'title' => '',
        'foo' => null,
    ]);

    $options = $component->getOptions();

    expect($options)
        ->toHaveKey('showLineNumbers', false)
        ->toHaveKey('tabSize', 0)
        ->toHaveKey('title', '')
        ->not->toHaveKey('foo')
        ->not->toHaveKey('theme');
})->with('diff components');
