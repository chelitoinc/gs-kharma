@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content_header')
	<div class="card-body d-sm-flex justify-content-between bg bg-white rounded-pill">

		<h4 class="mb-2 mb-sm-0 pt-1">
			<a href="https://mdbootstrap.com/docs/jquery/" target="_blank">Inicio</a>
			<span>/</span>
            <span>Administrar Productos</span>
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
    <div class="col-md-11 mb-4 mx-auto">
        <section>
            <div class="box-body table-responsive ">
                <table id="table_producto" class="table table-striped table-bordered" style="width:100%">
                    <thead >
                        <tr role="row">
                            <th>Nombre</th>
                            <th>Precio de compra</th>
                            <th>Precio de venta</th>
                            <th>Stock</th>
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
<div id="editProducto" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg bg-cyan">
                <h5 class="modal-title h4" id="myLargeModalLabel">Actualizar proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formularioUpdate" method="POST" class="text-center border border-light p-5" enctype="multipart/form-data" >
                @csrf
                <span id="form_result"></span>
                <div class="form-row">
                    <div class="col-4">
                        <input class="form-control mb-4" id="nombre" name="nombre" placeholder="Nombre del producto" type="text">
                    </div>
                    <div class="col-4">
                        <select name="categoria" id="categoria" class="form-control mb-4">
                            <option >Selecciona categoria</option>
                            @foreach ($categorias as $categoria )
                                <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        <select name="proveedor" id="proveedor" class="form-control mb-4">
                            <option>Selecciona proveedor</option>
                            @foreach ($proveedores as $proveedor )
                                <option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form row">
                    <div class="col-4">
                        <input class="form-control mb-3" id="stock" name="stock" placeholder="Unidades" type="text">
                    </div>
                    <div class="col-4">
                        <input class="form-control mb-4" id="precioC" name="precioC" placeholder="Precio de compra" type="text">
                    </div>
                    <div class="col-4">
                        <input class="form-control md-4" id="precioV" name="precioV" placeholder="Precio de venta" type="text">
                    </div>
                    <div class="col-12">
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="1" placeholder="Descripción del producto"></textarea>
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
<!-- Modal  -->

<script>
    $(document).ready(function(){
         // Llenar datatable
         $('#table_producto').DataTable({
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
            "ajax": "{{ route('tablaProducto.index') }}",
            "columns":[
                { "data": "nombre" },
                { "data": "precioC" },
                { "data": "precioV" },
                { "data": "stock" },
                { "data": "action" }
            ]
        });
        // fin

        /* Edit  */
        $(document).on('click', '.edit', function(){
            
            var id = $(this).attr('id');
            $('#form_result').html('');
            $.ajax({
                url:"/tablaProducto/"+id+"/edit",
                dataType:"json",
                success:function(html){
                    $('#nombre').val(html.data.nombre);
                    $('#categoria').val(html.data.categoria_id);
                    $('#proveedor').val(html.data.proveedor_id);
                    $('#stock').val(html.data.stock);
                    $('#precioC').val(html.data.precioC);
                    $('#precioV').val(html.data.precioV);
                    $('#descripcion').val(html.data.descripcion);
                    $('#hidden_id').val(html.data.id);
                    $('#action_button').val("Modificar");
                    $('#editProducto').modal('show');
                }
            });
            
        });/* Fin Script */

        $('#formularioUpdate').on('submit', function(event){
            event.preventDefault();
            
            $('#update_button').hide();
            $('#datos').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Espere...').addClass('disabled');

            if($('#update_button').val() == "Actualizar"){
                $.ajax({
                    url: "{{route('producto.update')}}",
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
                                html += '<p>Comprueba los campos</p>';
                            }
                            html += '</div>';
                            $('#update_button').show()
                        }
                        if(data.success){
                            sleep(2000)
                            html = '<div class="alert alert-success alert-dismissible">' + data.success;
                            html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                            $('#table_producto').DataTable().ajax.reload();
                        }
                        $('#datos').hide()
                        $('#update_button').show()
                        $('#form_result').html(html);
                        
                    }
                });
            }

        })

        /* Eliminar */
        var user_id;

        $(document).on('click', '.delete', function(){
            user_id = $(this).attr('id');
            $('#confirmModal').modal('show');
        });

        $('#ok_button').click(function(){
            $.ajax({
                url:"producto/destroy/"+user_id,
                beforeSend:function(){
                    $('#ok_button').text('Eliminando...');
                },
                success:function(data){
                        setTimeout(function(){
                            $('#table_producto').DataTable().ajax.reload();
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