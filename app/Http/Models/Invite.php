<?php 
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
class Invite extends Model {

    protected $table = 'invite';
    
    protected $fillable = [
        'ranch_id',
        'codigo',
        'taken'
    ];
}