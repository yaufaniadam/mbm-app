<x-filament-panels::page>
    {{-- Page content --}}

    <div class="">
        <p>
            Menu hari {{ Carbon\Carbon::parse($menuData->tanggal)->locale('id')->translatedFormat('l, d F Y') }}
        </p>
    </div>

    <form>
        {{ $this->form }}
    </form>
</x-filament-panels::page>
