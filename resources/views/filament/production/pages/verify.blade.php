<x-filament-panels::page>
    {{-- Page content --}}

    <div class="">
        <p>
            Menu hari {{ Carbon\Carbon::parse($record->tanggal)->locale('id')->translatedFormat('l, d F Y') }}
        </p>
        <p class="mt-4">
            {{ $record->menu_hari_ini }}
        </p>
        <p class="mt-4">
            Jumlah Porsi : {{ $record->jumlah }}
        </p>
    </div>


    {{ $this->form }}
    @if ($this->isEditable)
        <x-filament::button wire:click="save" class="mt-4">
            Simpan
        </x-filament::button>
    @else
        <x-filament::badge color="gray" class="mt-4">
            Produk pangan tidak memenuhi kriteria
        </x-filament::badge>
    @endif
</x-filament-panels::page>
