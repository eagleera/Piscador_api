<?php 
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
class Attendance extends Model {
    protected $table = 'attendance';
    protected $fillable = [
        'worker_id',
        'attendance_day',
        'status'
    ];
}