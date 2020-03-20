<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use Validator;

class CompanyController extends Controller
{
    // Modo restringido, acceso unicamente a los usuarios registrados mediante el middleware
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        // Llenar los campos de la tabla empresa
        $infos = Empresa::all();
        return view('layout.SettingEmpresa.setting',[
            'infos' => $infos
        ]);
        
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
        //Almacenar datos de la compañia

        $user = \Auth::user();
        $id = $user->id;

        // Validando
        $reglas = array(
            'nombre'        => 'required|string|max:50', 
            'director'      => 'required|string|max:120',  
            'domicilio'     => 'required|string|max:200',
            'estado'        => 'required|string|max:50',
            'pais'          => 'required|string|max:50',
            'cp'            => 'required|integer',
            'giro'          => 'required|string|max:200',
            'telefono'      => 'required|integer',
            'email'         => 'required|string|email|max:255'
        );
        
        // Reciviendo el formato file
        $image = $request->file('logo');
        $nombre = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $nombre);

        // Comprobar si las validaciones cumplen con las validaciones
        $error = Validator::make($request->all(), $reglas);

        // En caso de error lanzar un alert de los campos con error de validacion
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        //return response()->json(['success' => 'Identificación creada con exito'] );
        $form_data = array(
            'nombre'     => $request->nombre, 
            'director'   => $request->director,  
            'domicilio'  => $request->domicilio,
            'estado'     => $request->estado,
            'pais'       => $request->pais,
            'cp'         => $request->cp,
            'giro'       => $request->giro,
            'telefono'   => $request->telefono,
            'email'      => $request->email,
            'logo'       => $nombre,
            'user_id'    => $id
        );

        Empresa::create($form_data);
        return response()->json(['success' => 'Datos almacenados correctamente'] );

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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
