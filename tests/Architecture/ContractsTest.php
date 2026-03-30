<?php

use Filament\Contracts\Plugin;
use Filament\Infolists\Components\Entry;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use TravisObregon\FilamentDiffs\FilamentDiffsPlugin;
use TravisObregon\FilamentDiffs\FilamentDiffsServiceProvider;
use TravisObregon\FilamentDiffs\Infolists\Components\FileDiffEntry;
use TravisObregon\FilamentDiffs\Infolists\Components\FileEntry;

test('plugin implements filament plugin contract')
    ->expect(FilamentDiffsPlugin::class)
    ->toImplement(Plugin::class);

test('service provider extends package service provider')
    ->expect(FilamentDiffsServiceProvider::class)
    ->toExtend(PackageServiceProvider::class);

test('FileEntry extends filament entry')
    ->expect(FileEntry::class)
    ->toExtend(Entry::class);

test('FileDiffEntry extends filament entry')
    ->expect(FileDiffEntry::class)
    ->toExtend(Entry::class);
