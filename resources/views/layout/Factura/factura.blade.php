@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content_header')
	<div class="card-body d-sm-flex justify-content-between bg bg-white rounded-pill">

		<h4 class="mb-2 mb-sm-0 pt-1">
			<a href="https://mdbootstrap.com/docs/jquery/" target="_blank">Inicio</a>
			<span>/</span>
            <span>Agregar factura</span>
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
            <form method="POST" class="text-center border border-light p-5" enctype="multipart/form-data" id="formularioInsert">
                @csrf
                <p class="h4 mb-4">GENERAR FACTURA</p>
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
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Empleado</th>
                            <th>Administrar</th>
                        </tr>
                        <tr>
                            <td>183</td>
                            <td>Bebidas</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info"> <i class="fa fa-edit"></i> </button>
                                    <button type="button" class="btn btn-danger"> <i class="fa fa-trash"></i> </button>
                                    <button type="button" class="btn btn-success"> <i class="fa fa-download"></i> </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>219</td>
                            <td>Higiene</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info"> <i class="fa fa-edit"></i> </button>
                                    <button type="button" class="btn btn-danger"> <i class="fa fa-trash"></i> </button>
                                    <button type="button" class="btn btn-success"> <i class="fa fa-download"></i> </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>657</td>
                            <td>Enlatados</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info"> <i class="fa fa-edit"></i> </button>
                                    <button type="button" class="btn btn-danger"> <i class="fa fa-trash"></i> </button>
                                    <button type="button" class="btn btn-success"> <i class="fa fa-download"></i> </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>175</td>
                            <td>Bebidas alcholicas</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info"> <i class="fa fa-edit"></i> </button>
                                    <button type="button" class="btn btn-danger"> <i class="fa fa-trash"></i> </button>
                                    <button type="button" class="btn btn-success"> <i class="fa fa-download"></i> </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
              </div>
        </section>
    </div>
</div>

@stop