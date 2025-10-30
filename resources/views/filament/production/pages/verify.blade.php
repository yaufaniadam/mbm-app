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
        @if ($record->status == 'Ditolak')
            <x-filament::badge color="gray" class="mt-4">
                Produk pangan tidak memenuhi kriteria
            </x-filament::badge>
        @elseif($record->status == 'Terverifikasi')
            <x-filament::badge color="success" class="mt-4">
                Makanan lolos kriteria dan siap untuk didistribusikan
            </x-filament::badge>
        @else
            <x-filament::badge color="primary" class="mt-4">
                Makanan sudah didistribusikan
            </x-filament::badge>
        @endif

    @endif
</x-filament-panels::page>
