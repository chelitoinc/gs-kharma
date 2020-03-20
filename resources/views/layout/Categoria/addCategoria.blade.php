@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content_header')
	<div class="card-body d-sm-flex justify-content-between bg bg-white rounded-pill">

		<h4 class="mb-2 mb-sm-0 pt-1">
			<a href="https://mdbootstrap.com/docs/jquery/" target="_blank">Inicio</a>
			<span>/</span>
            <span>Agregar Categoria</span>
		</h4>

	</div>
@stop
@section('content')
<style>
    th, td{
        text-align: center;
    }
</style>
<div class="row">
    <div class="col-md-5 mb-4 mx-auto">
        <section>
            <span id="form_result"></span>
            <form method="POST" class="text-center border border-light p-5" enctype="multipart/form-data" id="formularioInsert">
                @csrf
                <p class="h4 mb-4">AGREGAR UNA CATEGORIA</p>
                <hr class="md-4">
                <div class="form-row">
                    <div class="col-12">
                        <input class="form-control mb-4" name="nombre" placeholder="Nombre de la categoria" type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <hr class="md-2">
                        <input class="btn btn-block btn-primary btn-lg" id="add_button" type="submit" value="Guardar">
                    <div id="datos"></div>
                    </div>
                </div>
            </form>
        </section>
    </div>
    <div class="col-md-6 mb-4 mx-auto">
        <section>
            <div class="box-body table-responsive ">
                <table id="table_categoria" class="table table-striped table-bordered" style="width:100%">
                    <thead >
                        <tr role="row">
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Administrar</th>
                        </tr>
                    </thead>
                </table>
              </div>
        </section>
    </div>
</div>

<!-- Modal Seguridad-->
<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg bg-red">
                <h4 class="modal-titlee">Confirmar</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Estas seguro de eliminarlo?</h4>
            </div>
            <div class="modal-footer">
             <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Fin -->

<!-- Formulario Modal -->
<div id="editCategoria" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg bg-cyan">
                <h5 class="modal-title h4" id="myLargeModalLabel">Actualizar categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
            </div>
            <form method="POST" class="text-center border border-light p-5" enctype="multipart/form-data" id="formularioUpdate">
                @csrf
                <div class="form-row">
                    <span id="form_resultModal"></span>
                    <div class="col-12">
                        <input class="form-control mb-4" id="nombre" name="nombre" placeholder="Nombre" type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <hr class="md-2">
                        <input type="hidden" name="action" id="action" />
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="submit" name="update_button" id="update_button" class="btn btn-warning" value="Actualizar" />
                    <div id="datosModal"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal -->

<script>
    $(document).ready(function(){

        // Llenar datatable
        $('#table_categoria').DataTable({
            "processing": true,
            "serverSide": true,
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
            "ajax": "{{ route('tablaCategoria.index') }}",
            "columns":[
                { "data": "id" },
                { "data": "nombre" },
                { "data": "action" }
            ]
        });
        // fin

        // Insertar
        $('#formularioInsert').on('submit', function(event){
            event.preventDefault();

            $('#add_button').hide()
            $('#datos').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Espere...').addClass('disabled');

            if($('#add_button').val() == "Guardar"){
                $.ajax({
                    url: "{{route('categoria.store')}}",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success:function(data){
                        var hmlt= '';
                        if(data.errors){
                            sleep(2000)
                            html = '<div class="alert alert-danger alert-dismissible">';
                            html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';

                            for(var count = 0; count < data.errors.length; count++){
                                html += '<p>Compuene el campo nombre categoria</p>';
                            }
                            html += '</div>';
                            $('#datos').hide();
                            $('#add_button').show()
                        }
                        if(data.success){

                            html = '<div class="alert alert-success alert-dismissible">' + data.success;
                            html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                            $('#formularioInsert')[0].reset();
                            $('#table_categoria').DataTable().ajax.reload();
                            $('#datos').hide();
                            $('#add_button').show()

                        }
                        $('#form_result').html(html);
                    }
                });
            }

        });
        $('#formularioUpdate').on('submit', function(event){
            event.preventDefault();
            
            $('#update_button').hide();
            $('#datosModal').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Espere...').addClass('disabled');

            if($('#update_button').val() == "Actualizar"){
                $.ajax({
                    url: "{{route('categoria.update')}}",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success:function(data){
                        var hmlt= '';
                        if(data.errors){
                            sleep(2000)
                            html = '<div class="alert alert-danger alert-dismissible">';
                            html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                            for(var count = 0; count < data.errors.length; count++){
                                html += '<p>Comprueba el campo nombre categoria</p>';
                            }
                            html += '</div>';
                            $('#add_button').show()
                        }
                        if(data.success){
                            sleep(2000)
                            html = '<div class="alert alert-success alert-dismissible">' + data.success;
                            html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                            $('#table_categoria').DataTable().ajax.reload();
                        }
                        $('#datosModal').hide()
                        $('#update_button').show()
                        $('#form_resultModal').html(html);
                        
                    }
                });
            }

        })
        // Fin

        /* Edit  */
        $(document).on('click', '.edit', function(){
            
            var id = $(this).attr('id');
            $('#form_result').html('');
            $.ajax({
                url:"/tablaCategoria/"+id+"/edit",
                dataType:"json",
                success:function(html){
                    $('#nombre').val(html.data.nombre);
                    $('#hidden_id').val(html.data.id);
                    $('#action_button').val("Modificar");
                    $('#editCategoria').modal('show');
                }
            });
            
        });/* Fin Script */

        /* Eliminar */
        var user_id;

        $(document).on('click', '.delete', function(){
            user_id = $(this).attr('id');
            $('#confirmModal').modal('show');
        });

        $('#ok_button').click(function(){
            $.ajax({
                url:"categoria/destroy/"+user_id,
                beforeSend:function(){
                    $('#ok_button').text('Eliminando...');
                },
                success:function(data){
                        setTimeout(function(){
                            $('#table_categoria').DataTable().ajax.reload();
                            $('#ok_button').text('OK');
                            $('#confirmModal').modal('hide');
                        }, 2000);
                    
                }
            })
        }); /* End script */

        //FUNCIÓN SLEEP
        function sleep(milisegundos) {
            var comienzo = new Date().getTime();
            while (true) {
                if ((new Date().getTime() - comienzo) > milisegundos)
            break;
            }
        }

    });
</script>

@stop