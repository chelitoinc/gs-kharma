@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content_header')
	<div class="card-body d-sm-flex justify-content-between bg bg-white rounded-pill">

		<h4 class="mb-2 mb-sm-0 pt-1">
			<a href="https://mdbootstrap.com/docs/jquery/" target="_blank">Inicio</a>
			<span>/</span>
            <span>Agregar Pedido</span>
		</h4>

	</div>
@stop
@section('content')
<div class="row">
    <div class="col-md-9 mb-4 mx-auto">
        <section>
            <form method="POST" id="formularioInsert" class="text-center border border-light p-5" enctype="multipart/form-data" >
                @csrf
                <p class="h4 mb-4">AGREGAR UN PEDIDO</p>
                <hr class="md-5">
                <span id="form_result"></span>
                <div class="form-row">
                    <div class="col-6">
                        <input class="form-control mb-3" type="text" id="nombre" name="nombre" placeholder="Nombre del pedido">
                    </div>
                    <div class="col-6">
                        <select name="proveedor" id="proveedor" class="form-control mb-4">
                            <option value="selected" active>Seleccione un proveedor</option>
                            @foreach ($proveedores as $proveedor )
                            <option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form row">
                    <div class="col-12">
                        <table id="tabla" class="table table-bordered table-hover dataTable">
                            <thead>
                                <tr class="bg bg-success">
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th><input type="button" id="add" value="Añadir fila" class="btn btn-primary"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="producto_id[]" id="producto_id" class="form-control" >
                                            <option focus> Seleccione una producto</option>
                                            @foreach ($productos as $producto )
                                            <option value="{{$producto->nombre}}">{{$producto->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </td> 
                                    <td><input type='text' name='cantidad[]' id="cantidad"  class="form-control"></td> 
                                    <td><input type='button' class='del btn btn-danger' value='Eliminar Fila' ></td>
                                </tr>
                            </tbody>
                    </table>
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
</div>

<script>
        $(document).ready(function(){
		
		//  Funcion para añadir una nueva fila en la tabla
        $("#add").click(function(){
			var nuevaFila="<tr> \
				<td><select name='producto_id[]' id='producto_id' required class='form-control'><option>Selecciona un producto</option>@foreach ($productos as $producto ) <option value='{{$producto->nombre}}'>{{$producto->nombre}}</option> @endforeach</select></td> \
				<td><input type='text' name='cantidad[]' required class='form-control'></td> \
				<td><input type='button' class='del btn btn-danger' value='Eliminar Fila' class='btn btn-danger'></td> \
			</tr>";
			$("#tabla tbody").append(nuevaFila);
		});
 
		// evento para eliminar la fila
		$("#tabla").on("click", ".del", function(){
			$(this).parents("tr").remove();
        });

        /* ------------------------------------------------------- */
        $('#formularioInsert').on('submit', function(event){
            event.preventDefault();

            $('#add_button').hide()
            $('#datos').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Espere...').addClass('disabled');

            if($('#add_button').val() == "Guardar"){
                $.ajax({
                    url: "{{route('pedido.store')}}",
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
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                            $('#datos').hide()
                            $('#add_button').show()
                        }
                        if(data.success){
                            sleep(2000)
                            html = '<div class="alert alert-success alert-dismissible">' + data.success;
                            html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                            $('#formularioInsert')[0].reset();
                            $('#datos').hide()
                            $('#add_button').show()
                        }
                        $('#form_result').html(html);
                    }
                });
            }
        });

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