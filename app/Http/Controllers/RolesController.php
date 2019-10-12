<?php

namespace App\Http\Controllers;

use App\Http\Models\Role;

class RolesController extends Controller
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

    public function index()
    {
        return Role::all();
    }
}
