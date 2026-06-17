$(document).ready(function() {
    // Estado de la aplicación
    const AppState = {
        stream: null,
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
        checkCameraSupport().then(result => {
            if (!result.supported || !result.hasCamera) {
                showStatus(`⚠️ ${result.message}`, 'warning');
                $('#startCamera').prop('disabled', true);
            }
        });
        
        setupEventListeners();
        disableButtonsOnStart();
    }

    // Configurar eventos
    function setupEventListeners() {
        $('#startCamera').on('click', handleStartCamera);
        $('#capturePhoto').on('click', handleCapturePhoto);
        $('#getLocation').on('click', handleGetLocation);
        $('#saveData').on('click', handleSaveData);
        $(window).on('beforeunload', handleWindowUnload);
    }

    // Deshabilitar botones inicialmente
    function disableButtonsOnStart() {
        $('#capturePhoto, #saveData').prop('disabled', true);
    }

    // Iniciar cámara trasera
    function handleStartCamera() {
        showStatus('🔄 Iniciando cámara trasera...', 'info');
        
        startRearCamera()
            .then(stream => {
                AppState.stream = stream;
                const videoElement = $('#video').get(0);
                videoElement.srcObject = stream;
                
                return new Promise((resolve) => {
                    videoElement.onloadedmetadata = () => {
                        videoElement.play()
                            .then(resolve)
                            .catch(error => {
                                console.error('Error al reproducir video:', error);
                                throw new Error('No se pudo iniciar el video');
                            });
                    };
                });
            })
            .then(() => {
                $('#startCamera').prop('disabled', true);
                $('#capturePhoto').prop('disabled', false);
                showStatus('✅ Cámara trasera iniciada', 'success');
            })
            .catch(error => {
                console.error('Error de cámara:', error);
                let errorMessage = '❌ Error: ';
                
                if (error.name === 'NotAllowedError') {
                    errorMessage += 'Permiso denegado';
                } else if (error.name === 'NotFoundError') {
                    errorMessage += 'Cámara trasera no encontrada';
                } else if (error.name === 'NotReadableError') {
                    errorMessage += 'Cámara en uso';
                } else {
                    errorMessage += error.message;
                }
                
                showStatus(errorMessage, 'error');
            });
    }

    // Función para iniciar cámara trasera
    function startRearCamera() {
        return new Promise((resolve, reject) => {
            if (!navigator.mediaDevices?.getUserMedia) {
                reject(new Error('Navegador no compatible'));
                return;
            }
            
            const constraints = {
                video: {
                    facingMode: 'environment', // Prioriza cámara trasera
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                }
            };
            
            navigator.mediaDevices.getUserMedia(constraints)
                .then(resolve)
                .catch(error => {
                    // Si falla con environment, intenta con cualquier cámara
                    if (error.name === 'OverconstrainedError') {
                        constraints.video.facingMode = { ideal: ['environment', 'user'] };
                        navigator.mediaDevices.getUserMedia(constraints)
                            .then(resolve)
                            .catch(reject);
                    } else {
                        reject(error);
                    }
                });
        });
    }

    // Capturar foto
    function handleCapturePhoto() {
        if (!AppState.stream) {
            showStatus('🔴 Inicia la cámara primero', 'error');
            return;
        }
        
        capturePhotoFromStream(AppState.stream)
            .then(dataUrl => {
                AppState.photoDataUrl = dataUrl;
                $('#photoPreview').attr('src', dataUrl).show();
                showStatus('✅ Foto capturada', 'success');
                $('#saveData').prop('disabled', false);
            })
            .catch(error => {
                console.error('Error al capturar:', error);
                showStatus('❌ Error al capturar foto', 'error');
            });
    }

    // Función para capturar foto
    function capturePhotoFromStream(stream) {
        return new Promise((resolve, reject) => {
            const video = $('#video').get(0);
            const canvas = $('#canvas').get(0);
            
            if (video.readyState < HTMLMediaElement.HAVE_METADATA) {
                reject(new Error('Video no listo'));
                return;
            }
            
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            try {
                resolve(canvas.toDataURL('image/jpeg', 0.8));
            } catch (error) {
                reject(new Error('Error al generar imagen'));
            }
        });
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
                { enableHighAccuracy: true, timeout: 10000 }
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
        
        const photoData = AppState.photoDataUrl.split(',')[1];
        const locationData = AppState.locationData;
        
        saveDataToServer(photoData, locationData)
            .then(response => {
                if (response.success) {
                    showStatus('💾 Datos guardados', 'success');
                    resetAfterSave();
                } else {
                    showStatus(`❌ ${response.message}`, 'error');
                }
            })
            .catch(error => {
                console.error('Error al guardar:', error);
                showStatus('❌ Error de conexión', 'error');
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
                console.log('Datos enviados:', { photoData, locationData });
                resolve({ success: true, message: 'Datos guardados correctamente' });
            }, 1000);
        });
    }

    // Reiniciar después de guardar
    function resetAfterSave() {
        if (AppState.stream) {
            AppState.stream.getTracks().forEach(track => track.stop());
        }
        
        AppState.stream = null;
        AppState.photoDataUrl = '';
        AppState.locationData = { latitude: null, longitude: null, accuracy: null, timestamp: null };
        
        $('#video').attr('srcObject', null);
        $('#photoPreview').hide().attr('src', '');
        $('#latitude, #longitude, #accuracy, #timestamp').text('-');
        $('#startCamera').prop('disabled', false);
        $('#capturePhoto, #saveData').prop('disabled', true);
    }

    // Cerrar cámara al salir
    function handleWindowUnload() {
        if (AppState.stream) {
            AppState.stream.getTracks().forEach(track => track.stop());
        }
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

    // Verificar soporte de cámara
    function checkCameraSupport() {
        return new Promise((resolve) => {
            if (!navigator.mediaDevices?.getUserMedia) {
                resolve({ supported: false, message: 'Navegador no compatible' });
                return;
            }
            
            navigator.mediaDevices.enumerateDevices()
                .then(devices => {
                    const hasCamera = devices.some(device => device.kind === 'videoinput');
                    resolve({
                        supported: true,
                        hasCamera,
                        message: hasCamera ? '' : 'No se encontraron cámaras'
                    });
                })
                .catch(() => resolve({ supported: false, message: 'Error al detectar cámaras' }));
        });
    }

    // Iniciar la aplicación
    initializeApp();
});


