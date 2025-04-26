<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tasks;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Tasks::query();

        // -------{{ Start Filters }}------- //
        if ($request->has('name') && !empty($request->name)) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }



        if ($request->has('deleted')) {
            if ($request->deleted == 'only') {
                $query->onlyTrashed();
            } elseif ($request->deleted == 'with') {
                $query->withTrashed();
            }
        }

        if ($request->has('sort') && $request->sort == 'desc') {
            $query->orderBy('id', 'desc');
        } else {
            $query->orderBy('id', 'asc');
        }
        $date = today();

        // -------{{ End Filters }}------- //

        $tasks = $query->paginate(10);
        $students = User::where('role', 'student')->get(); 

        return view('admin.tables.tasks.tasks', compact('tasks', 'date', 'students'));
    }

    /**
     * Show the form 
     */

    public function show($id)
    {
        $task = Tasks::findOrFail($id);




        if ($task->pdf_path) {
            $filePath = storage_path('app/public/' . $task->pdf_path);
            $fileUrl = asset('storage/' . $task->pdf_path);
            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
        } else {
            $fileUrl = null;
            $fileExtension = null;
        }

        return view('admin.tables.tasks.taskDescription', compact('task', 'fileUrl', 'fileExtension'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $date = today();
        $students = User::where('role', 'student')->get();
        return view("admin.tables.tasks.tasks", compact('date','students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Handle file uploads
        $pdfPath = null;



        if ($request->hasFile('pdf')) {
            $pdfPath = $request->file('pdf')->store('pdfs', 'public');
        }



        $task = Tasks::create([
            'name' => $request->name,
            'pdf_path' => $pdfPath,
            'description' => $request->description,
            'submitted_by' => auth()->id(),
            'due_date' => $request->due_date,
        ]);


        $task->students()->attach($request->assigned_to);
        return redirect('tasks')->with('success', 'Task stored successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $task = Tasks::findOrFail($id);
        return view("admin.tables.tasks.tasks", compact("task"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $task = Tasks::findOrFail($id);

        $pdfPath = $task->pdf_path;


        if ($request->hasFile('pdf')) {
            if ($pdfPath) {
                Storage::disk('public')->delete($pdfPath);
            }
            $pdfPath = $request->file('pdf')->store('pdfs', 'public');
        }



        $task->update([
            'name' => $request->name,
            'pdf_path' => $pdfPath,
            'description' => $request->description,
            'submitted_by' =>auth()->id(),
            'due_date' => $request->due_date,
        ]);
        
        $task->students()->sync($request->assigned_to);

        return redirect('tasks')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Tasks::findOrFail($id);

        if ($task->pdf_path) {
            Storage::delete('public/' . $task->pdf_path);
        }

        $task->delete();
        return redirect('tasks')->with('success', 'Task deleted successfully.');
    }

    public function restore($id)
    {
        $task = Tasks::withTrashed()->findOrFail($id);
        $task->restore();

        return redirect()->route('tasks.index')->with('success', 'Task restored successfully.');
    }

    public function deletePermanently($id)
    {
        $task = Tasks::onlyTrashed()->findOrFail($id);

        if ($task->pdf_path) {
            Storage::delete('public/' . $task->pdf_path);
        }

        $task->forceDelete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted permanently');
    }


    public function emptyDeleted()
    {
        $deletedTasks = Tasks::onlyTrashed()->get();

        foreach ($deletedTasks as $task) {
            if ($task->pdf_path) {
                Storage::disk('public')->delete($task->pdf_path);
            }
            $task->forceDelete();
        }

        return redirect()->route('tasks.index')->with('success', 'All deleted tasks have been removed permanently!');
    }
}
