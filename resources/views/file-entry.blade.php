<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    @php
        $payload = $getPayload();
        $wireKey = md5(json_encode($payload));
    @endphp

    <div
        wire:key="filament-file-entry-{{ $wireKey }}"
        x-data="filamentFileEntry(@js($payload))"
    >
        <div x-ref="mount"></div>
    </div>
</x-dynamic-component>
