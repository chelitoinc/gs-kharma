@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content_header')
	<div class="card-body d-sm-flex justify-content-between bg bg-white rounded-pill">

		<h4 class="mb-2 mb-sm-0 pt-1">
			<a href="https://mdbootstrap.com/docs/jquery/" target="_blank">Inicio</a>
			<span>/</span>
            <span>Administrar Empleados</span>
		</h4>

	</div>
@stop
@section('content')

<style>
    th, td{
        text-align: center;
    }
    thead{
        width: 100%    
    }
</style>

<div class="row">
    <div class="col-md-11 mb-4 mx-auto">
        <section>
            <hr>
            <table id="table_user" class="table table-striped table-bordered" style="width:100%">
                <thead >
                    <tr role="row">
                        {{-- <th style="width: 25%">Foto</th> --}}
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th>Telefono</th>
                        <th>Acción</th> 
                    </tr>
                </thead>
            </table>
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
<div id="editUser" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg bg-cyan">
                <h5 class="modal-title h4" id="myLargeModalLabel">Modificar empleado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
            </div>
            <form method="POST" class="text-center border border-light p-5" enctype="multipart/form-data" id="formularioInsert">
                @csrf
                <div class="form-row">
                    <span id="form_result"></span>
                    <div class="col-4">
                        <input class="form-control mb-4" id="name" name="name" placeholder="Nombre" type="text">
                    </div>
                    <div class="col-8">
                        <input class="form-control mb-4" id="apellidos" name="apellidos" placeholder="Apellidos" type="text">
                    </div>
                </div>
                <input class="form-control mb-4" id="domicilio" name="domicilio" placeholder="Domicilio completo" type="text">
                <div class="form row">
                    <div class="col-3">
                        <input class="form-control mb-3" id="cp" name="cp" placeholder="CP" type="text">
                    </div>
                    <div class="col-5">
                        <input class="form-control mb-4" id="ine" name="ine" placeholder="DNI" type="text">
                    </div>
                    <div class="col-4">
                        <input class="form-control md-5" id="telefono" name="telefono" placeholder="Numero de telefono" type="text">
                    </div>
                    <div class="col-5">
                        <input class="form-control mb-4" id="email" name="email" placeholder="Correo electronico" type="email">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <hr class="md-2">
                        <input type="hidden" name="action" id="action" />
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="submit" name="update_button" id="update_button" class="btn btn-warning" value="Actualizar" />
                    <div id="datos"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal -->

<script>
    $(document).ready( function () {

        $('#table_user').DataTable({
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
            "ajax": "{{ route('tabla.index') }}",
            "columns":[
                { "data": "id" },
                { "data": "name" },
                { "data": "apellidos" },
                { "data": "email" },
                { "data": "telefono" },
                { "data": "action" }
            ]
        });

        /* Edit  */
        $(document).on('click', '.edit', function(){
            
            var id = $(this).attr('id');
            $('#form_result').html('');
            $.ajax({
                url:"/tabla/"+id+"/edit",
                dataType:"json",
                success:function(html){
                    $('#name').val(html.data.name);
                    $('#apellidos').val(html.data.apellidos);
                    $('#domicilio').val(html.data.domicilio);
                    $('#cp').val(html.data.cp);
                    $('#ine').val(html.data.ine);
                    $('#telefono').val(html.data.telefono);
                    $('#email').val(html.data.email);
                    $('#hidden_id').val(html.data.id);
                    $('#action_button').val("Modificar");
                    $('#editUser').modal('show');
                }
            });
        });/* Fin Script */

        $('#formularioInsert').on('submit', function(event){
            event.preventDefault();

            $('#update_button').hide()
            $('#datos').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Espere...').addClass('disabled');

            if($('#update_button').val() == "Actualizar"){
                $.ajax({
                    url: "{{route('employer.update')}}",
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
                            html += '<h4><i class="icon fa fa-ban"></i> Error!</h4>';
                            for(var count = 0; count < data.errors.length; count++){
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                            $('#add_button').show()
                        }
                        if(data.success){
                            sleep(2000)
                            html = '<div class="alert alert-success alert-dismissible">' + data.success;
                            html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                            html += '<h4><i class="icon fa fa-check"></i> Empleado actualizado correctamente</h4></div>';
                            $('#table_user').DataTable().ajax.reload();
                        }
                        $('#datos').hide()
                        $('#update_button').show()
                        $('#form_result').html(html);
                        
                    }
                });
            }

        });

        /* Eliminar */
        var user_id;

        $(document).on('click', '.delete', function(){
            user_id = $(this).attr('id');
            $('#confirmModal').modal('show');
        });

        $('#ok_button').click(function(){
            $.ajax({
                url:"employer/destroy/"+user_id,
                beforeSend:function(){
                    $('#ok_button').text('Eliminando...');
                },
                success:function(data){
                    if(data.errors){
                        setTimeout(function(){
                        alert("Error no puedes eliminarte tu mismo");
                        $('#confirmModal').modal('hide');
                        $('#ok_button').text('Eliminar');
                        },2000)
                    }
                    if(data.success){
                        setTimeout(function(){
                            $('#table_user').DataTable().ajax.reload();
                            $('#ok_button').text('OK');
                            $('#confirmModal').modal('hide');
                        }, 2000);
                    }
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

    } );
</script>
@stop




