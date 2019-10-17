<?php

namespace App\Http\Controllers;

use App\Http\Models\Worker;
use App\Http\Models\Attendance;
use Illuminate\Http\Request;

class JournalController extends Controller
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
        return Journal::all();
    }

    public function store(Request $request)
    {
        $amount = $request->input('amount');
        $note = $request->input('note');
        $journal = new Journal;
        $journal->amount =$amount;
        $journal->notes =$note;
        $journal->save();
        return response()->json(['status' => 'created']);
    }

    public function edit(Request $request, $id) {
        $journal = Journal::find($id);
        $amount = $request->input('amount');
        $note = $request->input('note');
        ($amount) ? $journal->amount = $amount : $journal->amount = $journal->amount;
        ($note) ? $journal->note = $note : $journal->note = $journal->note;
        $journal->save();
        return response()->json(['status' => 'updated']);
    }

    public function delete($id) {
        $journal = Journal::find($id);
        $journal->delete();
        return response()->json(['status' => 'deleted']);
    }
}