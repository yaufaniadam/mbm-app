<x-filament-widgets::widget>
    {{-- 1. Load Leaflet CSS & JS directly here to guarantee they exist --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <x-filament::section>
        <div class="mb-4">
            <h2 class="text-lg font-bold">Live Interactions Map</h2>
        </div>

        {{-- Map Container --}}
        <div wire:ignore x-data="{
            map: null,
            markers: @js($markers),
        
            init() {
                // Wait a tiny bit to ensure the HTML element has width/height
                setTimeout(() => {
                    if (!this.$refs.map) return;
        
                    // Create Map
                    this.map = L.map(this.$refs.map).setView([-2.5489, 118.0149], 5);
        
                    // Add Tiles
                    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; OpenStreetMap'
                    }).addTo(this.map);
        
                    // Add Markers
                    this.markers.forEach(marker => {
                        L.marker([marker.lat, marker.lng])
                            .addTo(this.map)
                            .bindPopup(`<b>${marker.title}</b>`);
                    });
        
                    // Handle Clicks
                    this.map.on('click', (e) => {
                        $wire.handleMapClick(e.latlng.lat, e.latlng.lng);
                    });
        
                    // FORCE REDRAW: This fixes the 'grey box' issue
                    this.map.invalidateSize();
                }, 100);
            }
        }" {{-- Hardcoded style ensures height is never zero --}} style="height: 400px; width: 100%; z-index: 1;"
            class="w-full rounded-lg shadow-md border border-gray-300 dark:border-gray-700">
            <div x-ref="map" style="width: 100%; height: 100%;" class="rounded-lg"></div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
