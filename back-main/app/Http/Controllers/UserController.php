<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if(!Auth::user()->can('viewAny',User::class))
        {
            return response()->json(['error' => 'Sin autorización.', 'success' => false], 403);
        }

        $modelo =  User::query()
            ->select('users.*')
        ;
        $var = $modelo->get();
        $return = array('success'=>true,"data" =>$var,"total" => $modelo->count());
        return response()->json($return,200);
    }

    public function store(Request $request)
    {
        if(!Auth::user()->can('create',User::class))
        {
            return response()->json(['error' => 'Sin autorización.".', 'success' => false], 403);
        }

        $validator = validator::make($request->all(), [
            'name' => 'required|string',
            'apellido_paterno' => 'required|string',
            'rut' => 'required|string',
            'email'=>'required|email|unique:users',
            'activo'=>'required|boolean',
            'tipo_usuario'=>'required',
            'password'=>'required|max:12|min:6|string'
        ]);

        if($validator->fails())
        {
            return response()->json(['error' => 'Error de validación en datos ingresados','errors' => $validator->errors()->all(),'success' => false] );
        }

        $modelo = new User();
        $modelo->activo                       =   $request->activo                                      ;
        $modelo->tipo_usuario                 =   $request->tipo_usuario                                ;
        $modelo->name                         =   $request->name                                        ;
        $modelo->apellido_paterno             =   $request->apellido_paterno                            ;
        $modelo->apellido_materno             =   $request->apellido_materno                            ;
        $modelo->rut                          =   $request->rut                                         ;
        $modelo->genero                       =   $request->genero                                      ;
        $modelo->fecha_nacimiento             =   date('Y-m-d',strtotime($request->fecha_nacimiento))   ;
        $modelo->fono_movil                   =   $request->fono_movil                                  ;
        $modelo->email = $request->email                                                                ;
        $modelo->password= app('hash')->make($request->password, ['rounds' => 12])                      ;
        $modelo->save();
        return response()->json(['data' => $modelo, 'success' => true], 200);
    }

    public function show($id)
    {
        $modelo = User::findOrFail($id);
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
            'name' => 'required|string',
            'apellido_paterno' => 'required|string',
            'rut' => 'required|string',
            'activo'=>'required|boolean',
            'tipo_usuario'=>'required',
            'email'=>['required','email',Rule::unique('users','email')->ignore($id)],
            'password'=>'max:12|min:6|string'
        ]);

        if($validator->fails())
        {
            return response()->json(['error' => 'Error de validación en datos ingresados','errors' => $validator->errors()->all(),'success' => false]);
        }

        $modelo = User::find($id);
        if(!Auth::user()->can('update',$modelo))
        {
            return response()->json(['error' => 'Sin autorización.', 'success' => false],403);
        }

        if($request->input('password'))
        {
            $modelo->password= app('hash')->make($request->input('password'), ['rounds' => 12]);
        }

        $modelo->activo                       =   $request->activo                                      ;
        $modelo->tipo_usuario                 =   $request->tipo_usuario                                ;
        $modelo->name                         =   $request->name                                        ;
        $modelo->apellido_paterno             =   $request->apellido_paterno                            ;
        $modelo->apellido_materno             =   $request->apellido_materno                            ;
        $modelo->rut                          =   $request->rut                                         ;
        $modelo->genero                       =   $request->genero                                      ;
        $modelo->fecha_nacimiento             =   date('Y-m-d',strtotime($request->fecha_nacimiento))   ;
        $modelo->fono_movil                   =   $request->fono_movil                                  ;
        $modelo->email = $request->email                                                                ;
        $modelo->password= app('hash')->make($request->password, ['rounds' => 12])                      ;
        $modelo->save();
        return response()->json(['data' => $modelo, 'success' => true], 200);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if(!Auth::user()->can('delete',$user))
        {
            return response()->json(['error' => 'Sin autorización.', 'success' => false], 403);
        }
        $user->delete();
        return response()->json([ 'success' => true], 200);
    }
}
