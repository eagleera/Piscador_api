<?php

namespace App\Http\Controllers;

use App\Http\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkersController extends Controller
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

    public function index()
    {
        $user = Auth::user();
        return Worker::where('ranch_id', $user->default_ranch)->get();
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $nombre = $request->input('nombre');
        $rol_id = $request->input('rol_id');
        $worker = new Worker;
        $worker->nombre = $nombre;
        $worker->rol_id = $rol_id;
        $worker->ranch_id = $user->default_ranch;
        $worker->save();
        return response()->json(['status' => 'created', 'worker'=> $worker]);
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