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
<div class="row">
    <div class="col-md-11 mb-4 mx-auto">
        <section>
            <div class="box-body table-responsive ">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th>Status</th>
                            <th>Administrar</th>
                        </tr>
                        <tr>
                            <td>183</td>
                            <td>John Doe</td>
                            <td>11-7-2014</td>
                            <td><span class="label label-success">Approved</span></td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info">Editar</button>
                                    <button type="button" class="btn btn-danger">Eliminar</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>219</td>
                            <td>Alexander Pierce</td>
                            <td>11-7-2014</td>
                            <td><span class="label label-warning">Pending</span></td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info">Editar</button>
                                    <button type="button" class="btn btn-danger">Eliminar</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>657</td>
                            <td>Bob Doe</td>
                            <td>11-7-2014</td>
                            <td><span class="label label-primary">Approved</span></td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info">Editar</button>
                                    <button type="button" class="btn btn-danger">Eliminar</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>175</td>
                            <td>Mike Doe</td>
                            <td>11-7-2014</td>
                            <td><span class="label label-danger">Denied</span></td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info">Editar</button>
                                    <button type="button" class="btn btn-danger">Eliminar</button>
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