<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tasks;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($request)
    {
        $query = Submission::query();

        if ($request->has('name') && !empty($request->name)) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }



        if ($request->has('sort') && $request->sort == 'desc') {
            $query->orderBy('id', 'desc');
        } else {
            $query->orderBy('id', 'asc');
        }


        $submissions = $query->paginate(10);
        $users = User::all();
        $tasks = Tasks::all();

        return view('submissions.index', compact('submissions', 'users', 'tasks'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Submission $submission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Submission $submission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Submission $submission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Submission $submission)
    {
        //
    }
}
