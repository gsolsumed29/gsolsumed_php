<!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <h4 class="page-title">Categorias</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Categorias</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                   
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Sales chart -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                        <div class="card-body">
                                <h4 class="card-title">  <button type="button" class="btn waves-effect waves-light btn-rounded btn-primary"  data-toggle="modal" data-target="#responsive-modal">Aregar Categoria</button></h4>
                              
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Categoria</th>
                                                <th>Comentario</th>
                                                <th>Estatus</th>                                               
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php                                     
                                        $categorias = CategoriaData::getAll('1');                             
					                        foreach($categorias as $categoria){
					                    ?>
                                         <tr>
                                            <td><?php echo $categoria->id;?></td>
                                            <td><?php echo $categoria->categoria;?></td>
                                            <td><?php echo $categoria->comentario;?></td>                                        
                                            <td>
                                                        <?php if($categoria->estatus=='1'):?>
                                                        <span class="badge badge-success">Activa</span>
                                            <?php endif; ?>
                                            <?php if($categoria->estatus=='2'):?>
                                                        <span class="badge badge-danger">Inactiva</span>
                                            <?php endif; ?>                                          
                                                    </td>
                                            <td style="width:60px;">                                          
                                            <a href="#" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>
                                            <a href="#" data-toggle="modal" data-target="#modal-default-services" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                                            </td>
                                            </tr><!-- modal -->

                                           <?php } 
                                           
                                           ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Id</th>
                                                <th>Categoria</th>
                                                <th>Comentario</th>
                                                <th>Estatus</th>                                               
                                                <th>Opciones</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
           
                        </div>
                    </div>
                </div>
                
            </div>
                 <!-- sample modal content -->
                 <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Agregar Categoria de Articulo</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                            <form method="post" id="frmCategoria" action="./">
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Categoria:</label>
                                                        <input type="text" class="form-control" id="categoria" name="categoria" >
                                                       
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="message-text" class="control-label">Comentario:</label>
                                                        <textarea class="form-control" id="comentario" name="comentario"></textarea>
                                                    </div>
                                              
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger waves-effect waves-light">Guardar</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.modal -->