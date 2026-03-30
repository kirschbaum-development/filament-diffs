<?php

use Kirschbaum\FilamentDiffs\Infolists\Components\FileEntry;

test('uses the correct view', function () {
    $entry = FileEntry::make('content');

    expect($entry->getView())->toBe('filament-diffs::file-entry');
});

test('getOptions merges theme and evaluated options', function () {
    config()->set('filament-diffs.default_theme', 'github-dark');

    $entry = FileEntry::make('content')
        ->options(['tabSize' => 4]);

    $options = $entry->getOptions();

    expect($options)
        ->toHaveKey('theme', 'github-dark')
        ->toHaveKey('tabSize', 4);
});

test('getOptions filters only null values', function () {
    config()->set('filament-diffs.default_theme', null);

    $entry = FileEntry::make('content')
        ->options([
            'showLineNumbers' => false,
            'tabSize' => 0,
            'title' => '',
            'foo' => null,
        ]);

    $options = $entry->getOptions();

    expect($options)
        ->toHaveKey('showLineNumbers', false)
        ->toHaveKey('tabSize', 0)
        ->toHaveKey('title', '')
        ->not->toHaveKey('foo')
        ->not->toHaveKey('theme');
});

test('getPayload returns state content and metadata', function () {
    $entry = FileEntry::make('content')
        ->state('<?php echo "hello";')
        ->fileName('hello.php')
        ->language('php');

    $payload = $entry->getPayload();

    expect($payload)
        ->toHaveKey('content', '<?php echo "hello";')
        ->toHaveKey('fileName', 'hello.php')
        ->toHaveKey('language', 'php')
        ->toHaveKey('options');
});

test('getPayload defaults content to empty string when state is null', function () {
    $entry = FileEntry::make('content')
        ->state(null);

    $payload = $entry->getPayload();

    expect($payload['content'])->toBe('');
});

test('getPayload works with closure-based configuration', function () {
    $entry = FileEntry::make('content')
        ->state('some code')
        ->fileName(fn () => 'dynamic.php')
        ->language(fn () => 'javascript')
        ->options(fn () => ['tabSize' => 2]);

    $payload = $entry->getPayload();

    expect($payload)
        ->toHaveKey('content', 'some code')
        ->toHaveKey('fileName', 'dynamic.php')
        ->toHaveKey('language', 'javascript')
        ->and($payload['options'])->toHaveKey('tabSize', 2);
});
