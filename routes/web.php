<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// Rutas

/* Usuarios o empleados */
Route::resource('tabla','UserController');
Route::post('employer','UserController@store')->name('employer.store');
Route::post('employer/update', 'UserController@update')->name('employer.update');
Route::get('employer/edit/{id}', 'UserController@edit');
Route::get('employer/destroy/{id}', 'UserController@destroy');
// Rutas a usuarios y empleados
Route::get('employer','RutesController@employer');
Route::get('administrar','RutesController@administrar');

/* Empresa */
Route::get('setting','RutesController@empresa');
Route::get('setting','CompanyController@index');
Route::post('store','CompanyController@store')->name('store.store');

// Categoria
Route::resource('tablaCategoria','CategoriaController');
Route::post('categoria','CategoriaController@store')->name('categoria.store');
Route::post('categoria/update', 'CategoriaController@update')->name('categoria.update');
Route::get('categoria/edit/{id}', 'CategoriaController@edit');
Route::get('categoria/destroy/{id}', 'CategoriaController@destroy'); 
// Rutas a categoria 
Route::get('categoria','RutesController@addCategoria');

// Proveedor
Route::resource('tablaProveedor','ProveedorController');
Route::post('proveedor','ProveedorController@store')->name('proveedor.store');
Route::post('proveedor/update', 'ProveedorController@update')->name('proveedor.update');
Route::get('proveedor/edit/{id}', 'ProveedorController@edit');
Route::get('proveedor/destroy/{id}', 'ProveedorController@destroy');

Route::get('proveedor','RutesController@addProveedor');
Route::get('adminProveedor','RutesController@adminProveedor');

// Producto
Route::resource('tablaProducto','ProductoController');
Route::post('producto','ProductoController@store')->name('producto.store');
Route::post('producto/update', 'ProductoController@update')->name('producto.update');
Route::get('producto/edit/{id}', 'ProductoController@edit');
Route::get('producto/destroy/{id}', 'ProductoController@destroy');

Route::get('agregar','RutesController@addProducto');
Route::get('adminProducto','RutesController@adminProducto');

// Pedido
Route::resource('tablaPedido','PedidoController');
Route::post('pedido','PedidoController@store')->name('pedido.store');
// Route::post('pedido/update', 'PedidoController@update')->name('producto.update');
// Route::get('pedido/edit/{id}', 'PedidoController@edit');
// Route::get('pedido/destroy/{id}', 'PedidoController@destroy');

Route::get('pedido','RutesController@addPedido');
Route::get('adminPedido','RutesController@adminPedido');


Route::get('profile','RutesController@profile');
Route::get('administrar','RutesController@administrar');
Route::get('factura','RutesController@generateFactura');