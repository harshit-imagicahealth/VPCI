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
        $q = WebCastActivity::query()->has('resources')->with('resources:id,webcast_activity_id,activity_type,upload_type,pdf_url,url,video_url');

        if ($request->search)
            $q->whereHas('resources', function ($q) use ($request) {
                $q->where('activity_type', 'like', '%' . $request->search . '%');
            })->orWhere('content_title', 'like', '%' . $request->search . '%');

        if ($request->sortCol)
            $q->orderBy($request->sortCol, $request->sortDir ?? 'asc');

        $paginated = $q->paginate($request->perPage ?? 10)->through(function ($row) {
            // Resources Collection
            $resources = [];
            foreach ($row->resources as $resource) {
                $resources[] = [
                    'activity_type' => $resource->activity_type,
                    'activity_type_name' => ucwords(str_replace('_', ' ', ($resource->activity_type))),
                    'upload_type' => $resource->upload_type,
                    'pdf_url' => $resource->pdf_url,
                    'url' => $resource->url,
                ];
            }
            return [
                'encrypt_id' => encrypt($row->id),
                // Activity Relation
                'activity' => [
                    'activity_name' => $row->content_title ?? null,
                ],
                'resources' => $resources,
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
        $types = collect(config('wc_connect.feature_items'))->pluck('heading')->map(function ($item) {
            return str_replace(' ', '_', str_replace('-', '_', strtolower($item)));
        });
        $usedIds = WebCastResource::whereNotIn('activity_type', $types)->pluck('webcast_activity_id');
        $allreadyAddedButtons = WebCastResource::get()
            ->groupBy('webcast_activity_id')
            ->map(function ($items) {
                return $items->pluck('activity_type')->toArray();
            });
        $webcastActivities = WebCastActivity::whereNotIn('id', $usedIds)->pluck('content_title', 'id');
        return view('Admin.wcresource.create', compact('webcastActivities', 'allreadyAddedButtons'));
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
    public function edit($id)
    {
        $id = decrypt($id);
        $wcResourceId = WebCastActivity::findOrFail($id)?->id;
        $wcResource = WebCastResource::where('webcast_activity_id', $wcResourceId)->first();

        $allreadyAddedButtons = WebCastResource::get()
            ->groupBy('webcast_activity_id')
            ->map(fn($items) => $items->pluck('activity_type')->toArray());

        $webcastActivities = WebCastActivity::pluck('content_title', 'id');

        $existingItems = WebCastResource::where('webcast_activity_id', $id)->get()->map(fn($i) => [
            'activity_type' => $i->activity_type,
            'button_type' => $i->upload_type,
            'content' => $i->pdf_url ?? ($i->url ?? ''),
        ]);

        return view('Admin.wcresource.edit', compact(
            'wcResource',
            'webcastActivities',
            'allreadyAddedButtons',
            'existingItems'
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
