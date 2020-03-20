<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;
use App\Categoria;
use App\Producto;

class RutesController extends Controller
{
    //Rutas
    public function empresa(){
        return view('layout.SettingEmpresa.setting');
    }
    public function profile(){
        return view('layout.User.SettingProfile');
    }
    public function employer(){
        return view('layout.Employer.AddEmployer');
    }
     public function administrar(){
        return view('layout.Employer.administrar');
    } 
    public function addProducto(){
        $proveedores = Proveedor::orderBy('id','DESC')->get();
        $categorias = Categoria::orderBy('id','DESC')->get();
        return view('layout.Producto.addProducto',[
            'proveedores' => $proveedores,
            'categorias' => $categorias
        ]);
    }
    public function adminProducto(){
        $proveedores = Proveedor::orderBy('id','DESC')->get();
        $categorias = Categoria::orderBy('id','DESC')->get();
        return view('layout.Producto.adminProducto',[
            'proveedores' => $proveedores,
            'categorias' => $categorias
        ]);
        
    }
    public function addPedido(){
        $proveedores = Proveedor::orderBy('id','DESC')->get();
        $productos = Producto::orderBy('id','DESC')->get();
        return view('layout.Pedido.addPedido', [
            'proveedores' => $proveedores,
            'productos'   => $productos
        ]);
    }
    public function adminPedido(){
        return view('layout.Pedido.adminPedido');
    }
    public function addProveedor(){
        return view('layout.Proveedor.addProveedor');
    }
    public function adminProveedor(){
        return view('layout.Proveedor.adminProveedor');
    }
    public function addcategoria(){
        return view('layout.Categoria.addCategoria');
    }
    public function generateFactura(){
        return view('layout.Factura.factura');
    } 
}
