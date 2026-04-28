<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebCastActivity;
use Illuminate\Http\Request;
use App\Models\WebCastResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class WcResourceController extends Controller
{
    /* ── Activity types definition ── */
    private array $activityTypes = [
        'pre_read'    => 'Pre-read',
        'teaser'      => 'Teaser',
        'view_agenda' => 'View Agenda',
        // 'assessment'  => 'Assessment',
        'summary'     => 'Summary',
    ];


    /* ── INDEX: list activities for a webcast ── */
    public function index(Request $request)
    {
        return view('Admin.wcresource.index');
    }

    public function getData(Request $request)
    {
        $q = WebCastResource::query()->with('webcast');
        // dd($q->get());

        // if ($request->search)
        //     $q->where(fn($q) => $q->where('content_title', 'like', "%{$request->search}%")
        //         ->orWhere('activity_name', 'like', "%{$request->search}%")
        //         ->orWhere('dr_name', 'like', "%{$request->search}%"))
        //         ->orWhere('webcast_date', 'like', "%{$request->search}%")
        //         ->orWhere('status', 'like', "%{$request->search}%");

        if ($request->sortCol)
            $q->orderBy($request->sortCol, $request->sortDir ?? 'asc');

        $paginated = $q->paginate($request->perPage ?? 10)->through(function ($row) {
            // $row->encrypt_id = encrypt($row->id);
            // $row->webcast_date = date('d-m-Y', strtotime($row->webcast_date));
            // // return $row;
            return [
                'encrypt_id' => encrypt($row->id),

                // Activity Relation
                'activity' => [
                    'activity_name' => $row->webcast->content_title ?? null,
                ],

                // Resources Collection
                'resources' => [
                    'activity_type' => $row->activity_type,
                    'activity_type_name' => ucwords(str_replace('_', ' ', ($row->activity_type))),
                    'pdf_url' => $row->pdf_url,
                    'url' => $row->url,
                ],
            ];
        });

        return response()->json([
            'total' => $paginated->total(),
            'data'  => $paginated->items(),
        ]);
    }

    /* ── CREATE: show form for a specific activity_type ── */
    public function create()
    {
        $usedIds = WebCastResource::pluck('webcast_activity_id');

        $webcastActivities = WebCastActivity::whereNotIn('id', $usedIds)->pluck('content_title', 'id');
        return view('Admin.wcresource.create', compact('webcastActivities'));
    }

    /* ── STORE ── */
    public function store(Request $request)
    {
        // ✅ Validation
        $validator = Validator::make($request->all(), [
            'webcast_activity_id' => 'required|exists:web_cast_activities,id',
            'items' => 'required|array|min:1',
            'items.*.activity_type' => 'required|string',
            'items.*.button_type' => 'required|in:pdf,url,video',
            'items.*.content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
            // return redirect()->back()
            //     ->withErrors($validator->errors())
            //     ->withInput();
        }

        DB::beginTransaction();

        try {

            foreach ($request->items as $item) {

                $data = [
                    'webcast_activity_id' => $request->webcast_activity_id,
                    'activity_type'       => $item['activity_type'],
                    'upload_type'         => $item['button_type'],
                    'pdf_url'             => null,
                    'url'                 => null,
                ];

                if ($item['button_type'] === 'pdf') {
                    $data['pdf_url'] = $item['content'];
                } else if ($item['button_type'] === 'url') {
                    $data['url'] = $item['content'];
                }

                WebcastResource::create($data);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Webcast Resource Created Successfully',
                'redirect' => route('admin.wc_resource.index')
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /* ── EDIT ── */
    public function edit(WebCastResource $webcastActivity)
    {
        $activityType = $webcastActivity->activity_type;
        $label        = $this->activityTypes[$activityType];

        return view('Admin.wcresource.create', compact(
            'webcast',
            'webcastActivity',
            'activityType',
            'label'
        ));
    }

    /* ── UPDATE ── */
    public function update(Request $request, WebCastResource $webcastActivity, WebCastResource $webcast)
    {
        $request->validate([
            'upload_type' => ['required', Rule::in(['pdf', 'url', 'video'])],
            'pdf_file'    => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'url'         => ['required_if:upload_type,url', 'nullable', 'url', 'max:2048'],
            'video_file'  => ['nullable', 'file', 'mimes:mp4,mov,avi,webm', 'max:204800'],
            'video_url'   => ['nullable', 'url', 'max:2048'],
        ]);

        $data = ['upload_type' => $request->upload_type];

        if ($request->upload_type === 'pdf') {
            if ($request->hasFile('pdf_file')) {
                Storage::disk('public')->delete($webcastActivity->pdf_path);
                $data['pdf_path']   = $request->file('pdf_file')
                    ->store("webcasts/{$webcast->id}/activities", 'public');
                $data['url']        = null;
                $data['video_path'] = null;
                $data['video_url']  = null;
            }
        }

        if ($request->upload_type === 'url') {
            $data['url']        = $request->url;
            $data['pdf_path']   = null;
            $data['video_path'] = null;
            $data['video_url']  = null;
        }

        if ($request->upload_type === 'video') {
            if ($request->hasFile('video_file')) {
                Storage::disk('public')->delete($webcastActivity->video_path);
                $data['video_path'] = $request->file('video_file')
                    ->store("webcasts/{$webcast->id}/activities", 'public');
            }
            $data['video_url'] = $request->video_url;
            $data['pdf_path']  = null;
            $data['url']       = null;
        }

        $webcastActivity->update($data);

        return redirect()
            ->route('admin.wc_resource.index', $webcast->id)
            ->with('success', "{$webcastActivity->label} updated successfully.");
    }

    /* ── DESTROY ── */
    public function destroy(WebCastResource $webcastActivity, WebCastResource $webcast)
    {
        Storage::disk('public')->delete($webcastActivity->pdf_path);
        Storage::disk('public')->delete($webcastActivity->video_path);
        $webcastActivity->delete();

        return redirect()
            ->route('admin.wc_resource.index', $webcast->id)
            ->with('success', 'Activity deleted.');
    }
}
