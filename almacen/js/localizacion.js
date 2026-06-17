// js/optimizador.js
$(document).ready(function() {
    const MapaRutas = {
        init: function() {
            // Inicializar mapa Leaflet
            this.mapa = L.map('mapaRutas').setView([-12.0464, -77.0428], 12);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(this.mapa);
            this.capasRuta = L.layerGroup().addTo(this.mapa);
        },
        
        dibujarRuta: function(ruta) {
            // Limpiar capa anterior
            this.capasRuta.clearLayers();
            
            // Crear coordenadas para la polyline
            const coordenadas = [];
            $.each(ruta, function(index, punto) {
                coordenadas.push([punto.latitud, punto.longitud]);
            });
            
            // Dibujar línea de ruta
            L.polyline(coordenadas, {color: 'blue', weight: 4}).addTo(this.capasRuta);
            
            // Agregar marcadores
            $.each(ruta, function(index, punto) {
                let icono;
                if (index === 0) {
                    icono = L.icon({
                        iconUrl: 'img/inicio.png',
                        iconSize: [30, 30]
                    });
                } else if (index === ruta.length - 1) {
                    icono = L.icon({
                        iconUrl: 'img/fin.png',
                        iconSize: [30, 30]
                    });
                } else {
                    icono = L.icon({
                        iconUrl: 'img/punto.png',
                        iconSize: [25, 25]
                    });
                }
                
                L.marker([punto.latitud, punto.longitud], {icon: icono})
                 .bindPopup(`
                     <b>${punto.direccion}</b><br>
                     Prioridad: ${punto.prioridad}<br>
                     Tiempo: ${punto.tiempo_estimado}min
                 `)
                 .addTo(MapaRutas.capasRuta);
            });
            
            // Ajustar vista del mapa
            this.mapa.fitBounds(coordenadas);
        },
        
        actualizarPanelInfo: function(ruta, metricas) {
            let html = `
                <div class="card">
                    <div class="card-header">
                        <h5>Ruta Optimizada</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Distancia total:</strong> ${metricas.distancia_total}</p>
                        <p><strong>Tiempo estimado:</strong> ${metricas.tiempo_total}</p>
                        <p><strong>Puntos de entrega:</strong> ${metricas.numero_puntos}</p>
                        <hr>
                        <h6>Secuencia de entregas:</h6>
            `;
            
            $.each(ruta, function(index, punto) {
                if (index > 0) { // Saltar punto de inicio
                    html += `
                        <div class="punto-entrega prioridad-${punto.prioridad}">
                            <span class="numero">${index}.</span>
                            ${punto.direccion}
                            <span class="badge bg-${punto.prioridad}">${punto.prioridad}</span>
                        </div>
                    `;
                }
            });
            
            html += `</div></div>`;
            $('#panelRuta').html(html);
        }
    };
    
    // Inicializar mapa
    MapaRutas.init();
    
    // Evento para optimizar ruta
    $('#btnOptimizar').click(function() {
        const latInicio = $('#latInicio').val() || -12.0464;
        const lonInicio = $('#lonInicio').val() || -77.0428;
        
        $.ajax({
            url: '../admin/index.php?action=localizacion', 
            type: 'POST',
            data: {
                action: 'optimizar_ruta',
                lat_inicio: latInicio,
                lon_inicio: lonInicio
            },
            dataType: 'json',
            beforeSend: function() {
                $('#loading').show();
            },
            success: function(response) {
                if (response.success) {
                    MapaRutas.dibujarRuta(response.ruta);
                    MapaRutas.actualizarPanelInfo(response.ruta, response.metricas);
                } else {
                    alert('Error al optimizar la ruta');
                }
            },
            complete: function() {
                $('#loading').hide();
            }
        });
    });
    
    // Cargar ubicaciones al iniciar
    $('#btnOptimizar').click();
});