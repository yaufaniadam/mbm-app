<x-filament-panels::page>
    <div class="flex items-center gap-4 p-4 bg-white dark:bg-gray-900 rounded-xl shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 mb-4">
        <div class="w-full md:w-64">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-200 block mb-1">Tanggal Presensi</label>
            <input
                type="date"
                wire:model.live="selected_date"
                class="block w-full rounded-lg border-gray-300 shadow-sm transition duration-75 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:bg-gray-900 dark:border-gray-600 dark:text-white dark:focus:border-primary-500"
            />
        </div>
    </div>

    {{ $this->table }}
</x-filament-panels::page>
