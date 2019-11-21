<?php 
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worker extends Model {
    use SoftDeletes;
    protected $table = 'workers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre',
        'rol_id',
        'ranch_id'
    ];

    public function role() {
        return $this->belongsTo('App\Http\Models\Role', 'rol_id', 'id');
    }

    public function addRole() {
        $this->role = $this->role()->first();
    }
}