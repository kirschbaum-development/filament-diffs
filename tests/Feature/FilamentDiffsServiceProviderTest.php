<?php

test('loads the config file', function () {
    expect(config('filament-diffs'))->toBeArray()
        ->and(config('filament-diffs.default_theme'))->toBeNull();
});

test('registers the file-entry view', function () {
    expect(view()->exists('filament-diffs::file-entry'))->toBeTrue();
});

test('registers the file-diff-entry view', function () {
    expect(view()->exists('filament-diffs::file-diff-entry'))->toBeTrue();
});
