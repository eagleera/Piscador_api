<?php

namespace App\Http\Controllers;

use App\Http\Models\Worker;
use App\Http\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $this->middleware('auth');
    }

    public function index(Request $request, $fecha)
    {
        $user = Auth::user();
        $attendance =  Attendance::where([
            'attendance_day'=> $fecha,
            'ranch_id' => $user->default_ranch
        ])->get();
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
        $user = Auth::user();
        $init_date = $request->input('init_date');
        $init_date = str_replace('/', '-', $init_date);
        $init_date = date('Y-m-d', strtotime($init_date));
        $end_date = $request->input('end_date');
        $end_date = str_replace('/', '-', $end_date);
        $end_date = date('Y-m-d', strtotime($end_date));
        $attendance = Attendance::where('ranch_id', $user->default_ranch)->whereBetween('attendance_day',[$init_date, $end_date])->get();
        foreach($attendance as $att) {
            $att->addWorker();
            $att->worker->addRole();
            $att->worker->role->addTipo();
        }
        return $attendance;
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $workers = $request->input('workers');
        $date = $request->input('date');
        $date = date('Y-m-d', strtotime($date));
        foreach($workers as $worker){
            $attendance = new Attendance;
            $attendance->ranch_id = $user->default_ranch;
            $attendance->worker_id = $worker['id']; 
            $attendance->status = $worker['attendance'];
            $attendance->attendance_day = $date;
            $attendance->save();
        }
        return response()->json(['msg' => 'registered']);
    }

    // public function edit(Request $request, $id) {
    // }

    // public function delete($id) {
    // }
}