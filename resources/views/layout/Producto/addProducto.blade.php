@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content_header')
	<div class="card-body d-sm-flex justify-content-between bg bg-white rounded-pill">

		<h4 class="mb-2 mb-sm-0 pt-1">
			<a href="https://mdbootstrap.com/docs/jquery/" target="_blank">Inicio</a>
			<span>/</span>
            <span>Agregar Producto</span>
		</h4>

	</div>
@stop
@section('content')
<div class="row">
    <div class="col-md-9 mb-4 mx-auto">
        <section>
            <span id="form_result"></span>
            <form method="POST" class="text-center border border-light p-5" enctype="multipart/form-data" id="formularioInsert">
                @csrf
                <p class="h4 mb-4">AGREGAR UN PRODUCTO</p>
                <hr class="md-5">
                <div class="form-row">
                    <div class="col-4">
                        <input class="form-control mb-4" name="nombre" placeholder="Nombre del producto" type="text">
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
                        <input class="form-control mb-4" name="fechaCompra" id="fechaCompra" type="date">
                    </div>
                </div>
                <div class="form row">
                    <div class="col-4">
                        <select name="proveedor" id="proveedor" class="form-control mb-4">
                            <option>Selecciona proveedor</option>
                            @foreach ($proveedores as $proveedor )
                                <option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">
                        <input class="form-control mb-3" id="stock" name="stock" placeholder="Unidades" type="text">
                    </div>
                    <div class="col-3">
                        <input class="form-control mb-4" id="precioC" name="precioC" placeholder="Precio de compra" type="text">
                    </div>
                    <div class="col-3">
                        <input class="form-control md-4" id="precioV" name="precioV" placeholder="Precio de venta" type="text">
                    </div>
                    <div class="col-12">
                        <textarea class="form-control" id="nota" name="descripcion" rows="1" placeholder="Descripción del producto"></textarea>
                    </div>
                </div>
                <hr>
                <style>
                    .avatar-pic {
                        width: 150px;
                    }
                </style>
                <div class="file-field">
                    <div class="file-field">
                        <div class="mb-4" id="preview">
                            <img id="imagen"  alt="preview" width="150" class="img-thumbnail avatar-pic" src="https://uybor.uz/borless/avtobor/img/user-images/user_no_photo_300x300.png">
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="btn btn-mdb-color btn-rounded float-left">
                                <p>Foto del producto (opcional)</p>
                                <input type="file" id="file" name="imagen"  />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <hr class="md-2">
                        <input class="btn btn-block btn-primary btn-lg" id="add_button" type="submit" value="Agregar">
                    <div id="datos"></div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
<script>
	
    //Previsualizacion de una imagen 
    document.getElementById('file').onchange =  function(e){
        let reader = new FileReader();
        reader.readAsDataURL(e.target.files[0]);
        let img = document.querySelector('#imagen');

        reader.onload = function(){
            let preview = document.getElementById('preview'),
            image = img;
            image.src = reader.result;
            preview.innerHTML = '';
            preview.append(image);
        }
    }
    
    $(document).ready(function(){
        $('#formularioInsert').on('submit', function(event){
            event.preventDefault();

            $('#add_button').hide()
            $('#datos').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Espere...').addClass('disabled');

            if($('#add_button').val() == "Agregar"){
                $.ajax({
                    url: "{{route('producto.store')}}",
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
                            $('#add_button').show()
                        }
                        if(data.success){
                            sleep(2000)
                            html = '<div class="alert alert-success alert-dismissible">' + data.success;
                            html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                            $('#formularioInsert')[0].reset();
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