<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WebCastActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebinarController extends Controller
{
    public function index(Request $request)
    {
        if ($request->route('id')) {
            $liveSession = WebCastActivity::with('resources')->where('id', decrypt($request->route('id')))->first();
        } else {
            $liveSession = WebCastActivity::with('resources')->where('status', 'live')->first();
        }
        $modules = WebCastActivity::with('resources')->get();
        // dd($modules, $liveSession);
        return view('Frontend.live-session', compact('modules', 'liveSession'));
    }
    public function videoStream(Request $reques, string $webcast_id)
    {
        $id = $webcast_id;
        $data = WebCastActivity::with('resources')->find(decrypt($webcast_id));
        // dd($data);
        // 10
        // eyJpdiI6IjBpNGk4bGd0WlBvNW0yODlLbmRXL3c9PSIsInZhbHVlIjoielppUHovbTVyWlRjY0xZOTM5VFcvUT09IiwibWFjIjoiOTRhN2EzYWRhMjM3NWRkOTk0YzNlNjEzMmQ1ZTdkMDBjZDQxZjgxNzEzYzVhODhiZTljNDA4ZmZjYzA5NWNlMiIsInRhZyI6IiJ9 
        // dd($id, decrypt(encrypt($id)), encrypt($id));
        return view('Frontend.webinar-video', compact('data'));
    }
}
