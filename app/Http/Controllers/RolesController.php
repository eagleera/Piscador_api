<?php

namespace App\Http\Controllers;

use App\Http\Models\Role;
use App\Http\Models\TiposPaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolesController extends Controller
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
        $roles = Role::where('ranch_id', $user->default_ranch)->get();
        foreach($roles as $role) {
            $role->addTipo();
        }
        return $roles;
    }

    public function indexTipos() {
        return TiposPaga::all();
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $nombre = $request->input('nombre');
        $cantidad = $request->input('cantidad');
        $tipo_id = $request->input('tipo_id');
        $role = new Role;
        $role->nombre = $nombre;
        $role->cantidad = $cantidad;
        $role->tipo_id = $tipo_id;
        $role->ranch_id = $user->default_ranch;
        $role->save();
        return response()->json(['status' => 'created']);
    }

    public function edit(Request $request, $id) {
        $role = Role::find($id);
        $nombre = $request->input('nombre');
        $cantidad = $request->input('cantidad');
        $tipo_id = $request->input('tipo_id');
        ($nombre) ? $role->nombre = $nombre : $role->nombre = $role->nombre;
        ($cantidad) ? $role->cantidad = $cantidad : $role->cantidad = $role->cantidad;
        ($tipo_id) ? $role->tipo_id = $tipo_id : $role->tipo_id = $role->tipo_id;
        $role->save();
        return response()->json(['status' => 'updated']);
    }

    public function delete($id) {
        $role = Role::find($id);
        $role->delete();
        return response()->json(['status' => 'deleted']);
    }
}