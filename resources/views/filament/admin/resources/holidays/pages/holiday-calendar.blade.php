<x-filament-panels::page>
    <div 
        x-data="{
            calendar: null,
            holidays: @js($this->getHolidays()),
            showModal: false,
            selectedDate: '',
            holidayName: '',
            
            init() {
                this.initCalendar();
                
                Livewire.on('holiday-added', () => {
                    this.refreshCalendar();
                    this.closeModal();
                });
                
                Livewire.on('holiday-deleted', () => {
                    this.refreshCalendar();
                });
            },
            
            initCalendar() {
                const calendarEl = this.$refs.calendar;
                this.calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'id',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,dayGridYear'
                    },
                    events: this.holidays,
                    dateClick: (info) => {
                        this.selectedDate = info.dateStr;
                        this.holidayName = '';
                        this.showModal = true;
                    },
                    eventClick: (info) => {
                        if (confirm('Hapus hari libur \"' + info.event.title + '\"?')) {
                            $wire.deleteHoliday(info.event.id);
                        }
                    },
                    height: 'auto',
                    buttonText: {
                        today: 'Hari Ini',
                        month: 'Bulan',
                        year: 'Tahun'
                    }
                });
                this.calendar.render();
            },
            
            refreshCalendar() {
                fetch(window.location.href)
                    .then(() => window.location.reload());
            },
            
            closeModal() {
                this.showModal = false;
                this.holidayName = '';
                this.selectedDate = '';
            },
            
            addHoliday() {
                if (this.holidayName.trim()) {
                    $wire.addHoliday(this.selectedDate, this.holidayName);
                }
            }
        }"
        x-init="init()"
    >
        {{-- FullCalendar CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/locales/id.global.min.js"></script>
        
        {{-- Calendar Container --}}
        <div 
            x-ref="calendar" 
            class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4"
        ></div>
        
        {{-- Add Holiday Modal --}}
        <div 
            x-show="showModal" 
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
            @keydown.escape.window="closeModal()"
        >
            <div 
                class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 w-full max-w-md mx-4"
                @click.away="closeModal()"
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
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500"
                        >
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Nama Hari Libur
                        </label>
                        <input 
                            type="text" 
                            x-model="holidayName"
                            placeholder="Contoh: Hari Kemerdekaan RI"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            @keydown.enter="addHoliday()"
                        >
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end gap-3">
                    <button 
                        type="button"
                        @click="closeModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600"
                    >
                        Batal
                    </button>
                    <button 
                        type="button"
                        @click="addHoliday()"
                        class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700"
                    >
                        Simpan
                    </button>
                </div>
            </div>
        </div>
        
        {{-- Legend --}}
        <div class="mt-4 flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
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
</x-filament-panels::page>
