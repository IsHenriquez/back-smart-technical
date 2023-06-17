<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehiclesBrand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VehiclesBrandController extends Controller
{
    public function index(Request $request)
    {
        if(!Auth::user()->can('viewAny',VehiclesBrand::class))
        {
            return response()->json(['error' => 'Sin autorización.', 'success' => false], 403);
        }

        $modelo =  VehiclesBrand::query()
            ->select('vehicles_brand.*')
        ;
        $var = $modelo->get();
        $return = array('success'=>true,"data" =>$var,"total" => $modelo->count());
        return response()->json($return,200);
    }

    public function store(Request $request)
    {
        if(!Auth::user()->can('create',VehiclesBrand::class))
        {
            return response()->json(['error' => 'Sin autorización.".', 'success' => false], 403);
        }
        $validator = validator::make($request->all(), [
            'name'=>'required|string|unique:vehicles_brand',
        ]);

        if($validator->fails())
        {
            return response()->json(['error' => 'Error de validación en datos ingresados','errors' => $validator->errors()->all(),'success' => false] );
        }

        $modelo = new VehiclesBrand();
        $modelo->name = $request->name;
        $modelo->save();
        return response()->json(['data' => $modelo, 'success' => true], 200);
    }

    public function show($id)
    {
        $modelo = VehiclesBrand::findOrFail($id);
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
            'name'=>['required','string',Rule::unique('vehicles_brand','name')->ignore($id)]
        ]);

        if($validator->fails())
        {
            return response()->json(['error' => 'Error de validación en datos ingresados','errors' => $validator->errors()->all(),'success' => false]);
        }

        $modelo = VehiclesBrand::find($id);
        if(!Auth::user()->can('update',$modelo))
        {
            return response()->json(['error' => 'Sin autorización.', 'success' => false],403);
        }

        $modelo->name = $request->name;
        $modelo->save();
        return response()->json(['data' => $modelo, 'success' => true], 200);
    }

    public function destroy($id)
    {
        $modelo = VehiclesBrand::findOrFail($id);
        if(!Auth::user()->can('delete',$modelo))
        {
            return response()->json(['error' => 'Sin autorización.', 'success' => false], 403);
        }
        $modelo->delete();
        return response()->json([ 'success' => true], 200);
    }
}
