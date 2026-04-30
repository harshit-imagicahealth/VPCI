<?php

namespace App\Http\Controllers\Admin;

use App\Models\ActivityQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ActivityQuestionController extends Controller
{
    // GET /questions
    public function index()
    {
        return view('Admin.questions.index');
    }
    public function listData(Request $request)
    {
        $query = ActivityQuestion::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('question', 'like', "%{$request->search}%")
                    ->orWhere('question_type', 'like', "%{$request->search}%")
                    ->orWhere('answer', 'like', "%{$request->search}%");
            });
        }

        $cols = ['id', 'question_type', 'question', 'answer', 'status'];
        if ($request->sortCol && isset($cols[$request->sortCol])) {
            $query->orderBy($cols[$request->sortCol], $request->sortDir === 'desc' ? 'desc' : 'asc');
        } else {
            $query->latest();
        }

        $total = $query->count();
        $data  = $query->offset(($request->page - 1) * $request->perPage)->limit($request->perPage)->get()
            ->map(fn($q) => array_merge($q->toArray(), ['encrypt_id' => encrypt($q->id), 'question_type' => $q->questionTypeLabel($q->question_type)]));

        return response()->json(['data' => $data, 'total' => $total]);
    }

    public function create()
    {
        return view('Admin.questions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question_type' => 'required|string|max:50',
            'question'      => 'required|string',
            'answer'        => 'nullable|string',
            'options'       => 'nullable|array',
            'options.*'     => 'string|max:255',
            'status'        => 'nullable|in:0,1',
        ]);

        ActivityQuestion::create([
            'question_type' => $request->question_type,
            'question'      => $request->question,
            'answer'        => $request->answer,
            'options'       => $request->filled('options') ? json_encode($request->options) : null,
            'status'        => $request->input('status', 0),
        ]);

        return redirect()->route('admin.questions.index')->with('success', 'Question created successfully');
    }

    public function edit($id)
    {
        $question = ActivityQuestion::findOrFail(decrypt($id));
        return view('Admin.questions.create', compact('question'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question_type' => 'required|string|max:50',
            'question'      => 'required|string',
            'answer'        => 'nullable|string',
            'options'       => 'nullable|array',
            'options.*'     => 'string|max:255',
            'status'        => 'nullable|in:0,1',
        ]);

        $question = ActivityQuestion::findOrFail(decrypt($id));
        $question->update([
            'question_type' => $request->question_type,
            'question'      => $request->question,
            'answer'        => $request->answer,
            'options'       => $request->filled('options') ? json_encode($request->options) : null,
            'status'        => $request->input('status', 0),
        ]);

        return redirect()->route('admin.questions.index')->with('success', 'Question updated successfully');
    }

    // DELETE /questions/{id}
    public function destroy($id)
    {
        try {
            $id = decrypt($id);
            ActivityQuestion::findOrFail($id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Deleted successfully'
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['status' => false]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | ENABLE / DISABLE FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function toggle($id)
    {
        $question = ActivityQuestion::findOrFail(decrypt($id));
        $question->update(['status' => !$question->status]);
        return response()->json(['status' => true, 'message' => 'Status updated successfully']);
    }
}
