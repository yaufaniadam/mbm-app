<?php

namespace App\Livewire;

use Filament\Widgets\Widget;

class OsmMapWidget extends Widget
{
    protected string $view = 'livewire.osm-map-widget';

    // Example data to display on the map
    public array $markers = [];

    public function mount(): void
    {
        // Simulate fetching data from a model
        // In a real app: Location::all()->map(...)
        $this->markers = [
            ['lat' => -6.2088, 'lng' => 106.8456, 'title' => 'Jakarta'],
            ['lat' => -8.4095, 'lng' => 115.1889, 'title' => 'Bali'],
        ];
    }

    public function handleMapClick($lat, $lng): void
    {
        // You could save this to the DB or filter a table
        $this->js(<<<JS
            new FilamentNotification()
                .title('Location Selected')
                .body('Lat: $lat, Lng: $lng')
                .success()
                .send();
        JS);
    }
}
