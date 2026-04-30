<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LiveQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class ActivityLiveQuestionController extends Controller
{
    public function index($activityId)
    {
        $id = decrypt($activityId);
        return view('Admin.live-questions.index', [
            'activityId' => $activityId,
        ]);
    }

    public function listData(Request $request, $activityId)
    {
        $id     = decrypt($activityId);
        $tab    = $request->input('tab', 'unread');
        $search = $request->input('search', '');
        $page   = (int) $request->input('page', 1);
        $perPage = (int) $request->input('perPage', 8);
        $sortCol = $request->input('sortCol', 'created_at');
        $sortDir = $request->input('sortDir', 'desc');

        $allowed = ['id', 'question', 'created_at'];
        if (!in_array($sortCol, $allowed)) $sortCol = 'created_at';
        if (!in_array($sortDir, ['asc', 'desc'])) $sortDir = 'desc';

        $query = LiveQuestion::with('user')
            ->byActivity($id)
            ->when($tab === 'unread', fn($q) => $q->unread())
            ->when($tab === 'read',   fn($q) => $q->read())
            ->when($search, fn($q) => $q->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                    ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
            }))
            ->orderBy($sortCol, $sortDir);

        $total = $query->count();
        $data  = $query->offset(($page - 1) * $perPage)->limit($perPage)->get()
            ->map(fn($q) => [
                'encrypt_id' => encrypt($q->id),
                'question'   => $q->question,
                'short'      => $q->shortQuestion(80),
                'user_name'  => $q->user?->name ?? '-',
                'is_read'    => $q->is_read,
                'created_at' => $q->created_at?->format('d M Y, h:i A'),
            ]);
        return response()->json(['data' => $data, 'total' => $total, 'read_count' => LiveQuestion::Read()->count(), 'unread_count' => LiveQuestion::Unread()->count()]);
    }

    public function markAsRead(Request $request, $id)
    {
        $question = LiveQuestion::findOrFail(decrypt($id));
        $question->markAsRead();
        if (!empty($question)) {
            return response()->json(['status' => true, 'message' => 'Marked as read']);
        } else {
            return response()->json(['status' => false, 'message' => 'Something went wrong']);
        }
    }

    public function markAsUnread(Request $request, $id)
    {
        $question = LiveQuestion::findOrFail(decrypt($id));
        $question->markAsUnread();
        if (!empty($question)) {
            return response()->json(['status' => true, 'message' => 'Marked as unread']);
        } else {
            return response()->json(['status' => false, 'message' => 'Something went wrong']);
        }
    }
    public function submitLiveQuestion(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'question' => 'required|string|max:1000',
                'webcast_activity_id' => 'required|exists:web_cast_activities,id',
                'question_type' => 'nullable|string|max:50',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors(),
                ], 422);
            }

            $question = LiveQuestion::create([
                'user_id' => $request->user()->id,
                'web_cast_activity_id' => $request->webcast_activity_id,
                'question' => $request->question,
                'status' => 1
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Question submitted successfully',
                'data' => $question
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }
}
