<?php

namespace App\Http\Controllers;

use App\Http\Models\Worker;
use App\Http\Models\Attendance;
use Illuminate\Http\Request;
use Log;

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

    public function index(Request $request)
    {
        $date = $request->input('date');
        $date = \DateTime::createFromFormat('d/m/Y', $date)->format('Y-m-d');
        $attendance =  Attendance::where('attendance_day', $date)->get();
        foreach($attendance as $att) {
            $att->addWorker();
            $att->status = boolval($att->status);
        }
        if(sizeof($attendance) == 0){
            return [];
        }
        return $attendance;
    }

    public function indexRange(Request $request)
    {
        $init_date = $request->input('init_date');
        $init_date = str_replace('/', '-', $init_date);
        $init_date = date('Y-m-d', strtotime($init_date));
        $end_date = $request->input('end_date');
        $end_date = str_replace('/', '-', $end_date);
        $end_date = date('Y-m-d', strtotime($end_date));
        $attendance = Attendance::whereBetween('attendance_day',[$init_date, $end_date])->get();
        foreach($attendance as $att) {
            $att->addWorker();
            $att->worker->addRole();
            $att->worker->role->addTipo();
        }
        return $attendance;
    }

    public function store(Request $request)
    {
        $workers = $request->input('workers');
        $date = $request->input('date');
        $date = date('Y-m-d', strtotime($date));
        foreach($workers as $worker){
            $attendance = new Attendance;
            $attendance->worker_id = $worker['id']; 
            $attendance->status = $worker['attendance'];
            $attendance->attendance_day = $date;
            $attendance->save();
        }
        return response()->json(['status' => 'registered']);
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