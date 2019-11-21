<?php 
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
class Ranch extends Model {
    protected $table = 'ranch';
    protected $fillable = [
        'name',
        'address',
        'size'
    ];
}