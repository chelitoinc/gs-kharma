{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
	<div class="card-body d-sm-flex justify-content-between bg bg-white rounded-pill">

		<h4 class="mb-2 mb-sm-0 pt-1">
      <a target="_blank">Inicio</a>
      <span>/</span>
      <span>Pagina principal</span>
		</h4>

	</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="box">
        <div class="box-header">
          <h3 class="box-title">Condensed Full Width Table</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <table class="table table-condensed">
            <tbody><tr>
              <th style="width: 10px">#</th>
              <th>Task</th>
              <th>Progress</th>
              <th style="width: 40px">Label</th>
            </tr>
            <tr>
              <td>1.</td>
              <td>Update software</td>
              <td>
                <div class="progress progress-xs">
                  <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                </div>
              </td>
              <td><span class="badge bg-red">55%</span></td>
            </tr>
            <tr>
              <td>2.</td>
              <td>Clean database</td>
              <td>
                <div class="progress progress-xs">
                  <div class="progress-bar progress-bar-yellow" style="width: 70%"></div>
                </div>
              </td>
              <td><span class="badge bg-yellow">70%</span></td>
            </tr>
            <tr>
              <td>3.</td>
              <td>Cron job running</td>
              <td>
                <div class="progress progress-xs progress-striped active">
                  <div class="progress-bar progress-bar-primary" style="width: 30%"></div>
                </div>
              </td>
              <td><span class="badge bg-light-blue">30%</span></td>
            </tr>
            <tr>
              <td>4.</td>
              <td>Fix and squish bugs</td>
              <td>
                <div class="progress progress-xs progress-striped active">
                  <div class="progress-bar progress-bar-success" style="width: 90%"></div>
                </div>
              </td>
              <td><span class="badge bg-green">90%</span></td>
            </tr>
          </tbody></table>
        </div>
        <!-- /.box-body -->
      </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem, iure, molestias. Deleniti, totam, saepe. Harum, quis deserunt dolores reiciendis ab dolorum non rerum, accusantium, nesciunt laborum illo esse hic quaerat!
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop