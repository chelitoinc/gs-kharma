<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pedido;
use App\Categoria;
use App\Producto;
use App\Lista;
Use App\User;
use Validator;


class PedidoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Pedido::latest()->get())
                ->addColumn('action', function ($data) {
                    $button = '<a style="cursor:pointer" name="edit" id="' . $data->id . '" class="edit btn btn-info"><i class="fa fa-edit"></i></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a style="cursor:pointer" name="delete" id="' . $data->id . '" class="delete btn btn-danger"><i class="fa fa-trash"></i></a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('layout.Pedido.adminPedido');
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

        $reglas =  array(
            'nombre'       => 'required|string|max:100',
            'proveedor'    => 'required|integer|min:1'
        );
        // Comprobar si las validaciones cumplen con las validaciones
        $error = Validator::make($request->all(), $reglas);

        // En caso de error lanzar un alert de los campos con error de validacion
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $form_data =  array(
            'nombre'        => $request->nombre,
            'user_id'       => $id,
            'proveedor_id'  => $request->proveedor
        );

        Pedido::create($form_data);
        

        if($request->producto_id){
            $listaAdd = $request->producto_id;
            foreach ($listaAdd as $key => $value) {
                $lista = new Lista();
                $lista->producto    =  $request->producto_id[$key];
                $lista->cantidad    =  $request->cantidad[$key];
                $lista->pedido_id   =  7;
                $lista->save();
            }
        }

        return response()->json(['success' => 'Pedido agregado'] );


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
