<?php

use Filament\Contracts\Plugin;
use Filament\Infolists\Components\Entry;
use Kirschbaum\FilamentDiffs\FilamentDiffsPlugin;
use Kirschbaum\FilamentDiffs\FilamentDiffsServiceProvider;
use Kirschbaum\FilamentDiffs\Infolists\Components\FileDiffEntry;
use Kirschbaum\FilamentDiffs\Infolists\Components\FileEntry;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
