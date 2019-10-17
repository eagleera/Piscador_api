<?php 
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class TiposPaga extends Model {
    protected $table = 'tipos_paga';
    protected $fillable = ['nombre'];
}