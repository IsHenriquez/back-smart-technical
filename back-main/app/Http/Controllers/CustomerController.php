<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if(!Auth::user()->can('viewAny',Customer::class))
        {
            return response()->json(['error' => 'Sin autorización.', 'success' => false], 403);
        }

        $modelo =  Customer::query()
            ->select('customer.*')
        ;
        $var = $modelo->get();
        $return = array('success'=>true,"data" =>$var,"total" => $modelo->count());
        return response()->json($return,200);
    }

    public function store(Request $request)
    {
        if(!Auth::user()->can('create',Customer::class))
        {
            return response()->json(['error' => 'Sin autorización.".', 'success' => false], 403);
        }
        $validator = validator::make($request->all(), [
            'nombre' => 'required|string',
            'apellido_paterno' => 'required|string',
            'apellido_materno' => 'string',
            'email'=>'required|email|unique:customer',
            'rut'=>'required|string'
        ]);

        if($validator->fails())
        {
            return response()->json(['error' => 'Error de validación en datos ingresados','errors' => $validator->errors()->all(),'success' => false] );
        }

        $modelo = new Customer();
        $modelo->nombre                       =   $request->nombre                                      ;
        $modelo->apellido_paterno             =   $request->apellido_paterno                            ;
        $modelo->apellido_materno             =   $request->apellido_materno                            ;
        $modelo->rut                          =   $request->rut                                         ;
        $modelo->fono_movil                   =   $request->fono_movil                                  ;
        $modelo->email = $request->email                                                                ;
        $modelo->save();
        return response()->json(['data' => $modelo, 'success' => true], 200);
    }

    public function show($id)
    {
        $modelo = Customer::findOrFail($id);
        if(!Auth::user()->can('view',$modelo))
        {
            return response()->json(['error' => 'Sin autorización.', 'success' => false], 403);
        }
        $arreglo = $modelo->toArray();
        return response()->json(['data' => $arreglo, 'success' => true], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = validator::make($request->all(), [
            'nombre' => 'required|string',
            'apellido_paterno' => 'required|string',
            'apellido_materno' => 'string',
            'rut'=>'required|string',
            'email'=>['required','email',Rule::unique('customer','email')->ignore($id)]
        ]);

        if($validator->fails())
        {
            return response()->json(['error' => 'Error de validación en datos ingresados','errors' => $validator->errors()->all(),'success' => false]);
        }

        $modelo = Customer::find($id);
        if(!Auth::user()->can('update',$modelo))
        {
            return response()->json(['error' => 'Sin autorización.', 'success' => false],403);
        }

        $modelo->nombre                       =   $request->nombre                                      ;
        $modelo->apellido_paterno             =   $request->apellido_paterno                            ;
        $modelo->apellido_materno             =   $request->apellido_materno                            ;
        $modelo->rut                          =   $request->rut                                         ;
        $modelo->fono_movil                   =   $request->fono_movil                                  ;
        $modelo->email = $request->email                                                                ;
        $modelo->save();
        return response()->json(['data' => $modelo, 'success' => true], 200);
    }

    public function destroy($id)
    {
        $modelo = Customer::findOrFail($id);
        if(!Auth::user()->can('delete',$modelo))
        {
            return response()->json(['error' => 'Sin autorización.', 'success' => false], 403);
        }
        $modelo->delete();
        return response()->json([ 'success' => true], 200);
    }
}
