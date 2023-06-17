<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehiclesModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VehiclesModelController extends Controller
{
    public function index(Request $request)
    {
        if(!Auth::user()->can('viewAny',VehiclesModel::class))
        {
            return response()->json(['error' => 'Sin autorización.', 'success' => false], 403);
        }
        $modelo = VehiclesModel::with('brand');
        $var = $modelo->get();
        $return = array('success'=>true,"data" =>$var,"total" => $modelo->count());
        return response()->json($return,200);
    }

    public function store(Request $request)
    {
        if(!Auth::user()->can('create',VehiclesModel::class))
        {
            return response()->json(['error' => 'Sin autorización.".', 'success' => false], 403);
        }
        $validator = validator::make($request->all(), [
            'name'=>'required|string|unique:vehicles_model',
            'id_vehicles_brand' => ['required', 'exists:vehicles_brand,id']
        ]);

        if($validator->fails())
        {
            return response()->json(['error' => 'Error de validación en datos ingresados','errors' => $validator->errors()->all(),'success' => false] );
        }

        $modelo = new VehiclesModel();
        $modelo->name = $request->name;
        $modelo->id_vehicles_brand = $request->id_vehicles_brand;
        $modelo->save();
        return response()->json(['data' => $modelo, 'success' => true], 200);
    }

    public function show($id)
    {
        $modelo = VehiclesModel::findOrFail($id);
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
            'name'=>['required','string',Rule::unique('vehicles_model','name')->ignore($id)],
            'id_vehicles_brand' => ['required', 'exists:vehicles_brand,id']
        ]);

        if($validator->fails())
        {
            return response()->json(['error' => 'Error de validación en datos ingresados','errors' => $validator->errors()->all(),'success' => false]);
        }

        $modelo = VehiclesModel::find($id);
        if(!Auth::user()->can('update',$modelo))
        {
            return response()->json(['error' => 'Sin autorización.', 'success' => false],403);
        }

        $modelo->name = $request->name;
        $modelo->id_vehicles_brand = $request->id_vehicles_brand;
        $modelo->save();
        return response()->json(['data' => $modelo, 'success' => true], 200);
    }

    public function destroy($id)
    {
        $modelo = VehiclesModel::findOrFail($id);
        if(!Auth::user()->can('delete',$modelo))
        {
            return response()->json(['error' => 'Sin autorización.', 'success' => false], 403);
        }
        $modelo->delete();
        return response()->json([ 'success' => true], 200);
    }
}
