@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content_header')
	<div class="card-body d-sm-flex justify-content-between bg bg-white rounded-pill">

		<h4 class="mb-2 mb-sm-0 pt-1">
			<a href="https://mdbootstrap.com/docs/jquery/" target="_blank">Inicio</a>
			<span>/</span>
            <span>Agregar Empleado</span>
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
                <p class="h4 mb-4">AGREGAR UN EMPLEADO</p>
                <hr class="md-5">
                <div class="form-row">
                    <div class="col-4">
                        <input class="form-control mb-4" name="name" placeholder="Nombre" type="text">
                    </div>
                    <div class="col-8">
                        <input class="form-control mb-4" name="apellidos" placeholder="Apellidos" type="text">
                    </div>
                </div>
                <input class="form-control mb-4" name="domicilio" placeholder="Domicilio completo" type="text">
                <div class="form row">
                    <div class="col-3">
                        <input class="form-control mb-4" id="estado" name="estado" placeholder="Estado" type="text">
                    </div>
                    <div class="col-2">
                        <input class="form-control mb-3" id="cp" name="cp" placeholder="CP" type="text">
                    </div>
                    <div class="col-4">
                        <input class="form-control mb-4" id="ine" name="ine" placeholder="DNI" type="text">
                    </div>
                    <div class="col-3">
                        <input class="form-control md-5" name="telefono" placeholder="Numero de telefono" type="text">
                    </div>
                    <div class="col-7">
                        <input class="form-control mb-4" name="email" placeholder="Correo electronico" type="email">
                    </div>
                    <div class="col-5">
                        <input class="form-control mb-4" id="password" name="password" placeholder="Contraseña" type="password">
                    </div>
                </div>
                <style>
                    .avatar-pic {
                        width: 150px;
                    }
                </style>
                <div class="file-field">
                    <div class="file-field">
                        <div class="mb-4" id="preview">
                            <img id="imagen"  alt="preview" width="150" class="rounded-circle z-depth-1-half avatar-pic" src="https://uybor.uz/borless/avtobor/img/user-images/user_no_photo_300x300.png">
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="btn btn-mdb-color btn-rounded float-left">
                                <span>Foto del usuario</span> 
                                <input type="file" id="file" name="logo"  required="required" />
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
                    url: "{{route('employer.store')}}",
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
                            html += '<h4><i class="icon fa fa-check"></i> Empleado agregado correctamente</h4></div>';
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