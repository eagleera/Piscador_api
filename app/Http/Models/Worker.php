<?php 
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model {
    protected $table = 'workers';
    protected $fillable = [
        'nombre',
        'rol_id'
    ];
}