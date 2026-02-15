@extends('layouts.admin')

@section('header')
    {{ __('members.clan_distribution_map') ?? 'Clan Distribution Map' }}
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="mb-4 flex justify-between items-center">
        <div>
            <h3 class="text-lg font-bold text-gray-800">{{ __('messages.geo_analytics') ?? 'Geospatial Analytics' }}</h3>
            <p class="text-sm text-gray-500">{{ __('messages.map_description') ?? 'Visualizing Msomi Clan presence across the region.' }}</p>
        </div>
        <div class="bg-indigo-50 px-4 py-2 rounded-md border border-indigo-100">
            <span class="text-indigo-700 font-bold" id="totalMembers">0</span>
            <span class="text-indigo-600 text-sm ml-1">{{ __('members.members_mapped') ?? 'Members Mapped' }}</span>
        </div>
    </div>

    <!-- Map Container -->
    <div id="map" class="h-[600px] w-full rounded-lg border-2 border-gray-100 z-0"></div>

    <!-- Legend -->
    <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4" id="regionSummary">
        <!-- Will be populated by JS -->
    </div>
</div>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<style>
    .leaflet-popup-content-wrapper {
        border-radius: 8px;
        font-family: 'Figtree', sans-serif;
    }
    .custom-cluster {
        background: rgba(79, 70, 229, 0.6);
        border: 2px solid #4f46e5;
        border-radius: 50%;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        box-shadow: 0 0 10px rgba(79, 70, 229, 0.4);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var map = L.map('map').setView([-6.3690, 34.8888], 6); // Center of Tanzania

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        fetch('{{ route('members.map-data') }}')
            .then(response => response.json())
            .then(data => {
                let total = 0;
                let summaryHtml = '';

                data.forEach(item => {
                    total += item.count;
                    
                    // Create circle marker proportional to count
                    var radius = Math.sqrt(item.count) * 10;
                    var marker = L.circleMarker([item.lat, item.lng], {
                        radius: radius,
                        fillColor: "#4f46e5",
                        color: "#312e81",
                        weight: 1,
                        opacity: 1,
                        fillOpacity: 0.6
                    }).addTo(map);

                    marker.bindPopup(`
                        <div class="p-2">
                            <h4 class="font-bold text-lg text-indigo-700">${item.region}</h4>
                            <p class="text-gray-600 text-base">${item.count} Members</p>
                        </div>
                    `);

                    // Add to summary
                    summaryHtml += `
                        <div class="bg-gray-50 p-3 rounded-md border border-gray-100">
                            <span class="block text-xs text-gray-500 uppercase font-bold">${item.region}</span>
                            <span class="text-xl font-bold text-gray-800">${item.count}</span>
                        </div>
                    `;
                });

                document.getElementById('totalMembers').innerText = total;
                document.getElementById('regionSummary').innerHTML = summaryHtml;
            });
    });
</script>
@endsection
