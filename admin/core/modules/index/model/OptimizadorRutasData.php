<?php
// optimizador.php
class OptimizadorRutasData {
    private $ubicaciones;
    
    public function __construct($ubicaciones) {
        // Validar que las ubicaciones tengan la estructura correcta
        $this->validarUbicaciones($ubicaciones);
        $this->ubicaciones = $ubicaciones;
    }
    
    private function validarUbicaciones($ubicaciones) {
        if (!is_array($ubicaciones)) {
            throw new Exception("Las ubicaciones deben ser un array");
        }
        
        $camposRequeridos = ['latitud', 'longitud', 'direccion', 'prioridad'];
        foreach ($ubicaciones as $index => $ubicacion) {
            foreach ($camposRequeridos as $campo) {
                if (!isset($ubicacion[$campo])) {
                    throw new Exception("Ubicación {$index} falta el campo: {$campo}");
                }
            }
            
            // Validar coordenadas
            if (!is_numeric($ubicacion['latitud']) || !is_numeric($ubicacion['longitud'])) {
                throw new Exception("Coordenadas inválidas en ubicación {$index}");
            }
        }
    }
    
    // Calcular distancia entre dos puntos (Haversine)
    public function calcularDistancia($lat1, $lon1, $lat2, $lon2) {
        $radioTierra = 6371; // km
        
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        
        $a = sin($dLat/2) * sin($dLat/2) + 
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * 
             sin($dLon/2) * sin($dLon/2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $radioTierra * $c;
    }
    
    // Algoritmo del vecino más cercano mejorado
    public function optimizarRuta($puntoInicio) {
        $noVisitados = $this->ubicaciones;
        $ruta = [$puntoInicio];
        $ubicacionActual = $puntoInicio;
        
        while (!empty($noVisitados)) {
            $masCercano = null;
            $distanciaMinima = PHP_FLOAT_MAX;
            $indiceCercano = null;
            
            foreach ($noVisitados as $index => $ubicacion) {
                $distancia = $this->calcularDistancia(
                    $ubicacionActual['latitud'], $ubicacionActual['longitud'],
                    $ubicacion['latitud'], $ubicacion['longitud']
                );
                
                if ($distancia < $distanciaMinima) {
                    $distanciaMinima = $distancia;
                    $masCercano = $ubicacion;
                    $indiceCercano = $index;
                }
            }
            
            if ($masCercano) {
                $ruta[] = $masCercano;
                $ubicacionActual = $masCercano;
                unset($noVisitados[$indiceCercano]);
            }
        }
        
        return $ruta;
    }
    
    // Generar rutas por prioridad mejorado
    public function generarRutaOptimizada($puntoInicio, $puntoFin = null) {
        // Filtrar por prioridad manteniendo los índices originales
        $alta = array_filter($this->ubicaciones, function($u) {
            return isset($u['prioridad']) && $u['prioridad'] === 'alta';
        });
        
        $media = array_filter($this->ubicaciones, function($u) {
            return isset($u['prioridad']) && $u['prioridad'] === 'media';
        });
        
        $baja = array_filter($this->ubicaciones, function($u) {
            return isset($u['prioridad']) && $u['prioridad'] === 'baja';
        });
        
        // Reindexar arrays
        $alta = array_values($alta);
        $media = array_values($media);
        $baja = array_values($baja);
        
        // Optimizar cada grupo
        $rutaAlta = !empty($alta) ? $this->optimizarRutaGrupo($alta, $puntoInicio) : [$puntoInicio];
        $ultimoPuntoAlta = end($rutaAlta);
        
        $rutaMedia = !empty($media) ? $this->optimizarRutaGrupo($media, $ultimoPuntoAlta) : [$ultimoPuntoAlta];
        $ultimoPuntoMedia = end($rutaMedia);
        
        $rutaBaja = !empty($baja) ? $this->optimizarRutaGrupo($baja, $ultimoPuntoMedia) : [$ultimoPuntoMedia];
        
        // Combinar rutas evitando duplicados del punto inicial
        $rutaCompleta = $rutaAlta;
        
        if (!empty($media)) {
            $rutaCompleta = array_merge($rutaCompleta, array_slice($rutaMedia, 1));
        }
        
        if (!empty($baja)) {
            $rutaCompleta = array_merge($rutaCompleta, array_slice($rutaBaja, 1));
        }
        
        // Agregar punto final si se especifica
        if ($puntoFin) {
            $rutaCompleta[] = $puntoFin;
        }
        
        return $rutaCompleta;
    }
    
    private function optimizarRutaGrupo($grupo, $puntoInicio) {
        $optimizadorGrupo = new OptimizadorRutasData($grupo);
        return $optimizadorGrupo->optimizarRuta($puntoInicio);
    }
    
    // Calcular métricas de la ruta mejorado
    public function calcularMetricas($ruta) {
        if (count($ruta) < 2) {
            return [
                'distancia_total' => '0 km',
                'tiempo_total' => '0 minutos',
                'numero_puntos' => count($ruta)
            ];
        }
        
        $distanciaTotal = 0;
        $tiempoTotal = 0;
        
        for ($i = 1; $i < count($ruta); $i++) {
            $distancia = $this->calcularDistancia(
                $ruta[$i-1]['latitud'], $ruta[$i-1]['longitud'],
                $ruta[$i]['latitud'], $ruta[$i]['longitud']
            );
            $distanciaTotal += $distancia;
            
            // Sumar tiempo estimado solo si no es punto de inicio/fin
            if (isset($ruta[$i]['tiempo_estimado']) && $ruta[$i]['prioridad'] != 'inicio' && $ruta[$i]['prioridad'] != 'fin') {
                $tiempoTotal += $ruta[$i]['tiempo_estimado'];
            }
        }
        
        return [
            'distancia_total' => round($distanciaTotal, 2) . ' km',
            'tiempo_total' => $tiempoTotal . ' minutos',
            'numero_puntos' => count($ruta),
            'entregas_totales' => count($ruta) - 1 // Excluye punto inicio
        ];
    }
}
?>