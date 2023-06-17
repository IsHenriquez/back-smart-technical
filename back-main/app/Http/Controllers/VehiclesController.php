<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VehiclesController extends Controller
{
    public function index(Request $request)
    {
        if(!Auth::user()->can('viewAny',Vehicles::class))
        {
            return response()->json(['error' => 'Sin autorización.', 'success' => false], 403);
        }
        $modelo = Vehicles::with('user','model');
        $var = $modelo->get();
        $return = array('success'=>true,"data" =>$var,"total" => $modelo->count());
        return response()->json($return,200);
    }

    public function store(Request $request)
    {
        if(!Auth::user()->can('create',Vehicles::class))
        {
            return response()->json(['error' => 'Sin autorización.".', 'success' => false], 403);
        }
        $validator = validator::make($request->all(), [
            'patente'=>'required|string|unique:vehicles',
            'descripcion'=>'required|string',
            'active'=>'required|boolean',
            'id_user' => ['required', 'exists:users,id'],
            'id_vehicle_model' => ['required', 'exists:vehicles_model,id']
        ]);

        if($validator->fails())
        {
            return response()->json(['error' => 'Error de validación en datos ingresados','errors' => $validator->errors()->all(),'success' => false] );
        }

        $modelo = new Vehicles();
        $modelo->patente           = $request->patente;
        $modelo->descripcion       = $request->descripcion;
        $modelo->active            = $request->active;
        $modelo->id_user           = $request->id_user;
        $modelo->id_vehicles_brand = $request->id_vehicles_brand;
        $modelo->save();
        return response()->json(['data' => $modelo, 'success' => true], 200);
    }

    public function show($id)
    {
        $modelo = Vehicles::findOrFail($id);
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
            'patente'=>['required','string',Rule::unique('vehicles','patente')->ignore($id)],
            'descripcion'=>'required|string',
            'active'=>'required|boolean',
            'id_user' => ['required', 'exists:users,id'],
            'id_vehicle_model' => ['required', 'exists:vehicles_model,id']
        ]);

        if($validator->fails())
        {
            return response()->json(['error' => 'Error de validación en datos ingresados','errors' => $validator->errors()->all(),'success' => false]);
        }

        $modelo = Vehicles::find($id);
        if(!Auth::user()->can('update',$modelo))
        {
            return response()->json(['error' => 'Sin autorización.', 'success' => false],403);
        }

        $modelo->patente           = $request->patente;
        $modelo->descripcion       = $request->descripcion;
        $modelo->active            = $request->active;
        $modelo->id_user           = $request->id_user;
        $modelo->id_vehicles_brand = $request->id_vehicles_brand;
        $modelo->save();
        return response()->json(['data' => $modelo, 'success' => true], 200);
    }

    public function destroy($id)
    {
        $modelo = Vehicles::findOrFail($id);
        if(!Auth::user()->can('delete',$modelo))
        {
            return response()->json(['error' => 'Sin autorización.', 'success' => false], 403);
        }
        $modelo->delete();
        return response()->json([ 'success' => true], 200);
    }
}
