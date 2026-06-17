<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubicación en Venezuela</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        #resultados {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
        }
        .loading {
            color: #666;
        }
    </style>
</head>
<body>
    <h1>Ubicación en Venezuela</h1>
    <p>Este script detectará tu ubicación y mostrará el estado, municipio y parroquia donde te encuentras.</p>
    
    <button id="obtenerUbicacion">Obtener Ubicación</button>
    
    <div id="resultados">
        <p>Presiona el botón para obtener tu ubicación</p>
    </div>

    <script>
        document.getElementById('obtenerUbicacion').addEventListener('click', function() {
            const resultadosDiv = document.getElementById('resultados');
            resultadosDiv.innerHTML = '<p class="loading">Obteniendo ubicación...</p>';
            
            if (!navigator.geolocation) {
                resultadosDiv.innerHTML = '<p class="error">Tu navegador no soporta geolocalización</p>';
                return;
            }
            
            navigator.geolocation.getCurrentPosition(
                async function(position) {
                    try {
                        const lat = position.coords.latitude;
                        const lon = position.coords.longitude;
                        
                        resultadosDiv.innerHTML = `
                            <p class="loading">Coordenadas obtenidas: ${lat.toFixed(6)}, ${lon.toFixed(6)}</p>
                            <p class="loading">Buscando dirección...</p>
                        `;
                        
                        // Consultar la API de Nominatim (OpenStreetMap)
                        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}&accept-language=es`);
                        const data = await response.json();
                        
                        if (data.error) {
                            throw new Error(data.error);
                        }
                        
                        // Extraer información de Venezuela
                        let estado = '';
                        let municipio = '';
                        let parroquia = '';
                        
                        // La estructura puede variar, así que buscamos en diferentes niveles
                        if (data.address) {
                            // Venezuela tiene estados como "state" en OSM
                            estado = data.address.state || '';
                            
                            // Municipio puede aparecer como "municipality", "county" o en otros campos
                            municipio = data.address.municipality || data.address.county || '';
                            
                            // Parroquia puede aparecer como "parish", "suburb" o "neighbourhood"
                            parroquia = data.address.parish || data.address.suburb || data.address.neighbourhood || '';
                        }
                        
                        // Mostrar resultados
                        resultadosDiv.innerHTML = `
                            <h3>Ubicación en Venezuela</h3>
                            <p><strong>Coordenadas:</strong> ${lat.toFixed(6)}, ${lon.toFixed(6)}</p>
                            <p><strong>Estado:</strong> ${estado || 'No identificado'}</p>
                            <p><strong>Municipio:</strong> ${municipio || 'No identificado'}</p>
                            <p><strong>Parroquia:</strong> ${parroquia || 'No identificado'}</p>
                            ${data.address?.road ? `<p><strong>Calle/Avenida:</strong> ${data.address.road}</p>` : ''}
                        `;
                        
                        // Opcional: Mostrar datos completos para depuración
                        console.log("Datos completos de la ubicación:", data);
                        
                    } catch (error) {
                        resultadosDiv.innerHTML = `
                            <p class="error">Error al obtener la dirección: ${error.message}</p>
                            <p>Intenta nuevamente o verifica tu conexión a internet.</p>
                        `;
                        console.error("Error:", error);
                    }
                },
                function(error) {
                    let mensaje = '';
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            mensaje = "Permiso denegado para acceder a la ubicación";
                            break;
                        case error.POSITION_UNAVAILABLE:
                            mensaje = "Información de ubicación no disponible";
                            break;
                        case error.TIMEOUT:
                            mensaje = "Tiempo de espera agotado al obtener la ubicación";
                            break;
                        case error.UNKNOWN_ERROR:
                            mensaje = "Error desconocido al obtener la ubicación";
                            break;
                    }
                    resultadosDiv.innerHTML = `<p class="error">${mensaje}</p>`;
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        });
    </script>
</body>
</html>