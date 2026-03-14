<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    @php
        $payload = $getPayload();
        $wireKey = md5(json_encode($payload));
    @endphp

    <div
        wire:key="filament-file-diff-entry-{{ $wireKey }}"
        x-data="filamentFileDiffEntry(@js($payload))"
    >
        <div x-ref="mount"></div>
    </div>
</x-dynamic-component>
