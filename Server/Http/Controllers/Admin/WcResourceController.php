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

        if ($request->search)
            $q->whereHas('webcast', function ($q) use ($request) {
                $q->where('content_title', 'like', '%' . $request->search . '%');
            })->orWhere('activity_type', 'like', '%' . $request->search . '%');

        if ($request->sortCol)
            $q->orderBy($request->sortCol, $request->sortDir ?? 'asc');

        $paginated = $q->paginate($request->perPage ?? 10)->through(function ($row) {
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
        // Validation
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
    public function update(Request $request, $id)
    {
        // Validation
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
        }

        DB::beginTransaction();

        try {

            // Delete old records (simple approach)
            WebcastResource::where('webcast_activity_id', $id)->delete();

            // Recreate new items
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
                } elseif ($item['button_type'] === 'url') {
                    $data['url'] = $item['content'];
                }

                WebcastResource::create($data);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Webcast Resource Updated Successfully',
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
