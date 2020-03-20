<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use Validator;


class ProductoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Producto::latest()->get())
                ->addColumn('action', function ($data) {
                    $button = '<a style="cursor:pointer" name="edit" id="' . $data->id . '" class="edit btn btn-info"><i class="fa fa-edit"></i></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a style="cursor:pointer" name="delete" id="' . $data->id . '" class="delete btn btn-danger"><i class="fa fa-trash"></i></a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('layout.Producto.adminProducto');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reglas =  array(
            'nombre'       => 'required|string|max:100',
            'categoria'    => 'required|integer|min:1',
            'fechaCompra'  => 'required|string|max:255',
            'proveedor'    => 'required|integer|min:1',
            'stock'        => 'required|integer|min:1|max:255',
            'precioC'      => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'precioV'      => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'descripcion'  => 'required|string|max:255',
        );
        
        // Comprobar si las validaciones cumplen con las validaciones
        $error = Validator::make($request->all(), $reglas);

        // En caso de error lanzar un alert de los campos con error de validacion
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $form_data = array(
            'nombre'        => $request->nombre,   
            'fechaCompra'   => $request->fechaCompra,
            'stock'         => $request->stock,
            'precioC'       => $request->precioC,
            'precioV'       => $request->precioV,
            'descripcion'   => $request->descripcion,
            'imgProducto'   => "default.jpg",
            'categoria_id'  => $request->categoria,
            'proveedor_id'  => $request->proveedor
        );
        // return response()->json(['success' => 'Producto agregado'] );
        Producto::create($form_data);
        return response()->json(['success' => 'Producto agregado'] );


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Editar empleado
        if (request()->ajax()) {
            $data = Producto::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $reglas =  array(
            'nombre'       => 'required|string|max:100',
            'categoria'    => 'required|integer|min:1',
            'proveedor'    => 'required|integer|min:1',
            'stock'        => 'required|integer|min:1|max:255',
            'precioC'      => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'precioV'      => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'descripcion'  => 'required|string|max:255',
        );
        
        // Comprobar si las validaciones cumplen con las validaciones
        $error = Validator::make($request->all(), $reglas);

        // En caso de error lanzar un alert de los campos con error de validacion
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $form_data = array(
            'nombre'        => $request->nombre,   
            'stock'         => $request->stock,
            'precioC'       => $request->precioC,
            'precioV'       => $request->precioV,
            'descripcion'   => $request->descripcion,
            'categoria_id'  => $request->categoria,
            'proveedor_id'  => $request->proveedor
        );
        // return response()->json(['success' => 'Producto agregado'] );
        Producto::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Producto actualizado'] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Producto::findOrFail($id);
        $data->delete();
    }
}
