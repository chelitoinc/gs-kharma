@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content_header')
	<div class="card-body d-sm-flex justify-content-between bg bg-white rounded-pill">

		<h4 class="mb-2 mb-sm-0 pt-1">
			<a href="https://mdbootstrap.com/docs/jquery/" target="_blank">Inicio</a>
			<span>/</span>
            <span>Configurar Perfil</span>
		</h4>

	</div>
@stop
@section('content')
<div class="row">
    <div class="col-md-9 mb-4 mx-auto">
        <section>
            @if(Auth::user())
            <form method="POST" class="text-center border border-light p-5" enctype="multipart/form-data" id="formularioInsert">
                @csrf
                <p class="h4 mb-4">CONFIGURAR PERFIL</p>
                <hr class="md-5">
                <div class="form-row">
                    <div class="col-4">
                        <input class="form-control mb-4" name="nombre" placeholder="Nombre" value="{{Auth::user()->name}}" type="text">
                    </div>
                    <div class="col-8">
                        <input class="form-control mb-4" name="apellidoP" placeholder="Apellido Paterno"  value="{{Auth::user()->apellidos}}" type="text">
                    </div>
                </div>
                <input class="form-control mb-4" name="domicilio" placeholder="Domicilio completo" value="{{Auth::user()->domicilio}}" type="text">
                <div class="form row">
                    <div class="col-2">
                        <input class="form-control mb-3" id="cp" name="cp" placeholder="CP" value="{{Auth::user()->cp}}" type="text">
                    </div>
                    <div class="col-5">
                        <input class="form-control mb-4" id="ine" name="ine" value="{{Auth::user()->ine}}" placeholder="DNI" type="text">
                    </div>
                    <div class="col-5">
                        <input class="form-control md-5" name="telefono" placeholder="Numero de telefono" value="{{Auth::user()->telefono}}" type="text">
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
                        <img id="imagen"  alt="preview" width="150" class="rounded-circle z-depth-1-half avatar-pic" src="{{asset('images/200466017.jpg')}}">
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
                        <input class="btn btn-block btn-primary btn-lg" id="add_button" type="submit" value="Guardar">
                    <div id="datos"></div>
                    </div>
                </div>
            </form>
            @endif
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

   

</script>
@stop