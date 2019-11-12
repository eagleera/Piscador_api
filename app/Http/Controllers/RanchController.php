<?php

namespace App\Http\Controllers;

use App\Http\Models\Ranch;
use App\Http\Models\RanchHasUsers;
use App\Http\Models\Invite;
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
        foreach ($roles as $role) {
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
        $ranchHasUsers->save();
        if ($request->input('firsttime')) {
            $user->default_ranch = $ranch->getKey();
            $user->save();
        }
        $user->addRanch();
        return response()->json(
            [
                'msg' => 'created',
                'ranch ' => $ranch,
                'user' => $user
            ]);
    }

    // public function edit(Request $request, $id)
    // {
    //     $role = Ranch::find($id);
    //     $nombre = $request->input('nombre');
    //     $cantidad = $request->input('cantidad');
    //     $tipo_id = $request->input('tipo_id');
    //     ($nombre) ? $role->nombre = $nombre : $role->nombre = $role->nombre;
    //     ($cantidad) ? $role->nombre = $nombre : $role->nombre = $role->nombre;
    //     ($tipo_id) ? $role->tipo_id = $tipo_id : $role->tipo_id = $role->tipo_id;
    //     $role->save();
    //     return response()->json(['msg' => 'updated']);
    // }

    // public function delete($id)
    // {
    //     $role = Ranch::find($id);
    //     $role->delete();
    //     return response()->json(['msg' => 'deleted']);
    // }
    
    public function createInvite(Request $request)
    {
        $user = Auth::user();
        $code = $request->input('codigo');
        $invite = new Invite;
        $invite->ranch_id = $user->default_ranch;
        $invite->codigo = $code;
        $invite->taken = 0;
        $invite->save();
        return response()->json(['msg' => 'created']);
    }

    public function storeInvite(Request $request)
    {
        $user = Auth::user();
        $code = $request->input('codigo');
        $invite = Invite::where('codigo', $code)->first();
        $invite->taken = true;
        $ranchHasUsers = new RanchHasUsers;
        $ranchHasUsers->ranch_id = $invite->ranch_id;
        $ranchHasUsers->user_id = $user->getKey();
        if(!$user->default_ranch){
            $user->default_ranch = $invite->ranch_id;
            $user->save();
        }
        $ranchHasUsers->save();
        $invite->save();
        return response()->json(['msg' => 'added']);
    }
}
