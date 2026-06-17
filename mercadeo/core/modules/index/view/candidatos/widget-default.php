  <!-- BEGIN: Content-->
  <div class="app-content content m_visitas_cantidatos " id="m_visitas_cantidatos">
 
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Candidatos</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="index.php?view=candidatos">Candidatos</a>
                                    </li>
                                    <li class="breadcrumb-item active">Listado
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">                 
                </div>
            </div>
            <div class="content-body">
               
                <div class="row">
                    <div class="col-12 data">
                    
                     
                        
                    </div>
                </div>
               <input type="hidden" id="dataClientesCandidatos" class="dataClientesCandidatos" value=''>

                    <!-- Advanced Search -->
                    <section id="advanced-search-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                    
                                <div class="card-datatable">
                                    <table class="dt-advanced-search datatables-basic-clientes-candidatos table">
                                    <thead>                                         
                                            <tr>
                                              <th></th> <!-- Columna de control responsive (responsive_id) -->
                                              <th>Código</th> <!-- Columna para 'dato3' -->
                                              <th>Razón social</th> <!-- Columna para 'cli_des' -->
                                              <th>Rif</th> <!-- Columna para 'rif' -->
                                              <th>Telefonos</th> <!-- Columna para 'telefonos' -->
                                              <th>Email</th> <!-- Columna para 'email' -->
                                              <th>Estado</th> <!-- Columna para 'dato2' -->
                                              <th>Responsable de compras</th> <!-- Columna para 'dato4' -->
                                              <th>Teléfono de compras</th> <!-- Columna para 'dato5' -->
                                              <th>Dirección</th> <!-- Columna para 'direc1' -->
                                              <th>Visitas</th> <!-- Columna para 'dato1' -->
                                              <th>Foto</th> <!-- Columna para 'Foto' -->
                                           
                                            </tr>
                                        </thead>
                                  
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--/ Advanced Search -->

              
        

            </div>
        </div>
    </div>
    <!-- END: Content-->



    <!-- Modal Ficha de Candidato -->
<div class="modal fade" id="modalFichaCandidato" tabindex="-1" aria-labelledby="modalFichaCandidatoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalFichaCandidatoLabel">
          <i data-feather="user"></i>
          <span id="ficha-nombre-completo">Nombre del Candidato</span>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
        <div class="col-md-6 mb-2">
            <strong>#:</strong>
            <p id="ficha-dato3" class="mb-1">-</p>
          </div>
          <div class="col-md-6 mb-2">
            <strong>RIF:</strong>
            <p id="ficha-rif" class="mb-1">-</p>
          </div>
          <div class="col-md-6 mb-2">
            <strong>Teléfonos:</strong>
            <p id="ficha-telefonos" class="mb-1">-</p>
          </div>
          <div class="col-md-6 mb-2">
            <strong>Correo Electrónico:</strong>
            <p id="ficha-email" class="mb-1">-</p>
          </div>
          <div class="col-md-6 mb-2">
            <strong>Dirección:</strong>
            <p id="ficha-direccion" class="mb-1">-</p>
          </div>
          <!-- Añade aquí el resto de los campos que quieras mostrar -->
          <div class="col-md-6 mb-2">
            <strong>Visitas:</strong>
            <p id="ficha-dato1" class="mb-1">-</p>
          </div>
          <div class="col-md-6 mb-2">
            <strong>Estado / Zona:</strong>
            <p id="ficha-dato2" class="mb-1">-</p>
          </div>
      
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <!-- Puedes añadir aquí un botón de acción, como "Ir a Ficha Completa" -->
        <a id="ficha-boton-visitar" href="#" class="btn btn-primary">Visitar Candidato</a>

      </div>
    </div>
  </div>
</div>