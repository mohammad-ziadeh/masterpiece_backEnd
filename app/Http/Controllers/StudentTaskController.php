<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tasks;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class StudentTaskController extends Controller
{
    /**
     * Show all available tasks to the student.
     */
    public function index()
    {
        $tasks = Tasks::whereHas('students', function ($query) {
            $query->where('user_id', Auth::id());
        })->latest()->get();
        $now = Carbon::now();

        return view('home.studentSubmissions.allTasks', compact('tasks', 'now'));
    }

    /**
     * Show task details and previous submissions.
     */
    public function show($taskId)
    {
        $task = Tasks::findOrFail($taskId);
        $now = Carbon::now();
        $submissions = Submission::where('task_id', $taskId)->where('submitted_by', Auth::id())->get();

        return view('home.studentSubmissions.taskSubmission', compact('task', 'submissions', 'now'));
    }

    public function submitAnswer(Request $request, $taskId)
    {
        $validated = $request->validate([
            'answer' => 'required|string',
            'pdf_path' => 'nullable|mimes:pdf|max:2048',
        ]);

        $pdfPath = null;
        if ($request->hasFile('pdf_path')) {
            $pdfPath = $request->file('pdf_path')->store('submissions', 'public');
        }

        Submission::create([
            'task_id' => $taskId,
            'submitted_by' => Auth::id(),
            'answer' => $validated['answer'],
            'pdf_path' => $pdfPath,
        ]);

        return redirect()->route('studentSubmissions.show', $taskId)->with('success', 'Your answer has been submitted successfully.');
    }
}
