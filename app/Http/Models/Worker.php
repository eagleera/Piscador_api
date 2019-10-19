<?php 
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model {
    protected $table = 'workers';
    protected $fillable = [
        'nombre',
        'rol_id'
    ];

    public function role() {
        return $this->belongsTo('App\Http\Models\Role', 'rol_id', 'id');
    }

    public function addRole() {
        $this->role = $this->role()->first();
    }
}