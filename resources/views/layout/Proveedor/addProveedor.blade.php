@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content_header')
	<div class="card-body d-sm-flex justify-content-between bg bg-white rounded-pill">

		<h4 class="mb-2 mb-sm-0 pt-1">
			<a href="https://mdbootstrap.com/docs/jquery/" target="_blank">Inicio</a>
			<span>/</span>
            <span>Agregar Proveedor</span>
		</h4>

	</div>
@stop
@section('content')
<div class="row">
    <div class="col-md-9 mb-4 mx-auto">
        <section>
            <form method="POST" class="text-center border border-light p-5" enctype="multipart/form-data" id="formularioInsert">
                @csrf
                <p class="h4 mb-4">AGREGAR UN PROVEEDOR</p>
                <hr class="md-5">
                <span id="form_result"></span>
                <div class="form-row">
                    <div class="col-4">
                        <input class="form-control mb-4" name="nombre" placeholder="Proveedor" type="text">
                    </div>
                    <div class="col-4">
                        <input class="form-control mb-4" name="sector" placeholder="Sector comercial" type="text">
                    </div>
                    <div class="col-4">
                        <input class="form-control mb-4" name="email" placeholder="Correo electronico" type="email">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-9">
                        <input class="form-control mb-4" name="domicilio" placeholder="Domicilio completo" type="text">
                    </div>
                    <div class="col-3">
                        <input class="form-control mb-4" name="telefono" placeholder="Telefono comercial" type="text">
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
	
    $(document).ready(function(){
        
        $('#formularioInsert').on('submit', function(event){
            event.preventDefault();

            $('#add_button').hide()
            $('#datos').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Espere...').addClass('disabled');

            
            if($('#add_button').val() == "Agregar"){
                $.ajax({
                    url: "{{route('proveedor.store')}}",
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