<?php

use Kirschbaum\FilamentDiffs\Infolists\Components\FileDiffEntry;

test('uses the correct view', function () {
    $entry = FileDiffEntry::make('content');

    expect($entry->getView())->toBe('filament-diffs::file-diff-entry');
});

test('old is fluent', function () {
    $entry = FileDiffEntry::make('content');

    $result = $entry->old('old content');

    expect($result)->toBe($entry);
});

test('new is fluent', function () {
    $entry = FileDiffEntry::make('content');

    $result = $entry->new('new content');

    expect($result)->toBe($entry);
});

test('getOldContent returns literal string', function () {
    $entry = FileDiffEntry::make('content')
        ->old('old content');

    expect($entry->getOldContent())->toBe('old content');
});

test('getOldContent evaluates closure', function () {
    $entry = FileDiffEntry::make('content')
        ->old(fn () => 'dynamic old');

    expect($entry->getOldContent())->toBe('dynamic old');
});

test('getOldContent returns null when unset', function () {
    $entry = FileDiffEntry::make('content');

    expect($entry->getOldContent())->toBeNull();
});

test('getNewContent returns literal string', function () {
    $entry = FileDiffEntry::make('content')
        ->new('new content');

    expect($entry->getNewContent())->toBe('new content');
});

test('getNewContent evaluates closure', function () {
    $entry = FileDiffEntry::make('content')
        ->new(fn () => 'dynamic new');

    expect($entry->getNewContent())->toBe('dynamic new');
});

test('getNewContent returns null when unset', function () {
    $entry = FileDiffEntry::make('content');

    expect($entry->getNewContent())->toBeNull();
});

test('getPayload returns old/new content and metadata', function () {
    config()->set('filament-diffs.default_theme', 'github-dark');

    $entry = FileDiffEntry::make('content')
        ->old('old code')
        ->new('new code')
        ->fileName('app.php')
        ->language('php');

    $payload = $entry->getPayload();

    expect($payload)->toEqual([
        'old' => 'old code',
        'new' => 'new code',
        'fileName' => 'app.php',
        'language' => 'php',
        'options' => [
            'theme' => 'github-dark',
        ],
    ]);
});

test('getPayload defaults old and new to empty strings when null', function () {
    $entry = FileDiffEntry::make('content');

    $payload = $entry->getPayload();

    expect($payload['old'])->toBe('')
        ->and($payload['new'])->toBe('');
});

test('getPayload works with closure-based configuration', function () {
    config()->set('filament-diffs.default_theme', 'github-dark');

    $entry = FileDiffEntry::make('content')
        ->old(fn () => 'old dynamic')
        ->new(fn () => 'new dynamic')
        ->fileName(fn () => 'dynamic.php')
        ->language(fn () => 'javascript')
        ->options(fn () => ['tabSize' => 2]);

    $payload = $entry->getPayload();

    expect($payload)->toEqual([
        'old' => 'old dynamic',
        'new' => 'new dynamic',
        'fileName' => 'dynamic.php',
        'language' => 'javascript',
        'options' => [
            'theme' => 'github-dark',
            'tabSize' => 2,
        ],
    ]);
});
