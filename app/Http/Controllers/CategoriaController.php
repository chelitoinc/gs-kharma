<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\User;
use Validator;

class CategoriaController extends Controller
{

    // Modo restringido, acceso unicamente a los usuarios registrados mediante el middleware
    public function __construct(){
        $this->middleware('auth');
    }
    public function index()
    {
        // Resource de categorias
        if (request()->ajax()) {
            return datatables()->of(Categoria::latest()->get())
                ->addColumn('action', function ($data) {
                    $button = '<a style="cursor:pointer" name="edit" id="' . $data->id . '" class="edit btn btn-info"><i class="fa fa-edit"></i></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a style="cursor:pointer" name="delete" id="' . $data->id . '" class="delete btn btn-danger"><i class="fa fa-trash"></i></a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('layout.Categoria.addCategoria');
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
        $user = \Auth::user();
        $id = $user->id;

        $reglas = array(
            'nombre' => 'required|string|max:180'
        );

        // Comprobar si las validaciones cumplen con las validaciones
        $error = Validator::make($request->all(), $reglas);

        // En caso de error lanzar un alert de los campos con error de validacion
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'nombre'  => $request->nombre,
            'user_id' => $id
        );

        Categoria::create($form_data);
        return response()->json(['success' => 'Categoria agregada'] );


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
            $data = Categoria::findOrFail($id);
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
        
        $reglas = array(
            'nombre' => 'required|string|max:180'
        );

        // Comprobar si las validaciones cumplen con las validaciones
        $error = Validator::make($request->all(), $reglas);

        // En caso de error lanzar un alert de los campos con error de validacion
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'nombre'  => $request->nombre
        );

        Categoria::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Categoria actualizada'] );
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
        $data = Categoria::findOrFail($id);
        $data->delete();
        }else{
            return response()->json(['errors' => 'Categoria actualizado'] );
        }
    }
}
