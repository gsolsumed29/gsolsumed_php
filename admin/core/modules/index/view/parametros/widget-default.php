  <!-- BEGIN: Content-->
  <div class="app-content content ">
 
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Parametros</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="index.php?view=tipos">Tipos</a>
                                    </li>
                                    <li class="breadcrumb-item active">Listado
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
              
            </div>
            <div class="content-body">
               
             
               <input type="hidden" id="dataParametros" class="dataParametros" value=''>
                <!-- Basic table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <table class="datatablesParametros table">
                                    <thead>
                                        <tr> 
                                            <th></th>                                          
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th> 
                                            <th></th>
                                            <th></th>
                                            <th></th>  
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Modal to add new record -->
                    <div class="modal modal-slide-in fade modalAddMarca" id="modalAddMarca">
                        <div class="modal-dialog sidebar-sm">
                            <form class="frmAddMarca modal-content pt-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title modalTitulo" id="exampleModalLabel">Nuevo Registro</h5>
                                </div>
                                <div class="modal-body flex-grow-1">
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-email">Para *</label>
                                            <select class="select2 form-select comboVendedoresUsuario" id="select2-basic">                                               
                                            </select>
                                    </div>     
                                      <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-email">Indicador *</label>
                                            <select class="select2 form-select comboVendedoresIndicador" id="comboVendedoresIndicador">                                               
                                            </select>
                                    </div>     
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-fullname">Valor * </label>
                                        <input type="number" class="form-control txtAddValor" name="txtAddValor" placeholder="10" id="txtAddValor" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-date">Fecha Inicio</label>
                                        <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  finicio" placeholder="Seleccione" readonly="readonly"/>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-date">Fecha Final</label>
                                        <input type="text" id="fp-range" class="form-control flatpickr-basic flatpickr-input  ffinal" placeholder="Seleccione" readonly="readonly" />
                                    </div>                            
                                  
                                    <button type="button" class="btn btn-primary btnGuardarParametroValor me-1"> <i data-feather='save'></i> Guardar</button>
                                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"> <i data-feather='x-circle'></i> Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal modal-slide-in fade modalEditMarca" id="modalEditMarca">
                        <div class="modal-dialog sidebar-sm">
                            <form class="frmEditMarca modal-content pt-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title " id="exampleModalLabel">Datos de la Marca</h5>
                                </div>
                                <div class="modal-body flex-grow-1">
                                <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-email">Para *</label>
                                        <select class="form-select cmbEditMarcaCondicion" id="cmbEditMarcaCondicion" name="cmbEditMarcaCondicion">                                           
                                          
                                            <option value= "1"> Inventario </option>	 
                                            <option value= "2"> Equipos </option>
                                                                             
                                        </select>
                                    </div>     
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-fullname">Tipo * </label>
                                        <input type="hidden" class="form-control txtEditIdMarca" name="txtEditIdMarca" id="txtEditIdMarca" />
                                        <select class="select2 form-select cmbEditMarca_idTipo" id="cmbEditMarca_idTipo" name="cmbEditMarca_idTipo" disabled='true'>                                           
                                                                                                         
                                        </select>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-email">Marca</label>
                                        <input type="text" class="form-control txtEditMarca" name="txtEditMarca" placeholder="Nombre de la Marca" id="txtEditMarca" />
                                    </div>                                   
                                  
                                    <button type="button" class="btn btn-primary btnEditMarca me-1">Editar</button>
                                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
                <!--/ Basic table -->


         

        

            </div>
        </div>
    </div>
    <!-- END: Content-->