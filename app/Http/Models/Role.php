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

    public function tipo() {
        return $this->belongsTo('App\Http\Models\TiposPaga');
    }
    public function addTipo() {
        $this->tipo = $this->tipo()->first();
    }
}