<?php 
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class RanchHasUsers extends Model {
    protected $table = 'ranch_users';
    protected $fillable = [
        'ranch_id',
        'user_id',
    ];
}