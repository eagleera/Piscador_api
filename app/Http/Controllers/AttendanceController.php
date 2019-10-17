<?php

namespace App\Http\Controllers;

use App\Http\Models\Worker;
use App\Http\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function indexRange($init_date, $end_date)
    {
        return Attendance::whereBetween('attendance_day',[$init_date, $end_date])->get();
    }

    public function store(Request $request)
    {
        $workers_id = $request->input('attendance');
        $date = $request->input('date');
        $workers = Workers::all();
        foreach($workers as $worker){
            $attendance = new Attendance;
            $attendance->worker_id = $worker->id; 
            $attendance->status = 1;
            $attendance->date = $date;
            if(in_array($worker->id, $workers_id)){
                $attendance->status = 0;
            }
        }
    }

    public function edit(Request $request, $id) {
        $worker = Worker::find($id);
        $nombre = $request->input('nombre');
        $rol_id = $request->input('rol_id');
        ($nombre) ? $worker->nombre = $nombre : $worker->nombre = $worker->nombre;
        ($rol_id) ? $worker->rol_id = $rol_id : $worker->rol_id = $worker->rol_id;
        $worker->save();
        return response()->json(['status' => 'updated']);
    }

    public function delete($id) {
        $worker = Worker::find($id);
        $worker->delete();
        return response()->json(['status' => 'deleted']);
    }
}