<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';
    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'rut',
        'fono_movil',
        'email'
    ];
}
