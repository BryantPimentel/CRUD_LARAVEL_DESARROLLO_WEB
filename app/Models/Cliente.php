<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Model;
 
class Cliente extends Model
{
    protected $fillable = [
        'id_cliente', 'nit', 'nombre', 'apellido', 'direccion', 'telefono', 'fecha_nacimiento' 
    ];
}