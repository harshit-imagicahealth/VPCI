<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityQuestion;
use App\Models\Assessment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AssessmentController extends Controller
{
    public function index(Request $request)
    {
        $questions = ActivityQuestion::where('status', 1)->get()->map(function ($q) {
            $q->options = is_array($q->options) ? $q->options : json_decode($q->options, true) ?? [];
            return $q;
        });
        $assessment = Assessment::select('user_id')
            ->distinct()
            ->get()->where('user_id', Auth::id())->count();
        if ($assessment > 0) return redirect()->route('webinars.assessment.result');

        return view('Frontend.assessment.index', compact('questions', 'assessment'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'answers'   => 'required|array',
                'answers.*' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $userId  = Auth::id();
            $answers = $request->answers;
            $correct = 0;
            $wrong   = 0;
            $records = [];

            foreach ($answers as $questionId => $answer) {
                $question  = ActivityQuestion::find($questionId);
                if (!$question) continue;

                $isCorrect = strtolower(trim($answer)) === strtolower(trim($question->answer ?? ''));
                if ($isCorrect) $correct++;
                else $wrong++;

                $records[] = [
                    'user_id'         => $userId,
                    'question_id'     => $questionId,
                    'answer'          => $answer,
                    'is_correct_ans'  => $isCorrect ? 1 : 0,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ];
            }

            Assessment::insert($records);

            return response()->json([
                'status'  => true,
                'correct' => $correct,
                'wrong'   => $wrong,
                'total'   => $correct + $wrong,
                'redirect_url' => route('webinars.assessment.result'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function result($activityId = null)
    {
        $userId = Auth::id();

        $answers = Assessment::with('question')
            ->where('user_id', $userId)
            ->whereHas('question')
            ->latest()
            ->get()
            ->groupBy('question_id')
            ->map(fn($group) => $group->first());

        $correct     = $answers->where('is_correct_ans', 1)->count();
        $wrong       = $answers->where('is_correct_ans', 0)->count();
        $total       = $answers->count();
        $percentage  = $total ? round($correct / $total * 100) : 0;
        $completedAt = $answers->max('created_at');

        $mapped = $answers->map(function ($ans) {
            $q       = $ans->question;
            $options = is_array($q->options) ? $q->options : json_decode($q->options, true) ?? [];
            return [
                'question'       => $q->question,
                'options'        => $options,
                'user_answer'    => $ans->answer,
                'correct_answer' => $q->answer,
                'is_correct'     => $ans->is_correct_ans == 1,
            ];
        })->values();

        // $activity = WebCastActivity::find($activityId);

        return view('Frontend.assessment.result', [
            'answers'     => $mapped,
            'correct'     => $correct,
            'wrong'       => $wrong,
            'total'       => $total,
            'percentage'  => $percentage,
            'completedAt' => $completedAt,
            // 'activity'    => $activity,
        ]);
    }
}
