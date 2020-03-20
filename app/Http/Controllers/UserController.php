<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado;
use App\User;
use Validator;

class UserController extends Controller
{

    // Modo restringido, acceso unicamente a los usuarios registrados mediante el middleware
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(User::latest()->get())
                ->addColumn('action', function ($data) {
                    $button = '<a style="cursor:pointer" name="edit" id="' . $data->id . '" class="edit btn btn-info"><i class="fa fa-edit"></i></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a style="cursor:pointer" name="delete" id="' . $data->id . '" class="delete btn btn-danger"><i class="fa fa-trash"></i></a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('layout.Employer.administrar'); 
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        // Funcion para almacenar la información
        $user = \Auth::user();
        $id = $user->id;

        $reglas =  array(
            'name'      => 'required|string|max:50',
            'apellidos' => 'required|string|max:200',
            'domicilio' => 'required|string|max:255',
            'cp'        => 'required|integer',
            'ine'       => 'required|string|max:28',
            'telefono'  => 'required|string|max:10',
            'email'     => 'required|string|email|max:255',
            'password'  => 'required|string|min:5'
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
        
        $form_data = array(
            'name'       => $request->name, 
            'apellidos'  => $request->apellidos,  
            'domicilio'  => $request->domicilio,
            'cp'         => $request->cp,
            'ine'        => $request->ine,
            'telefono'   => $request->telefono,
            'email'      => $request->email,
            'password'   => $request->password,
            'imagen'     => $nombre,
        );

        Empleado::create($form_data);
        return response()->json(['success' => 'Empleado agregado'] );

    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //Editar empleado
        if (request()->ajax()) {
            $data = User::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }


    public function update(Request $request)
    {

        $reglas =  array(
            'name'      => 'required|string|max:50',
            'apellidos' => 'required|string|max:200',
            'domicilio' => 'required|string|max:255',
            'cp'        => 'required|integer',
            'ine'       => 'required|string|max:28',
            'telefono'  => 'required|string|max:10',
            'email'     => 'required|string|email|max:255',
        );
        
        // Reciviendo el formato file
       /*  $image = $request->file('logo');
        $nombre = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $nombre); */

        // Comprobar si las validaciones cumplen con las validaciones
        $error = Validator::make($request->all(), $reglas);

        // En caso de error lanzar un alert de los campos con error de validacion
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $form_data = array(
            'name'       => $request->name, 
            'apellidos'  => $request->apellidos,  
            'domicilio'  => $request->domicilio,
            'cp'         => $request->cp,
            'ine'        => $request->ine,
            'telefono'   => $request->telefono,
            'email'      => $request->email,
        );

        User::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Empleado actualizado'] );
    }


    public function destroy($id)
    {
        $user = \Auth::user();
        $user_id = $user->id;

        if($id !=  $user_id){
            //Eliminar empleado
        $data = User::findOrFail($id);
        $data->delete();
        }else{
            return response()->json(['errors' => 'Empleado actualizado'] );
        }
        
    }
}
