@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/locales/id.global.min.js"></script>
@endpush

<x-filament-panels::page>
    <div class="space-y-4">
        {{-- Calendar Container --}}
        <div 
            id="holiday-calendar"
            class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4"
            wire:ignore
        ></div>
        
        {{-- Legend --}}
        <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 bg-red-600 rounded"></span>
                <span>Hari Libur Nasional</span>
            </div>
            <span>•</span>
            <span>Klik tanggal untuk menambah hari libur</span>
            <span>•</span>
            <span>Klik event untuk menghapus</span>
        </div>
    </div>

    {{-- Add Holiday Modal --}}
    <div 
        x-data="{ 
            showModal: false, 
            selectedDate: '', 
            holidayName: '',
            open(date) {
                this.selectedDate = date;
                this.holidayName = '';
                this.showModal = true;
            },
            close() {
                this.showModal = false;
            },
            save() {
                if (this.holidayName.trim()) {
                    $wire.addHoliday(this.selectedDate, this.holidayName);
                    this.close();
                }
            }
        }"
        x-show="showModal" 
        x-cloak
        @open-holiday-modal.window="open($event.detail.date)"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
        @keydown.escape.window="close()"
    >
        <div 
            class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 w-full max-w-md mx-4"
            @click.away="close()"
        >
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Tambah Hari Libur
            </h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Tanggal
                    </label>
                    <input 
                        type="date" 
                        x-model="selectedDate"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm"
                    />
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Nama Hari Libur
                    </label>
                    <input 
                        type="text" 
                        x-model="holidayName"
                        placeholder="Contoh: Hari Kemerdekaan RI"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm"
                        @keydown.enter="save()"
                    />
                </div>
            </div>
            
            <div class="mt-6 flex justify-end gap-3">
                <button 
                    type="button"
                    @click="close()"
                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600"
                >
                    Batal
                </button>
                <button 
                    type="button"
                    @click="save()"
                    class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700"
                >
                    Simpan
                </button>
            </div>
        </div>
    </div>
</x-filament-panels::page>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    initHolidayCalendar();
});

document.addEventListener('livewire:navigated', function() {
    initHolidayCalendar();
});

function initHolidayCalendar() {
    const calendarEl = document.getElementById('holiday-calendar');
    if (!calendarEl || calendarEl.dataset.initialized) return;
    
    calendarEl.dataset.initialized = 'true';
    
    const holidays = @js($this->getHolidays());
    
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'id',
        selectable: true,
        navLinks: true,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth'
        },
        events: holidays,
        dateClick: function(info) {
            window.dispatchEvent(new CustomEvent('open-holiday-modal', { 
                detail: { date: info.dateStr } 
            }));
        },
        select: function(info) {
            window.dispatchEvent(new CustomEvent('open-holiday-modal', { 
                detail: { date: info.startStr } 
            }));
        },
        eventClick: function(info) {
            if (confirm('Hapus hari libur "' + info.event.title + '"?')) {
                @this.deleteHoliday(info.event.id);
            }
        },
        height: 'auto',
        buttonText: {
            today: 'Hari Ini',
            month: 'Bulan'
        }
    });
    
    calendar.render();
    
    Livewire.on('holiday-added', () => window.location.reload());
    Livewire.on('holiday-deleted', () => window.location.reload());
}
</script>
@endpush
