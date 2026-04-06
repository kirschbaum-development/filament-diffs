<?php

use Kirschbaum\FilamentDiffs\Infolists\Components\FileEntry;

test('uses the correct view', function () {
    $entry = FileEntry::make('content');

    expect($entry->getView())->toBe('filament-diffs::file-entry');
});

test('getPayload returns state content and metadata', function () {
    config()->set('filament-diffs.default_theme', 'github-dark');

    $entry = FileEntry::make('content')
        ->state('<?php echo "hello";')
        ->fileName('hello.php')
        ->language('php');

    $payload = $entry->getPayload();

    expect($payload)->toEqual([
        'content' => '<?php echo "hello";',
        'fileName' => 'hello.php',
        'language' => 'php',
        'options' => [
            'theme' => 'github-dark',
        ],
    ]);
});

test('getPayload defaults content to empty string when state is null', function () {
    $entry = FileEntry::make('content')
        ->state(null);

    $payload = $entry->getPayload();

    expect($payload['content'])->toBe('');
});

test('getPayload works with closure-based configuration', function () {
    config()->set('filament-diffs.default_theme', 'github-dark');

    $entry = FileEntry::make('content')
        ->state('some code')
        ->fileName(fn () => 'dynamic.php')
        ->language(fn () => 'javascript')
        ->options(fn () => ['tabSize' => 2]);

    $payload = $entry->getPayload();

    expect($payload)->toEqual([
        'content' => 'some code',
        'fileName' => 'dynamic.php',
        'language' => 'javascript',
        'options' => [
            'theme' => 'github-dark',
            'tabSize' => 2,
        ],
    ]);
});
