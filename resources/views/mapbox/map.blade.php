<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte avec Mapbox</title>

    <!-- Inclure Mapbox via CDN -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.css" rel="stylesheet" />

    <style>
        body { margin: 0; padding: 0; font-family: Arial, sans-serif; }
        #map { width: 100%; height: 500px; }
        .search-container {
            margin: 10px auto;
            text-align: center;
        }
        input[type="text"] {
            width: 300px;
            padding: 8px;
            margin-right: 10px;
        }
        button {
            padding: 8px 15px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Entrez une adresse...">
        <button onclick="searchLocation()">Rechercher</button>
    </div>

    {{-- intégration de la mapbox avec la syntaxe de Blade --}}
    <x-mapbox id="map" position="relative" :navigationControls="true"/>

    <div id="map"></div>

    <script>
        mapboxgl.accessToken = "{{ env('MAPBOX_TOKEN') }}";

        let map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [5.5718, 50.6372], // Liège
            zoom: 12
        });

        function searchLocation() {
            let query = document.getElementById('searchInput').value;
            if (!query) return alert("Veuillez entrer une adresse.");

            fetch(`/map/search?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.longitude || !data.latitude) {
                        alert("Adresse introuvable.");
                        return;
                    }

                    let coords = [data.longitude, data.latitude];
                    map.flyTo({ center: coords, zoom: 14 });

                    new mapboxgl.Marker()
                        .setLngLat(coords)
                        .setPopup(new mapboxgl.Popup().setText(data.full_address))
                        .addTo(map);
                })
                .catch(error => console.error("Erreur de recherche :", error));
        }
    </script>

</body>
</html>
