<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    @php
        $payload = $getPayload();
        $statePath = $getStatePath();
        $wireKey = $statePath . '-' . md5(json_encode($payload));
    @endphp

    <div
        ax-load
        ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('file-diff-entry', 'kirschbaum-development/filament-diffs') }}"
        x-data="fileDiffEntry(@js($payload))"
        wire:ignore
        wire:key="{{ $wireKey }}"
    >
        <div x-ref="mount"></div>
    </div>
</x-dynamic-component>
