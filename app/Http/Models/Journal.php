<?php 
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
class Journal extends Model {
    protected $table = 'journal';
    protected $fillable = [
        'user_id',
        'ranch_id',
        'amount',
        'notes'
    ];
}