<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte avec Plusieurs Markers - Liège</title>

    <script src="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.css" rel="stylesheet" />

    <style>
        body { margin: 0; padding: 0; font-family: Arial, sans-serif; }
        #map { width: 100%; height: 500px; }
    </style>
</head>
<body>

    <h1 style="text-align:center;">Carte avec plusieurs markers à Liège</h1>

    {{-- intégration de la mapbox avec la syntaxe de Blade --}}
    <x-mapbox id="map" position="relative" :navigationControls="true"/>

    <script>

        mapboxgl.accessToken = "{{ env('MAPBOX_TOKEN') }}"; 

        let map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [5.5718, 50.6372], // Liège
            zoom: 12
        });

            fetch("{{ route('map.get_markers') }}")
            .then(response => response.json())
            .then(data => {
                data.forEach(marker => {
                    new mapboxgl.Marker()
                        .setLngLat([marker.longitude, marker.latitude])
                        .setPopup(new mapboxgl.Popup().setHTML(
                        `<strong>${marker.name}</strong><br>
                        <p>Lorem ipsum...</p><br>
                        <a href="${marker.link}" target="_blank">Voir plus</a>`
                    ))
                        .addTo(map);
                });
            })  
            .catch(error => console.error("Erreur lors de la récupération des markers :", error));
    </script>

</body>
</html>
