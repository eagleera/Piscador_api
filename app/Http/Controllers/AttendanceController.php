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
        
    }

    public function store(Request $request)
    {
        $nombre = $request->input('nombre');
        $rol_id = $request->input('rol_id');
        $worker = new Worker;
        $worker->nombre = $nombre;
        $worker->rol_id = $rol_id;
        $worker->save();
        return response()->json(['status' => 'created']);
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