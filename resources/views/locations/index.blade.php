@extends('main')

@section('title', __('Carte Interactive 🗺️'))

@section('content')
<!-- Add Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<section class="section py-5" style="background-color: var(--bg-soft); min-height: calc(100vh - 100px);">
    <div class="container-fluid px-lg-5">
        <div class="row mb-5 align-items-center" data-aos="fade-up">
            <div class="col-md-7">
                <span class="badge bg-soft text-main px-3 py-2 rounded-pill mb-3 border border-color shadow-sm">
                    <i class="fas fa-search-location me-2 text-success"></i>{{ __('Exploration Locale') }}
                </span>
                <h1 class="brand-font fw-bold mb-2 display-5 text-main">{{ __('Carte Interactive 🗺️') }}</h1>
                <p class="opacity-75 mb-0 fs-5 text-main">{{ __('Trouvez des pépites sans gluten près de chez vous au Maroc.') }}</p>
            </div>
            
            <div class="col-md-5 text-md-end mt-4 mt-md-0">
                <div class="d-flex flex-column flex-md-row gap-3 justify-content-md-end align-items-stretch align-items-md-center">
                    <button id="btn-near-me" class="btn btn-soft-primary rounded-pill px-4 py-2 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 h-100" style="min-height: 54px;">
                        <i class="fas fa-location-crosshairs"></i> {{ __('Près de moi') }}
                    </button>
                    <div class="input-group shadow-sm rounded-pill overflow-hidden border border-color glass h-100" style="max-width: 300px; min-height: 54px;">
                        <span class="input-group-text bg-transparent border-0"><i class="fas fa-search opacity-50 text-main"></i></span>
                        <input type="text" id="city-search" class="form-control border-0 bg-transparent shadow-none" placeholder="{{ __('Chercher...') }}">
                    </div>
                    <a href="{{ route('locations.create') }}" class="btn btn-main rounded-pill px-4 py-2 shadow-md fw-bold d-flex align-items-center justify-content-center gap-2 h-100" style="min-height: 54px;">
                        <i class="fas fa-plus"></i> {{ __('Ajouter') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-4 h-100">
            <!-- Sidebar list -->
            <div class="col-lg-4 order-2 order-lg-1" data-aos="fade-right">
                <div class="card card-custom border-0 shadow-sm glass custom-scrollbar" style="max-height: 700px; overflow-y: auto; border-radius: 24px;" id="locations-list">
                    @if(count($locations) > 0)
                        @foreach($locations as $lieu)
                        <div class="location-item p-4 border-bottom border-color transition-all" data-lat="{{ $lieu->latitude ?? '' }}" data-lng="{{ $lieu->longitude ?? '' }}" data-id="{{ $lieu->id }}" style="cursor: pointer; position: relative;">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="fw-bold brand-font mb-0 text-main fs-5" style="color: var(--btn-bg) !important;">{{ __($lieu->name) }}</h5>
                                <span class="badge bg-soft text-main border border-color rounded-pill">{{ __($lieu->type) }}</span>
                            </div>
                            <p class="small opacity-75 mb-3 text-main"><i class="fas fa-map-marker-alt me-2 text-success"></i>{{ $lieu->address }}</p>
                            <p class="small mb-0 opacity-75 text-main lh-base">{!! nl2br(e(__(\Illuminate\Support\Str::limit($lieu->description, 120)))) !!}</p>
                            
                            <!-- Simple active indicator -->
                            <div class="active-line" style="position: absolute; left: 0; top: 10%; bottom: 10%; width: 5px; background: var(--btn-bg); border-radius: 0 5px 5px 0; opacity: 0; transition: 0.3s;"></div>
                        </div>
                        @endforeach
                    @else
                        <div class="p-5 text-center opacity-50 text-main py-5">
                            <i class="fas fa-map-marker-slash fs-1 mb-4" style="font-size: 4rem !important;"></i>
                            <h5 class="fw-bold">{{ __('Aucun lieu répertorié') }}</h5>
                            <p>{{ __('Il n\'y a pas encore de lieux enregistrés dans votre région.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Map container -->
            <div class="col-lg-8 order-1 order-lg-2" data-aos="fade-left">
                <div class="card card-custom border-0 shadow-lg overflow-hidden glass p-2" style="height: 700px; border-radius: 24px;">
                    <div id="map" style="width: 100%; height: 100%; border-radius: 18px; z-index: 1;"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const map = L.map('map').setView([33.5731, -7.5898], 6);
        
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; CARTO',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        const locations = @json($locations);
        const markers = {};

        const customIcon = L.divIcon({
            className: 'custom-div-icon',
            html: `<div class="marker-pin"><i class="fas fa-leaf"></i></div>`,
            iconSize: [38, 38],
            iconAnchor: [19, 38],
            popupAnchor: [0, -40]
        });

        const bounds = [];
        locations.forEach(lieu => {
            if(lieu.latitude && lieu.longitude) {
                const marker = L.marker([lieu.latitude, lieu.longitude], {icon: customIcon}).addTo(map);
                const typesMapping = {
                    "Restaurant": "{{ __('Restaurant') }}",
                    "Boulangerie": "{{ __('Boulangerie') }}",
                    "Magasin": "{{ __('Magasin Spécialisé') }}",
                    "Supermarché": "{{ __('Supermarché') }}",
                    "Autre": "{{ __('Autre') }}"
                };
                const popupContent = `
                    <div class="text-center p-3" style="min-width: 180px;">
                        <h6 class="fw-bold mb-2 brand-font" style="color: var(--btn-bg); font-size: 1.2rem;">${lieu.name}</h6>
                        <span class="badge bg-soft text-main mb-3 border border-color">${typesMapping[lieu.type] || lieu.type}</span>
                        <p class="small mb-0 opacity-75"><i class="fas fa-location-arrow me-1 text-success"></i> ${lieu.city}</p>
                    </div>
                `;
                marker.bindPopup(popupContent, { className: 'custom-popup-premium' });
                markers[lieu.id] = marker;
                bounds.push([lieu.latitude, lieu.longitude]);
            }
        });

        if(bounds.length > 0) map.fitBounds(bounds, {padding: [50, 50]});

        document.querySelectorAll('.location-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.location-item').forEach(el => {
                    el.classList.remove('active-item');
                    el.querySelector('.active-line').style.opacity = '0';
                    el.style.backgroundColor = 'transparent';
                });
                
                this.classList.add('active-item');
                this.querySelector('.active-line').style.opacity = '1';
                this.style.backgroundColor = 'rgba(107, 142, 35, 0.05)';
                
                const lat = parseFloat(this.dataset.lat);
                const lng = parseFloat(this.dataset.lng);
                const id = this.dataset.id;
                
                if(!isNaN(lat) && !isNaN(lng)) {
                    map.flyTo([lat, lng], 16, { duration: 2, easeLinearity: 0.25 });
                    if(markers[id]) setTimeout(() => markers[id].openPopup(), 1800);
                }
            });
        });
        
        document.getElementById('city-search').addEventListener('keyup', e => {
            const term = e.target.value.toLowerCase();
            document.querySelectorAll('.location-item').forEach(item => {
                item.style.display = item.innerText.toLowerCase().includes(term) ? 'block' : 'none';
            });
        });

        let userCircle = null;

        // Near Me Feature with Filtering and Marker Sync
        document.getElementById('btn-near-me').addEventListener('click', function() {
            const btn = this;
            const originalContent = btn.innerHTML;
            
            if (navigator.geolocation) {
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>{{ __("Recherche...") }}';
                
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const userLat = position.coords.latitude;
                        const userLng = position.coords.longitude;
                        
                        map.flyTo([userLat, userLng], 13, { duration: 2 });
                        
                        // Clear old user circle
                        if (userCircle) map.removeLayer(userCircle);
                        
                        // Add marker for user
                        userCircle = L.circle([userLat, userLng], {
                            color: '#6b8e23',
                            fillColor: '#6b8e23',
                            fillOpacity: 0.2,
                            radius: 1000
                        }).addTo(map).bindPopup('{{ __("Vous êtes ici") }}').openPopup();

                        // Haversine distance function
                        function getDistance(lat1, lon1, lat2, lon2) {
                            const R = 6371; // km
                            const dLat = (lat2 - lat1) * Math.PI / 180;
                            const dLon = (lon2 - lon1) * Math.PI / 180;
                            const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                                      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
                                      Math.sin(dLon/2) * Math.sin(dLon/2);
                            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                            return R * c;
                        }

                        const items = Array.from(document.querySelectorAll('.location-item'));
                        const listContainer = document.getElementById('locations-list');
                        const radiusKm = 50;
                        let foundCount = 0;

                        items.forEach(item => {
                            const itemLat = parseFloat(item.dataset.lat);
                            const itemLng = parseFloat(item.dataset.lng);
                            const itemId = item.dataset.id;
                            
                            if (!isNaN(itemLat) && !isNaN(itemLng)) {
                                const dist = getDistance(userLat, userLng, itemLat, itemLng);
                                item.dataset.distance = dist;
                                
                                if (dist <= radiusKm) {
                                    item.style.display = 'block';
                                    foundCount++;
                                    // Add distance badge if not exists
                                    let distBadge = item.querySelector('.dist-badge');
                                    if (!distBadge) {
                                        distBadge = document.createElement('span');
                                        distBadge.className = 'badge bg-light text-success border border-success-subtle rounded-pill ms-2 dist-badge';
                                        item.querySelector('h5').appendChild(distBadge);
                                    }
                                    distBadge.innerText = `${dist.toFixed(1)} {{ __('km') }}`;
                                    
                                    // Show Marker
                                    if (markers[itemId]) {
                                        markers[itemId].addTo(map);
                                        // Update marker popup with translated type if needed
                                        const typesMapping = {
                                            "Restaurant": "{{ __('Restaurant') }}",
                                            "Boulangerie": "{{ __('Boulangerie') }}",
                                            "Magasin": "{{ __('Magasin Spécialisé') }}",
                                            "Supermarché": "{{ __('Supermarché') }}",
                                            "Autre": "{{ __('Autre') }}"
                                        };
                                        // Popups are static but let's assume they were created with correct translations or we rely on the ones created at start.
                                        // Actually, markers[itemId] popups were already created in the initial loop.
                                    }
                                } else {
                                    item.style.display = 'none';
                                    // Hide Marker
                                    if (markers[itemId]) {
                                        map.removeLayer(markers[itemId]);
                                    }
                                }
                            }
                        });

                        // Sort list by distance
                        items.sort((a, b) => (parseFloat(a.dataset.distance) || 9999) - (parseFloat(b.dataset.distance) || 9999));
                        items.forEach(item => listContainer.appendChild(item));

                        if (foundCount === 0) {
                            alert('{{ __("Aucun lieu trouvé dans un rayon de 50km") }}');
                        }

                        btn.disabled = false;
                        btn.innerHTML = originalContent;
                    },
                    (error) => {
                        alert('{{ __("Impossible de récupérer votre position") }}');
                        btn.disabled = false;
                        btn.innerHTML = originalContent;
                    },
                    { enableHighAccuracy: true }
                );
            } else {
                alert('{{ __("La géolocalisation n\'est pas supportée par votre navigateur") }}');
            }
        });
    });
</script>

<style>
    .location-item:hover { transform: translateX(8px); background-color: rgba(107, 142, 35, 0.03); }
    .active-item { background-color: rgba(107, 142, 35, 0.08) !important; }
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background-color: var(--btn-bg); border-radius: 10px; }
    
    .marker-pin {
        background: var(--btn-bg);
        width: 38px; height: 38px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50% 50% 50% 0;
        transform: rotate(-45deg);
        color: white; border: 3px solid white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        transition: 0.3s;
    }
    .marker-pin i { transform: rotate(45deg); font-size: 1rem; }
    .marker-pin:hover { transform: rotate(-45deg) scale(1.15); z-index: 1000; }

    .custom-popup-premium .leaflet-popup-content-wrapper {
        border-radius: 20px; border: none; padding: 5px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }
    html[data-bs-theme="dark"] .leaflet-layer { filter: invert(100%) hue-rotate(180deg) brightness(95%) contrast(90%); }
    html[data-bs-theme="dark"] .custom-popup-premium .leaflet-popup-content-wrapper { background: var(--card-bg); color: #fff; }
</style>
@endsection
