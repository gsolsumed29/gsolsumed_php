$(document).ready(function() {
    const fileInput = $('#file-input');
    const dropZone = $('#drop-zone');
    const selectedFilesContainer = $('#selected-files');
    const errorMessage = $('#error-message');
    const errorText = $('#error-text');
    const previewSection = $('#preview-section');
    const processBtn = $('#process-btn');
    const clearBtn = $('#clear-btn');
    
    let selectedFiles = []; // Para TODOS los archivos seleccionados
    
    // Configurar eventos de arrastrar y soltar
    setupDragAndDrop();
    
    // Manejar la selección de archivos desde el botón
    $('.browse-btn').click(function() {
        fileInput.click();
    });
    
    // Manejar la selección de archivos desde el input
    fileInput.change(function(e) {
        const files = e.target.files;
        if (files.length > 0) {
            handleFiles(files);
        }
        // Limpiar el input para permitir seleccionar los mismos archivos nuevamente
        fileInput.val('');
    });
    
    function setupDragAndDrop() {
        // Prevenir comportamientos por defecto en eventos de drag
        $(document).on('dragenter dragover dragleave drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
        });
        
        // Eventos para la zona de drop
        dropZone.on('dragenter dragover', function() {
            $(this).addClass('drag-over');
            return false;
        });
        
        dropZone.on('dragleave', function() {
            $(this).removeClass('drag-over');
            return false;
        });
        
        dropZone.on('drop', function(e) {
            $(this).removeClass('drag-over');
            
            // Obtener los archivos soltados
            const files = e.originalEvent.dataTransfer.files;
            if (files.length > 0) {
                handleFiles(files);
            }
            
            return false;
        });
        
        // Permitir arrastrar archivos desde cualquier pestaña del navegador
        $(document).on('drop', function(e) {
            // Verificar si el drop ocurrió fuera de la zona de drop
            if (!$(e.target).closest(dropZone).length) {
                const files = e.originalEvent.dataTransfer.files;
                if (files.length > 0) {
                    // Crear un evento de drop simulado en la zona de drop
                    dropZone.trigger($.Event('drop', {
                        originalEvent: e.originalEvent
                    }));
                }
            }
        });
    }
    
    // Validar y procesar los archivos seleccionados (AHORA AGREGA, NO REEMPLAZA)
    function handleFiles(files) {
        hideError();
        let hasNewValidFiles = false;
        
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            
            // Verificar si el archivo ya fue agregado (evitar duplicados)
            const isDuplicate = selectedFiles.some(selectedFile => 
                selectedFile.name === file.name && 
                selectedFile.size === file.size &&
                selectedFile.type === file.type
            );
            
            if (isDuplicate) {
                showError(`El archivo "${file.name}" ya fue agregado.`);
                continue;
            }
            
            if (!isValidFileType(file)) {
                showError(`El archivo "${file.name}" no es un formato válido.`);
                continue;
            }
            
            if (file.size > 5 * 1024 * 1024) {
                showError(`El archivo "${file.name}" excede el tamaño máximo de 5MB.`);
                continue;
            }
            
            // Agregar el archivo a la lista (sin limpiar los anteriores)
            selectedFiles.push(file);
            renderFilePreview(file);
            hasNewValidFiles = true;
        }
        
        if (hasNewValidFiles) {
            updateUI();
        }
    }
    
    function isValidFileType(file) {
        const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.pdf)$/i;
        const allowedMimeTypes = [
            'image/jpeg', 'image/jpg', 'image/png', 
            'image/gif', 'application/pdf'
        ];
        return allowedExtensions.test(file.name) && allowedMimeTypes.includes(file.type);
    }
    
    function renderFilePreview(file) {
        const fileItem = $('<div>').addClass('file-item');
        const filePreview = $('<div>').addClass('file-preview');
        const fileInfo = $('<div>').addClass('file-info');
        const fileName = $('<div>').addClass('file-name').text(file.name);
        
        const fileType = $('<div>').addClass('file-type').text(
            file.type.split('/')[1]?.toUpperCase() || 'DESCONOCIDO'
        );
        
        const fileSize = $('<div>').addClass('file-size').text(
            formatFileSize(file.size)
        );
        
        const removeBtn = $('<button>').addClass('remove-btn').html('&times;');
        removeBtn.click(function() {
            removeFile(file);
        });
        
        if (file.type.includes('image')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('<img>').attr('src', e.target.result).appendTo(filePreview);
            };
            reader.readAsDataURL(file);
        } else {
            filePreview.append($('<div>').addClass('file-icon').text('📄'));
        }
        
        fileInfo.append(fileName, fileType, fileSize);
        fileItem.append(removeBtn, filePreview, fileInfo);
        selectedFilesContainer.append(fileItem);
    }
    
    // Función auxiliar para formatear el tamaño del archivo
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    function removeFile(fileToRemove) {
        // Encontrar el índice del archivo a eliminar
        const index = selectedFiles.findIndex(file => 
            file.name === fileToRemove.name && 
            file.size === fileToRemove.size &&
            file.type === fileToRemove.type
        );
        
        if (index !== -1) {
            selectedFiles.splice(index, 1);
            selectedFilesContainer.empty();
            selectedFiles.forEach(file => renderFilePreview(file));
            updateUI();
        }
    }
    
    // Limpiar todos los archivos
    function clearAllFiles() {
        selectedFiles = [];
        selectedFilesContainer.empty();
        fileInput.val(''); // Limpiar el input file
        updateUI();
    }
    
    clearBtn.click(clearAllFiles);
    
    // Función para OBTENER los archivos seleccionados (para el pago)
    function getSelectedFiles() {
        return selectedFiles;
    }
    
    // Exponer funciones necesarias
    window.limpiarArchivosPago = clearAllFiles;
    window.obtenerArchivosPago = getSelectedFiles;
    
    function updateUI() {
        const hasFiles = selectedFiles.length > 0;
        previewSection.toggleClass('hidden', !hasFiles);
        processBtn.prop('disabled', !hasFiles);
        clearBtn.prop('disabled', !hasFiles);
    }
    
    function showError(message) {
        errorText.text(message);
        errorMessage.show().delay(5000).fadeOut();
    }
    
    function hideError() {
        errorMessage.hide();
    }
});