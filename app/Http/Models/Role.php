<?php 
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
class Role extends Model {
    protected $table = 'roles';
    protected $fillable = [
        'nombre',
        'cantidad',
        'tipo_id'
    ];
}