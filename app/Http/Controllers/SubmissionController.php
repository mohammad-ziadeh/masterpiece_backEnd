<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tasks;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Submission::query()->with(['task', 'user']);

        if ($request->has('task_id') && !empty($request->task_id)) {
            $query->where('task_id', $request->task_id);
        }
        if ($request->filled('user_name')) {
            $userName = $request->user_name;
            $query->whereHas('user', function ($q) use ($userName) {
                $q->where('name', 'like', "%{$userName}%");
            });
        }


        $query->orderBy('id', $request->sort === 'asc' ? 'asc' : 'desc');

        $submissions = $query->get();
        $tasks = Tasks::orderByDesc('id')->get();

        return view('admin.tables.submissions.submission', compact('submissions', 'tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tasks = Tasks::all();
        // return view('admin.submissions.create', compact('tasks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'answer' => 'nullable|string',
            'pdf_path' => 'nullable|mimes:pdf|max:2048',
        ]);

        $pdfPath = null;
        if ($request->hasFile('pdf_path')) {
            $pdfPath = $request->file('pdf_path')->store('submissions', 'public');
        }

        Submission::create([
            'task_id' => $validated['task_id'],
            'submitted_by' => Auth::id(),
            'answer' => $validated['answer'] ?? null,
            'pdf_path' => $pdfPath,
            'grade' => 'pending',
        ]);

        return redirect()->route('submissions.index')->with('success', 'Submission created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Submission $submission)
    {
        return view('admin.tables.submissions.show', compact('submission'));
    }

    public function updateGrade(Request $request)
    {
        foreach ($request->grades as $submissionId => $grade) {
            $submission = Submission::with('task')->find($submissionId);



            // $$$$$ {{ Points Calc According to the task due date}} $$$$$$ // 
            if (!$submission || !$submission->task) {
                continue;
            }

            $user = $submission->user;

            if (!$user) {
                continue;
            }

            $submittedAt = Carbon::parse($submission->created_at);
            $dueDate = Carbon::parse($submission->task->due_date);

            if ($grade === 'passed' && $submission->grade !== 'passed') {

                if ($submittedAt->gt($dueDate)) {
                    $user->weekly_points = max(0, $user->weekly_points - 50);
                    $user->save();
                } elseif ($submittedAt->lt($dueDate)) {
                    $user->weekly_points += 100;
                    $user->save();
                }
            } elseif ($grade === 'failed' && $submission->grade !== 'failed') {
                $user->weekly_points = max(0, $user->weekly_points - 150);
                $user->save();
            }
            // $$$$$ {{ End Points Calc According to the task due date}} $$$$$$ // 


            $submission->update([
                'grade' => $grade,
                'approved_by' => auth()->id(),
                'feedback' => $request->feedback[$submissionId] ?? null,
            ]);
        }

        return back()->with('success', 'Submissions updated successfully.');
    }


}
