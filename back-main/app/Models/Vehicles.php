<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\VehiclesModel;

class Vehicles extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_vehicle_model',
        'active',
        'patente',
        'descripcion',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function model()
    {
        return $this->belongsTo(VehiclesModel::class, 'id_vehicle_model');
    }
}
