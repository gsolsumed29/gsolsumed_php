$(document).ready(function() {
    // Estado de la aplicación
    const AppState = {
        photoDataUrl: '',
        locationData: {
            latitude: null,
            longitude: null,
            accuracy: null,
            timestamp: null
        }
    };

    // Inicialización
    function initializeApp() {
        setupEventListeners();
        disableButtonsOnStart();
    }

    // Configurar eventos
    function setupEventListeners() {
        $('#capturePhoto').on('click', handleCapturePhoto);
        $('#getLocation').on('click', handleGetLocation);
        $('#saveData').on('click', handleSaveData);
        $('#cameraInput').on('change', handleCameraInputChange);
    }

    // Deshabilitar botones inicialmente
    function disableButtonsOnStart() {
        $('#saveData').prop('disabled', true);
    }

    // Manejar la captura de foto usando input file
    function handleCapturePhoto() {
        // Crear input file dinámicamente si no existe
        let $cameraInput = $('#cameraInput');
        if ($cameraInput.length === 0) {
            $cameraInput = $('<input>', {
                type: 'file',
                id: 'cameraInput',
                accept: 'image/*',
                capture: 'environment', // 'environment' para cámara trasera, 'user' para frontal
                style: 'display: none'
            });
            $('body').append($cameraInput);
            $cameraInput.on('change', handleCameraInputChange);
        }
        
        // Resetear el input para permitir seleccionar la misma foto nuevamente
        $cameraInput.val('');
        
        // Abrir la cámara
        $cameraInput.click();
    }

    // Procesar la imagen seleccionada de la cámara/galería
    function handleCameraInputChange(event) {
        const file = event.target.files[0];
        
        if (!file) {
            showStatus('❌ No se seleccionó ninguna imagen', 'error');
            return;
        }

        // Verificar que sea una imagen
        if (!file.type.startsWith('image/')) {
            showStatus('❌ El archivo seleccionado no es una imagen', 'error');
            return;
        }

        showStatus('🔄 Procesando imagen...', 'info');

        const reader = new FileReader();
        
        reader.onload = function(e) {
            AppState.photoDataUrl = e.target.result;
            $('#photoPreview').attr('src', e.target.result).show();
            showStatus('✅ Foto capturada correctamente', 'success');
            
            // Habilitar botón de guardar si también tenemos ubicación
            if (AppState.locationData.latitude) {
                $('#saveData').prop('disabled', false);
            }
        };

        reader.onerror = function() {
            showStatus('❌ Error al leer la imagen', 'error');
        };

        reader.readAsDataURL(file);
    }

    // Obtener ubicación
    function handleGetLocation() {
        showStatus('🔄 Obteniendo ubicación...', 'info');
        
        getCurrentPosition()
            .then(position => {
                AppState.locationData = {
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude,
                    accuracy: position.coords.accuracy,
                    timestamp: new Date(position.timestamp).toLocaleString()
                };
                
                updateLocationUI(AppState.locationData);
                showStatus('📍 Ubicación obtenida', 'success');
                
                // Habilitar botón de guardar si también tenemos foto
                if (AppState.photoDataUrl) {
                    $('#saveData').prop('disabled', false);
                }
            })
            .catch(handleGeolocationError);
    }

    // Obtener posición actual
    function getCurrentPosition() {
        return new Promise((resolve, reject) => {
            if (!navigator.geolocation) {
                reject(new Error('Geolocalización no soportada'));
                return;
            }
            
            navigator.geolocation.getCurrentPosition(
                resolve,
                reject,
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        });
    }

    // Manejar errores de geolocalización
    function handleGeolocationError(error) {
        const errors = {
            1: 'Permiso denegado',
            2: 'Ubicación no disponible',
            3: 'Tiempo de espera agotado',
            default: 'Error desconocido'
        };
        
        showStatus(`❌ Geolocalización: ${errors[error.code] || errors.default}`, 'error');
        console.error('Error de geolocalización:', error);
    }

    // Actualizar UI de ubicación
    function updateLocationUI(location) {
        $('#latitude').text(location.latitude.toFixed(6));
        $('#longitude').text(location.longitude.toFixed(6));
        $('#accuracy').text(`${Math.round(location.accuracy)} metros`);
        $('#timestamp').text(location.timestamp);
    }

    // Guardar datos
    function handleSaveData() {
        if (!validateDataBeforeSave()) return;
        
        // Extraer solo los datos base64 de la imagen (sin el prefijo data:image/jpeg;base64,)
        const photoData = AppState.photoDataUrl.split(',')[1];
        const locationData = AppState.locationData;
        
        saveDataToServer(photoData, locationData)
            .then(response => {
                if (response.success) {
                    showStatus('💾 Datos guardados correctamente', 'success');
                    resetAfterSave();
                } else {
                    showStatus(`❌ ${response.message}`, 'error');
                }
            })
            .catch(error => {
                console.error('Error al guardar:', error);
                showStatus('❌ Error de conexión al guardar', 'error');
            });
    }

    // Validar datos antes de guardar
    function validateDataBeforeSave() {
        if (!AppState.photoDataUrl) {
            showStatus('🔴 Captura una foto primero', 'error');
            return false;
        }
        
        if (!AppState.locationData.latitude) {
            showStatus('🔴 Obtén la ubicación primero', 'error');
            return false;
        }
        
        return true;
    }

    // Guardar en el servidor (simulado)
    function saveDataToServer(photoData, locationData) {
        return new Promise((resolve) => {
            // Simular envío a un servidor
            setTimeout(() => {
                console.log('📤 Datos enviados al servidor:', { 
                    photoDataLength: photoData.length, 
                    locationData 
                });
                resolve({ success: true, message: 'Datos guardados correctamente' });
            }, 1000);
        });
    }

    // Reiniciar después de guardar
    function resetAfterSave() {
        AppState.photoDataUrl = '';
        AppState.locationData = { latitude: null, longitude: null, accuracy: null, timestamp: null };
        
        $('#photoPreview').hide().attr('src', '');
        $('#latitude, #longitude, #accuracy, #timestamp').text('-');
        $('#saveData').prop('disabled', true);
        
        // Resetear el input de cámara
        $('#cameraInput').val('');
    }

    // Mostrar mensajes de estado
    function showStatus(message, type) {
        const $status = $('#statusMessage');
        $status
            .removeClass('success error info warning')
            .addClass(type)
            .text(message)
            .fadeIn();
        
        if (type !== 'info') {
            setTimeout(() => $status.fadeOut(), 3000);
        }
    }

    // Iniciar la aplicación
    initializeApp();
});