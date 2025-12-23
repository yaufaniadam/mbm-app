<div class="flex items-center justify-center gap-2 p-2">
    @php
        $status = $record->dailyAttendances->firstWhere('attendance_date', $this->selected_date)?->status;
        $statuses = [
            'Hadir' => ['icon' => '✓', 'color' => 'success', 'bg' => 'bg-green-500', 'hover' => 'hover:bg-green-600', 'ring' => 'ring-green-600'],
            'Izin' => ['icon' => '📝', 'color' => 'warning', 'bg' => 'bg-yellow-500', 'hover' => 'hover:bg-yellow-600', 'ring' => 'ring-yellow-600'],
            'Sakit' => ['icon' => '🏥', 'color' => 'danger', 'bg' => 'bg-orange-500', 'hover' => 'hover:bg-orange-600', 'ring' => 'ring-orange-600'],
            'Alpha' => ['icon' => '✗', 'color' => 'danger', 'bg' => 'bg-red-500', 'hover' => 'hover:bg-red-600', 'ring' => 'ring-red-600'],
        ];
    @endphp

    <div class="flex items-center justify-center gap-2 p-2 rounded-lg border dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
        @foreach($statuses as $key => $config)
            <button
                type="button"
                wire:click="updateStatus({{ $record->id }}, '{{ $key }}')"
                wire:loading.attr="disabled"
                @if($status === $key) disabled @endif
                class="flex items-center gap-2 px-3 py-1.5 rounded-md transition-all text-sm font-medium shadow-sm text-white
                    {{ $config['bg'] }} {{ $config['hover'] }}
                    {{ $status === $key
                        ? 'opacity-50 cursor-not-allowed ring-2 ring-offset-2 ring-offset-gray-50 dark:ring-offset-gray-800 ' . $config['ring']
                        : 'hover:scale-105 active:scale-95'
                    }}"
            >
                <span>{{ $config['icon'] }}</span>
                <span>{{ $key }}</span>
            </button>
        @endforeach
    </div>
</div>
