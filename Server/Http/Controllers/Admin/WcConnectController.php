<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebCastActivity;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Str;

class WcConnectController extends Controller
{
    /* ── Validation rules ── */
    private function rules(bool $isUpdate = false): array
    {
        return [
            'content_title'  => ['required', 'string', 'max:255'],
            'activity_name'  => ['required', 'string', 'max:255'],
            'dr_name'        => ['required', 'string', 'max:255'],
            'thumbnail'      => [$isUpdate ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'slider_images'  => ['nullable', 'array'],
            'slider_images.*' => ['image', 'mimes:jpg,jpeg,png', 'max:5120'],
            'webcast_date'   => ['required', 'string'],
            'webcast_hour'   => ['required'],
            'webcast_minute' => ['required'],
            'webcast_ampm'   => ['required', 'in:AM,PM'],
            'status'         => ['required', 'in:upcoming,live,completed'],
        ];
    }

    /* ── INDEX ── */
    public function index(Request $request)
    {
        return view('Admin.wcconnect.index');
    }

    public function getData(Request $request)
    {
        $q = WebCastActivity::query();

        if ($request->search)
            $q->where(fn($q) => $q->where('content_title', 'like', "%{$request->search}%")
                ->orWhere('activity_name', 'like', "%{$request->search}%")
                ->orWhere('dr_name', 'like', "%{$request->search}%"))
                ->orWhere('webcast_date', 'like', "%{$request->search}%")
                ->orWhere('status', 'like', "%{$request->search}%");

        if ($request->sortCol)
            $q->orderBy($request->sortCol, $request->sortDir ?? 'asc');

        $paginated = $q->paginate($request->perPage ?? 10)->through(function ($row) {
            $row->encrypt_id = encrypt($row->id);
            $row->webcast_date = date('d-m-Y', strtotime($row->webcast_date));
            return $row;
        });

        return response()->json([
            'total' => $paginated->total(),
            'data'  => $paginated->items(),
        ]);
    }

    /* ── CREATE ── */
    public function create(Request $request)
    {
        return view('Admin.wcconnect.create');
    }

    /* ── STORE ── */
    // public function store(Request $request)
    // {
    //     // dd($request->all());
    //     $data = $request->validate($this->rules(false));
    //     $data['webcast_date'] = date('Y-m-d', strtotime($data['webcast_date']));
    //     $data['webcast_time'] = $data['webcast_hour'] . ':' . $data['webcast_minute'] . ' ' . $data['webcast_ampm'];

    //     /* Thumbnail */
    //     $data['thumbnail'] = $request->file('thumbnail')
    //         ->store('webcasts/thumbnails', 'public');

    //     /* Slider images */
    //     $sliderPaths = [];
    //     if ($request->hasFile('slider_images')) {
    //         foreach ($request->file('slider_images') as $img) {
    //             $sliderPaths[] = $img->store('webcasts/sliders', 'public');
    //         }
    //     }
    //     $data['slider_images'] = json_encode($sliderPaths);

    //     WebCastActivity::create($data);

    //     return redirect()
    //         ->route('admin.wc_connect.index')
    //         ->with('success', 'WebCast Activity created successfully.');
    // }
    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->validate($this->rules(false));
        $data['webcast_date'] = date('Y-m-d', strtotime($data['webcast_date']));
        $data['webcast_time'] = $data['webcast_hour'] . ':' . $data['webcast_minute'] . ' ' . $data['webcast_ampm'];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->uploadImage(
                $request->file('thumbnail'),
                'ACE/webcasts/thumbnails'
            );
        }

        /* 4. Handle Multiple Slider Images Upload */
        $sliderPaths = [];
        if ($request->hasFile('slider_images')) {
            foreach ($request->file('slider_images') as $img) {
                // Using your helper function inside the loop
                $sliderPaths[] = $this->uploadImage($img, 'ACE/webcasts/sliders');
            }
        }
        $data['slider_images'] = json_encode($sliderPaths);

        WebCastActivity::create($data);

        return redirect()
            ->route('admin.wc_connect.index')
            ->with('success', 'WebCast Activity created successfully.');
    }
    private function uploadImage($file, $folder)
    {
        // Generate UNIQUE image name using UUID
        $uniqueName = Str::uuid() . time() . '.' . $file->getClientOriginalExtension();

        // Define full path
        $uploadPath = $folder . '/' . $uniqueName;

        // Upload to DigitalOcean Spaces (or configured disk)
        Storage::disk('spaces')->put($uploadPath, file_get_contents($file), 'public');

        // Return the file name (or full path if you prefer)
        return $uniqueName;
    }
    /* ── EDIT ── */
    public function edit(Request $request, string $id)
    {
        $webcast = WebCastActivity::find(decrypt($id));
        if (!$webcast) {
            Session::flash('error', 'WebCast Activity not found.');
            return redirect()
                ->route('admin.wc_connect.index');
        }
        return view('Admin.wcconnect.create', compact('webcast'));
    }

    /* ── UPDATE ── */
    public function update(Request $request, string $id)
    {
        $webcast = WebCastActivity::find(decrypt($id));
        if (!$webcast) {
            Session::flash('error', 'WebCast Activity not found.');
            return redirect()
                ->route('admin.wc_connect.index');
        }
        $data = $request->validate($this->rules(true));

        /* 1. Update Thumbnail */
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if it exists
            if ($webcast->thumbnail) {
                Storage::disk('public')->delete($webcast->thumbnail);
            }

            // Upload new thumbnail using helper
            $data['thumbnail'] = $this->uploadImage(
                $request->file('thumbnail'),
                'ACE/webcasts/thumbnails'
            );
        }

        /* 2. Update Slider Images */
        if ($request->hasFile('slider_images')) {
            // Delete old slider images from storage
            $oldImages = json_decode($webcast->slider_images, true) ?? [];
            foreach ($oldImages as $oldPath) {
                Storage::disk('public')->delete($oldPath);
            }

            // Upload new images using helper
            $newSliderPaths = [];
            foreach ($request->file('slider_images') as $img) {
                $newSliderPaths[] = $this->uploadImage($img, 'ACE/webcasts/sliders');
            }

            $data['slider_images'] = json_encode($newSliderPaths);
        }

        $webcast->update($data);

        return redirect()
            ->route('admin.wc_connect.index')
            ->with('success', 'WebCast Activity updated successfully.');
    }

    /* ── DESTROY ── */
    public function destroy(Request $request, string $id)
    {
        try {
            $webcast = WebCastActivity::find(decrypt($id));
            if (!$webcast) {
                Session::flash('error', 'WebCast Activity not found.');
                return redirect()
                    ->route('admin.wc_connect.index');
            }
            Storage::disk('public')->delete($webcast->thumbnail);
            $sliders = json_decode($webcast->slider_images, true) ?? [];
            foreach ($sliders as $path) {
                Storage::disk('public')->delete($path);
            }

            $webcast->delete();

            if ($request->ajax()) {
                return response()->json([
                    'status' => true,
                    'message' => 'WebCast Activity deleted successfully.'
                ]);
            }
            return redirect()
                ->route('admin.wc_connect.index')
                ->with('success', 'WebCast Activity deleted successfully.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /* ── CSV EXPORT ── */
    public function export(Request $request)
    {
        // $webcasts = WebCastActivity::with('category')
        //     ->when($request->search, fn($q) =>
        //         $q->where('content_title', 'like', "%{$request->search}%")
        //     )
        //     ->orderBy($request->sortCol ?? 'id', $request->sortDir ?? 'asc')
        //     ->get();

        // $csv = "\"#\",\"Content Title\",\"Activity\",\"Dr. Name\",\"Category\",\"Date\",\"Time\",\"Status\"\n";
        // foreach ($webcasts as $i => $w) {
        //     $time = "{$w->webcast_hour}:{$w->webcast_minute} {$w->webcast_ampm}";
        //     $csv .= "\"{$i+1}\",\"{$w->content_title}\",\"{$w->activity_name}\",\"{$w->dr_name}\","
        //           . "\"{$w->category->name}\",\"{$w->webcast_date}\",\"{$time}\",\"{$w->status}\"\n";
        // }

        // return response($csv, 200, [
        //     'Content-Type'        => 'text/csv',
        //     'Content-Disposition' => 'attachment; filename="webcasts.csv"',
        // ]);
    }
}
