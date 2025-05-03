document.addEventListener('DOMContentLoaded', function () {
    var map = L.map('map').setView([40.4168, -3.7038], 6); // vista inicial (España)

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var marker;

    document.getElementById('destino').addEventListener('change', function () {
        var destino = this.value;

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(destino)}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    var lat = parseFloat(data[0].lat);
                    var lon = parseFloat(data[0].lon);

                    // Centrar mapa
                    map.setView([lat, lon], 13);

                    // Agregar marcador
                    if (marker) {
                        map.removeLayer(marker);
                    }

                    marker = L.marker([lat, lon]).addTo(map);

                    // Rellenar campos ocultos
                    document.getElementById('latitud').value = lat;
                    document.getElementById('longitud').value = lon;
                }
            });
    });
});
