<x-filament-panels::page>
    {{-- Page content --}}

    @if ($record)
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

        <x-filament::badge color="success" class="mt-4">
            Makanan siap untuk didistribusikan.
        </x-filament::badge>

        <div>
            <p class="text-2xl">
                Daftar sekolah penerima makanan
            </p>
            <div class="mt-8">
                <ul>
                    @foreach ($record->sppg->schools as $item)
                        <li class="">
                            {{ $item->nama_sekolah }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @else
        <x-filament::badge color="warning" class="mt-4">
            Belum ada makanan yang siap didistribusikan.
        </x-filament::badge>
    @endif



</x-filament-panels::page>
