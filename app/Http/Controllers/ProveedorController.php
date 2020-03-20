<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;
use App\User;
use Validator;


class ProveedorController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
       if (request()->ajax()) {
            return datatables()->of(Proveedor::latest()->get())
                ->addColumn('action', function ($data) {
                    $button = '<a style="cursor:pointer" name="edit" id="' . $data->id . '" class="edit btn btn-info"><i class="fa fa-edit"></i></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a style="cursor:pointer" name="delete" id="' . $data->id . '" class="delete btn btn-danger"><i class="fa fa-trash"></i></a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('layout.Proveedor.adminProveedor'); 
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
        // return response()->json(['success' => 'Empleado agregado'] );
        $user = \Auth::user();
        $id = $user->id;

        $reglas =  array(
            'nombre'     => 'required|string|max:100',
            'sector'     => 'required|string|max:255',
            'email'      => 'required|string|max:255',
            'domicilio'  => 'required|string|max:255',
            'telefono'   => 'required|integer',
        );

        // Comprobar si las validaciones cumplen con las validaciones
        $error = Validator::make($request->all(), $reglas);

        // En caso de error lanzar un alert de los campos con error de validacion
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'nombre'    => $request->nombre, 
            'sector'    => $request->sector,  
            'email'     => $request->email,
            'domicilio' => $request->domicilio,
            'telefono'  => $request->telefono,
            'user_id'   => $id,
        );

        Proveedor::create($form_data);
        return response()->json(['success' => 'Proveedor agregado'] );

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $proveedores = Proveedor::orderBy('id','DESC')->get();
        return view('layout.Producto.addProducto',[
            'proveedores' => $proveedores
        ]);
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
            $data = Proveedor::findOrFail($id);
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
            'nombre'     => 'required|string|max:100',
            'sector'     => 'required|string|max:255',
            'email'      => 'required|string|max:255',
            'domicilio'  => 'required|string|max:255',
            'telefono'   => 'required|integer',
        );

        // Comprobar si las validaciones cumplen con las validaciones
        $error = Validator::make($request->all(), $reglas);

        // En caso de error lanzar un alert de los campos con error de validacion
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'nombre'    => $request->nombre, 
            'sector'    => $request->sector,  
            'email'     => $request->email,
            'domicilio' => $request->domicilio,
            'telefono'  => $request->telefono
        );

        Proveedor::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Proveedor actualizado'] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = \Auth::user();
        $user_id = $user->id;

        if($id !=  $user_id){
            //Eliminar empleado
        $data = Proveedor::findOrFail($id);
        $data->delete();
        }else{
            return response()->json(['errors' => 'Categoria actualizado'] );
        }
    }
}
