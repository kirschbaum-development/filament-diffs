<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    @php
        $payload = $getPayload();
        $wireKey = md5(json_encode($payload));
    @endphp

    <div
        wire:key="filament-diffs-{{ $wireKey }}"
        x-data="filamentDiffs(@js($payload))"
    >
        <div x-ref="mount"></div>
    </div>
</x-dynamic-component>
