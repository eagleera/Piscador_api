<?php

namespace App\Http\Controllers;

use App\Http\Models\Ranch;
use App\Http\Models\RanchHasUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RanchController extends Controller
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
        $roles = Ranch::all();
        foreach($roles as $role) {
            $role->addTipo();
        }
        return $roles;
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $name = $request->input('name');
        $address = $request->input('address');
        $size = $request->input('size');
        $ranch = new Ranch;
        $ranch->name = $name;
        $ranch->address = $address;
        $ranch->size = $size;
        $ranch->save();
        $ranchHasUsers = new RanchHasUsers;
        $ranchHasUsers->ranch_id = $ranch->getKey();
        $ranchHasUsers->user_id = $user->getKey();
        return response()->json(['status' => 'created']);
    }

    public function edit(Request $request, $id) {
        $role = Ranch::find($id);
        $nombre = $request->input('nombre');
        $cantidad = $request->input('cantidad');
        $tipo_id = $request->input('tipo_id');
        ($nombre) ? $role->nombre = $nombre : $role->nombre = $role->nombre;
        ($cantidad) ? $role->nombre = $nombre : $role->nombre = $role->nombre;
        ($tipo_id) ? $role->tipo_id = $tipo_id : $role->tipo_id = $role->tipo_id;
        $role->save();
        return response()->json(['status' => 'updated']);
    }

    public function delete($id) {
        $role = Ranch::find($id);
        $role->delete();
        return response()->json(['status' => 'deleted']);
    }
}