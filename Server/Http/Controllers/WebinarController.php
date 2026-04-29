<?php

namespace App\Http\Controllers;

use App\Models\WebCastActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\TrackService;
use Illuminate\Support\Facades\Auth;

class WebinarController extends Controller
{
    public function index(Request $request)
    {
        if ($request->route('id')) {
            $liveSession = WebCastActivity::with('resources')->where('id', decrypt($request->route('id')))->first();
        } else {
            $liveSession = WebCastActivity::with('resources')->where('status', 'live')->first();
        }
        $modules = WebCastActivity::with('resources')
            ->orderByRaw("
                CASE 
                    WHEN status = 'live' THEN 1
                    WHEN status = 'upcoming' THEN 2
                    WHEN status = 'completed' THEN 3
                    ELSE 4
                END
            ")->get();
        // dd($modules, $liveSession);
        return view('Frontend.live-session', compact('modules', 'liveSession'));
    }
    public function videoStream(Request $request, string $webcast_id, TrackService $trackService)
    {
        $data = WebCastActivity::with('resources')->find(decrypt($webcast_id));
        $teaser = (bool)$request->query('teaser', null);
        $type = $teaser ? 'teaser' : 'video';
        return view('Frontend.webinar-video', compact('data', 'teaser'));
    }
    public function pdfStream(Request $request, TrackService $trackService)
    {
        $data = WebCastActivity::with('resources')->find(decrypt($request->route('webcast_id_pdf')));
        $type = $request->route('type', null);
        if ($data) {
            $trackService->trackRecord(Auth::user(), $type, $data->id);
        }
        return view('Frontend.webinar-pdf', compact('data', 'type'));
    }
    public function trackVideoComplete(Request $request, TrackService $trackService)
    {
        $data = WebCastActivity::with('resources')->find($request->input('web_cast_id'));
        $videoType = $request->input('video_type', null);
        if ($data) {
            $trackService->trackRecord(Auth::user(), $videoType, $data->id);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
