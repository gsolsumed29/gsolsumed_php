    $(document).ready(function() {
            const fileInput = $('#file-input');
            const dropZone = $('#drop-zone');
            const selectedFilesContainer = $('#selected-files');
            const errorMessage = $('#error-message');
            const errorText = $('#error-text');
            const previewSection = $('#preview-section');
            const processBtn = $('#process-btn');
            const clearBtn = $('#clear-btn');
            
            let selectedFiles = [];
            
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
            });
            
            // Configurar eventos de arrastrar y soltar
            function setupDragAndDrop() {
                // Prevenir comportamientos por defecto
                $(document).on('dragover drop', function(e) {
                    e.preventDefault();
                });
                
                // Resaltar zona de drop cuando se arrastra sobre ella
                dropZone.on('dragover', function(e) {
                    e.preventDefault();
                    dropZone.addClass('drag-over');
                    return false;
                });
                
                // Quitar resaltado cuando ya no se está arrastrando sobre la zona
                dropZone.on('dragleave', function(e) {
                    e.preventDefault();
                    dropZone.removeClass('drag-over');
                    return false;
                });
                
                // Manejar el evento de soltar archivos
                dropZone.on('drop', function(e) {
                    e.preventDefault();
                    dropZone.removeClass('drag-over');
                    
                    const files = e.originalEvent.dataTransfer.files;
                    if (files.length > 0) {
                        handleFiles(files);
                    } else {
                        showError('Por favor, selecciona al menos un archivo válido');
                    }
                    
                    return false;
                });
            }
            
            // Validar y procesar los archivos seleccionados
            function handleFiles(files) {
                hideError();
                
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    
                    // Validar el tipo de archivo
                    if (!isValidFileType(file)) {
                        showError(`El archivo "${file.name}" no es un formato válido. Solo se permiten imágenes (JPEG, JPG, PNG, GIF) y archivos PDF.`);
                        continue;
                    }
                    
                    // Validar el tamaño del archivo (límite de 5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        showError(`El archivo "${file.name}" excede el tamaño máximo permitido de 5MB.`);
                        continue;
                    }
                    
                    // Verificar si el archivo ya fue seleccionado
                    if (selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                        showError(`El archivo "${file.name}" ya ha sido seleccionado.`);
                        continue;
                    }
                    
                    // Agregar el archivo a la lista
                    selectedFiles.push(file);
                    renderFilePreview(file);
                }
                
                // Actualizar la interfaz
                updateUI();
            }
            
            // Validar el tipo de archivo
            function isValidFileType(file) {
                const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.pdf)$/i;
                const allowedMimeTypes = [
                    'image/jpeg', 
                    'image/jpg', 
                    'image/png', 
                    'image/gif', 
                    'application/pdf'
                ];
                
                // Validar por extensión y tipo MIME
                return allowedExtensions.test(file.name) && allowedMimeTypes.includes(file.type);
            }
            
            // Mostrar vista previa del archivo
            function renderFilePreview(file) {
                const fileItem = $('<div>').addClass('file-item');
                const filePreview = $('<div>').addClass('file-preview');
                const fileInfo = $('<div>').addClass('file-info');
                const fileName = $('<div>').addClass('file-name').text(file.name);
                const fileType = $('<div>').addClass('file-type').text(file.type.split('/')[1].toUpperCase());
                const removeBtn = $('<button>').addClass('remove-btn').html('&times;');
                
                // Asignar evento para eliminar archivo
                removeBtn.click(function() {
                    removeFile(file);
                });
                
                // Crear vista previa según el tipo de archivo
                if (file.type.includes('image')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = $('<img>').attr('src', e.target.result);
                        filePreview.append(img);
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Para PDF mostrar un icono
                    filePreview.append($('<div>').addClass('file-icon').text('📄'));
                }
                
                // Ensamblar el elemento
                fileInfo.append(fileName, fileType);
                fileItem.append(removeBtn, filePreview, fileInfo);
                selectedFilesContainer.append(fileItem);
            }
            
            // Eliminar archivo de la lista
            function removeFile(fileToRemove) {
                selectedFiles = selectedFiles.filter(file => file !== fileToRemove);
                selectedFilesContainer.empty();
                
                // Volver a renderizar los archivos restantes
                selectedFiles.forEach(file => renderFilePreview(file));
                
                // Actualizar la interfaz
                updateUI();
            }
            
            // Limpiar todos los archivos
            clearBtn.click(function() {
                selectedFiles = [];
                selectedFilesContainer.empty();
                fileInput.val('');
                updateUI();
            });
            
      
            // Mostrar error
            function showError(message) {
                errorText.text(message);
                errorMessage.show();
            }
            
            // Ocultar error
            function hideError() {
                errorMessage.hide();
            }
            
            // Actualizar la interfaz
            function updateUI() {
                if (selectedFiles.length > 0) {
                    previewSection.removeClass('hidden');
                    processBtn.prop('disabled', false);
                    clearBtn.prop('disabled', false);
                } else {
                    previewSection.addClass('hidden');
                    processBtn.prop('disabled', true);
                    clearBtn.prop('disabled', true);
                }
            }
        });