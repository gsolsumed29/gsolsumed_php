// Inicializar Feather Icons
feather.replace();

// Variable global para almacenar los datos del CSV
let csvData = [];

 $(document).ready(function() {
    const uploadArea = $('#uploadArea');
    const fileInput = $('#formFile');
    const fileInfo = $('#fileInfo');
    const uploadStep = $('#uploadStep');
    const previewStep = $('#previewStep');
    const resultsStep = $('#resultsStep'); // Nuevo selector
    const modalFooter = $('#modalFooter');

    // Click en el área para abrir el selector de archivos
    uploadArea.on('click', () => fileInput.click());

    // Manejar la selección de archivos
    fileInput.on('change', function() {
        const files = this.files;
        if (files.length > 0) {
            processFile(files[0]);
        }
    });

    // Manejar drag and drop
    uploadArea.on('dragover', (e) => {
        e.preventDefault();
        uploadArea.addClass('dragover');
    });

    uploadArea.on('dragleave', () => {
        uploadArea.removeClass('dragover');
    });

    uploadArea.on('drop', (e) => {
        e.preventDefault();
        uploadArea.removeClass('dragover');
        const files = e.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            fileInput[0].files = files;
            processFile(files[0]);
        }
    });

    function processFile(file) {
        if (file.type !== 'text/csv' && !file.name.endsWith('.csv')) {
            alert('Por favor, selecciona un archivo CSV válido.');
            resetUploadArea();
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const text = e.target.result;
            parseCSVAndDisplay(text);
        };
        reader.onerror = function() {
            alert('Error al leer el archivo.');
        };
        reader.readAsText(file);
    }

    function parseCSVAndDisplay(text) {
        // CAMBIO CLAVE: Usamos split('\n') para las filas y split(';') para las columnas
        const rows = text.split('\n').filter(row => row.trim() !== '');
        const headers = rows[0].split(';').map(h => h.trim()); // <-- CAMBIO AQUÍ
        csvData = [];

        for (let i = 1; i < rows.length; i++) {
            const rowData = rows[i].split(';').map(d => d.trim()); // <-- Y AQUÍ
            if (rowData.length === headers.length) {
                let rowObject = {};
                headers.forEach((header, index) => {
                    rowObject[header] = rowData[index];
                });
                csvData.push(rowObject);
            }
        }

        console.log("Datos parseados correctamente:", csvData);
        displayPreviewTable(headers, csvData);
        showPreviewState();
    }

    function displayPreviewTable(headers, data) {
        let tableHTML = '<thead class="table-dark"><tr>';
        headers.forEach(header => {
            tableHTML += `<th>${header}</th>`;
        });
        tableHTML += '</tr></thead><tbody>';

        data.forEach(row => {
            tableHTML += '<tr>';
            headers.forEach(header => {
                tableHTML += `<td>${row[header] || ''}</td>`;
            });
            tableHTML += '</tr>';
        });

        tableHTML += '</tbody>';
        $('#previewTable').html(tableHTML);
    }

    function showPreviewState() {
        uploadStep.hide();
        previewStep.hide(); // Ocultar por si acaso
        resultsStep.hide();  // Ocultar por si acaso
        previewStep.show();

        // Actualizar botones del footer
        modalFooter.html(`
            <button type="button" class="btn btn-light" id="backButton">
                <i data-feather="arrow-left" style="width: 18px; height: 18px;"></i>
                <span class="ms-50">Cambiar Archivo</span>
            </button>
            <button type="button" class="btn btn-success" id="confirmProcessBtn">
                <i data-feather="check" style="width: 18px; height: 18px;"></i>
                <span class="ms-50">Confirmar y Procesar</span>
            </button>
        `);
        feather.replace(); // Volver a renderizar iconos

        // Asignar eventos a los nuevos botones
        $('#backButton').on('click', resetToUploadState);
        $('#confirmProcessBtn').on('click', confirmAndProcess);
    }

    function resetToUploadState() {
        uploadStep.show();
        previewStep.hide();
        resultsStep.hide(); // Asegurarse de ocultar la vista de resultados
        resetUploadArea();
        updateFooterToInitialState();
    }

    function resetUploadArea() {
        fileInput.val('');
        fileInfo.html('');
        uploadArea.removeClass('has-file');
        csvData = [];
    }

    function updateFooterToInitialState() {
        modalFooter.html(`
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button id="processBatchBtn" class="btn btn-primary" disabled>
                <span class="me-50">Procesar Lote</span>
                <i data-feather="chevron-right" style="width: 18px; height: 18px;"></i>
            </button>
        `);
        feather.replace();
    }

    function confirmAndProcess() {
        const confirmBtn = $('#confirmProcessBtn');
        const originalContent = confirmBtn.html();
        confirmBtn.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span class="ms-50">Procesando...</span>
        `);

        // Realizar la llamada AJAX con fetch
        fetch('../admin/index.php?action=articulos&tipo=1&accion=10&c=ArticuloData&a=10&t=art', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(csvData) // Enviamos el array de objetos como JSON
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error en el servidor: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Respuesta del servidor:', data);

            // --- INICIO DE LOS CAMBIOS ---
            // Ocultar vista previa y mostrar la de resultados
            previewStep.hide();
            resultsStep.show();

            // 1. Mostrar el resumen general
            const summaryClass = data.success ? 'alert-success' : 'alert-warning';
            const summaryIcon = data.success ? 'check-circle' : 'alert-triangle';
            $('#processSummary').html(`
                <div class="alert ${summaryClass}" role="alert">
                    <i data-feather="${summaryIcon}"></i>
                    ${data.message}
                </div>
            `);

            // 2. Filtrar y mostrar los errores
            const failedItems = data.results.filter(result => !result.success);
            const errorDetailsContainer = $('#errorDetails');

            if (failedItems.length > 0) {
                let errorTableHTML = `
                    <h5>Artículos con Errores (${failedItems.length}):</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="table-danger">
                                <tr>
                                    <th>Fila</th>
                                    <th>Código Artículo-Prov.</th>
                                    <th>Motivo del Error</th>
                                </tr>
                            </thead>
                            <tbody>
                `;
                failedItems.forEach(item => {
                    errorTableHTML += `
                        <tr>
                            <td>${item.row_number}</td>
                            <td>${item.data.co_art_prov || 'N/A'}</td>
                            <td>${item.message}</td>
                        </tr>
                    `;
                });

                errorTableHTML += `
                            </tbody>
                        </table>
                    </div>
                `;
                errorDetailsContainer.html(errorTableHTML);
            } else {
                errorDetailsContainer.html('<p class="text-success">¡Todos los artículos se procesaron sin errores!</p>');
            }

            // 3. Actualizar el footer para cerrar el modal
            modalFooter.html(`
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
            `);
            // --- FIN DE LOS CAMBIOS ---

            feather.replace(); // Volver a renderizar iconos

            // Recargar los datos de la tabla principal para ver los cambios
            cargarDataPreciosComparacion('NO','NO');
        })
        .catch(error => {
            console.error('Error en la llamada AJAX:', error);
            // Mostrar un mensaje de error genérico en el modal
            previewStep.hide();
            resultsStep.show();
            $('#processSummary').html(`
                <div class="alert alert-danger" role="alert">
                    <i data-feather="alert-circle"></i>
                    Error de comunicación con el servidor.
                </div>
            `);
            $('#errorDetails').empty(); // Limpiar detalles de error
            modalFooter.html(`
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            `);
            feather.replace();
        })
        .finally(() => {
            // Restaurar el botón no es necesario ya que cambiamos toda la vista
        });
    }

    // Resetear el modal al cerrarlo completamente
    $('#modalAddPreciosLotes').on('hidden.bs.modal', function () {
        resetToUploadState();
    });
});