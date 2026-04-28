<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Requests;
use App\Models\User;
use App\Models\WebCastActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('Admin.login');
    }

    public function loginPost(Request $request)
    {
        $admin = Admin::where('email', $request->email)->first();

        if ($admin && $request->password == $admin->password) {
            Auth::guard('admin')->login($admin);
            Session::flash('success', 'Login Successful.');
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.login')->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        $usersCount = User::count();
        $categoryCount = Category::count();
        $webCastActivityCount = WebCastActivity::count();
        return view('Admin.dashboard', compact('usersCount', 'categoryCount', 'webCastActivityCount'));
    }

    // list
    public function userlist()
    {
        return view('Admin.users.list');
        // $data = User::where('isDel', 0)->get();
        // return view('Admin.users.list', compact('data'));
    }

    // list get data
    public function userdata(Request $request)
    {
        $q = User::query();

        if ($request->search)
            $q->where(fn($q) => $q->where('first_name', 'like', "%{$request->search}%")
                ->orWhere('last_name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%"));

        if ($request->sortCol)
            $q->orderBy($request->sortCol, $request->sortDir ?? 'asc');

        $paginated = $q->paginate($request->perPage ?? 10);

        return response()->json([
            'total' => $paginated->total(),
            'data'  => $paginated->items(),
        ]);
    }

    public function useradd()
    {
        return view('Admin.users.create');
    }

    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'parent_employee_code' => 'nullable',
            'employee_code' => 'required',
            'employee_pos_code' => 'required',
            'name' => 'required',
            'mobile_no' => 'required',
            'emailid' => 'required',
            'hq' => 'nullable',
            'region' => 'nullable',
            'zone' => 'nullable',
            'unique_id' => 'required',
            'designation' => 'required',
        ]);

        $position_codes = [
            'ME' => 0,
            'ASM' => 1,
            'RSM' => 2,
            'ZSM' => 3,
            'GM' => 4,
        ];

        $validated['employee_pos'] = $position_codes[$validated['employee_pos_code']] ?? 0;

        $validated['original_password'] = $validated['employee_code'];
        $validated['password'] = md5($validated['employee_code']);

        User::create($validated);

        return redirect()->route('admin.userlist')
            ->with('success', 'User created successfully.');
    }

    public function useredit($id)
    {
        $user = User::where('id', $id)->first();
        return view('Admin.users.edit', compact('user'));
    }

    public function userupdate(Request $request, $id)
    {
        $validated = $request->validate([
            'parent_employee_code' => 'nullable',
            'employee_code' => 'required',
            'employee_pos_code' => 'required',
            'name' => 'required',
            'mobile_no' => 'required',
            'emailid' => 'required|email',
            'hq' => 'nullable',
            'region' => 'nullable',
            'zone' => 'nullable',
            'unique_id' => 'required',
            'designation' => 'required',
        ]);

        // Map position code to position level
        $position_codes = [
            'ME' => 0,
            'ASM' => 1,
            'RSM' => 2,
            'ZSM' => 3,
            'GM' => 4,
        ];

        // Add calculated fields
        $validated['employee_pos'] = $position_codes[$validated['employee_pos_code']] ?? 0;
        $validated['original_password'] = $validated['employee_code'];
        $validated['password'] = md5($validated['employee_code']);

        $user = User::findOrFail($id);
        $user->update($validated);

        return redirect()->route('admin.userlist')
            ->with('success', 'User updated successfully.');
    }

    public function userdelete($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.']);
        }

        $user->isDel = 1;
        $user->save();

        return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
    }

    public function deleteall()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return response()->json(['success' => true, 'message' => 'All users permanently deleted.']);
    }

    public function usercsv()
    {
        $users = DB::table('tbl_users')->get();
        $filename = "tbl_users_" . now()->format('Y_m_d_H_i_s') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');

            if ($users->count() > 0) {
                fputcsv($file, array_keys((array) $users[0]));

                foreach ($users as $row) {
                    fputcsv($file, (array) $row);
                }
            } else {
                fputcsv($file, ['No data available']);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function importUsers(Request $request)
    {
        $request->validate([
            'user_csv' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('user_csv');
        $handle = fopen($file->getRealPath(), 'r');

        $header = fgetcsv($handle, 1000, ',');
        $imported = 0;
        $updated = 0;

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            $data = array_combine($header, $row);
            if (!$data || empty($data['employee_code']))
                continue;

            $existing = DB::table('tbl_users')->where('id', $data['id'])->first();

            $userData = [
                'parent_employee_code' => $data['parent_employee_code'] ?? null,
                'employee_code' => $data['employee_code'] ?? null,
                'employee_pos_code' => $data['employee_pos_code'] ?? null,
                'employee_pos' => match ($data['employee_pos_code']) {
                    'ME' => 0,
                    'ASM' => 1,
                    'RSM' => 2,
                    'ZSM' => 3,
                    'GM' => 4,
                    default => 0,
                },
                'name' => $data['name'] ?? null,
                'mobile_no' => $data['mobile_no'] ?? null,
                'emailid' => $data['emailid'] ?? null,
                'designation' => $data['designation'] ?? null,
                'hq' => $data['hq'] ?? null,
                'region' => $data['region'] ?? null,
                'zone' => $data['zone'] ?? null,
                'unique_id' => $data['unique_id'] ?? null,
                'isDel' => 0,
            ];

            if ($existing) {
                DB::table('tbl_users')
                    ->where('id', $data['id'])
                    ->update($userData);
                $updated++;
            } else {
                $userData['password'] = md5($data['employee_code']);
                $userData['original_password'] = $data['employee_code'];

                DB::table('tbl_users')->insert($userData);
                $imported++;
            }
        }

        fclose($handle);

        return back()->with('success', "✅ $imported new users added, 🔄 $updated users updated successfully!");
    }

    public function requestlist()
    {
        return view('Admin.meeting.list');
    }

    public function requestdata(Request $request)
    {
        $page = max(1, (int) $request->page);
        $perPage = 10;
        $search = $request->search ?? '';

        $query = Requests::query();

        if ($search !== '') {
            $query->where('name', 'like', "%{$search}%");
        }

        $total = $query->count();

        $data = $query->orderByDesc('id')
            ->offset(($page - 1) * $perPage)
            ->limit($perPage)
            ->get()
            ->map(function ($row) {
                return [
                    'id' => encrypt($row->id),
                    'raw_id' => $row->id,
                    'name' => $row->name,
                    'designation' => $row->designation,
                    'created_at' => Carbon::parse($row->created_at)->format('d-m-Y h:i A'),
                ];
            });

        return response()->json([
            'data' => $data,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'total_pages' => ceil($total / $perPage),
        ]);
    }

    public function requestedit($id)
    {
        $data = Requests::findOrFail(decrypt($id));
        return view('Admin.meeting.edit', compact('data'));
    }

    public function editupdate(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:1,2',
        ]);

        $user = Requests::findOrFail(decrypt($id));

        if ($request->status == 1) {

            $posterName = 'arnicor/posters/' . uniqid() . '_' . time() . '.' . $request->poster->extension();

            Storage::disk('spaces')->put(
                $posterName,
                file_get_contents($request->poster),
                'public'
            );

            $videoName = 'arnicor/videos/' . uniqid() . '_' . time() . '.' . $request->video->extension();

            Storage::disk('spaces')->put(
                $videoName,
                file_get_contents($request->video),
                'public'
            );

            $user->poster = $posterName;
            $user->video = $videoName;
        }

        if ($request->status == 2) {
            $user->poster = null;
            $user->video = null;
        }

        $user->status = $request->status;
        $user->save();

        return redirect()
            ->route('admin.requestlist')
            ->with('success', 'Request updated successfully');
    }

    public function requestdelete($id)
    {
        $id = decrypt($id);

        $record = Requests::where('id', $id)->first();

        if (!$record) {
            return response()->json(['status' => 'error']);
        }

        if (!empty($record->photo)) {
            Storage::disk('spaces')->delete($record->photo);
        }

        $record->delete();

        return response()->json(['status' => 'success']);
    }

    public function requestcsv()
    {
        $fileName = 'Sales Team Report' . date('Y-m-d_H-i-s') . '.csv';

        $requests = DB::table('requests')
            ->leftJoin('tbl_users as users', 'requests.employee_code', '=', 'users.employee_code')
            ->select(
                'requests.id',
                'requests.employee_code',
                'requests.name',
                'requests.designation',
                'requests.mobile',
                'requests.gender',
                'requests.photo',
                'requests.videoDownloadCount',
                'requests.dm_videoStatus',
                'requests.audio',
                'requests.qc_status',
                'requests.qc_audio_status',
                'requests.created_at',
                'requests.updated_at',
                'users.name as user_name',
                'users.hq as user_hq',
                'users.region',
                'users.zone'
            )
            ->orderBy('requests.id', 'desc')
            ->get();

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () use ($requests) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID',
                'Employee Code',
                'Edited Name',
                'Designation',
                'whatsapp No',
                'Gender',
                'Photo',
                'Audio',
                'Photo Review Status',
                'Audio Review Status',
                'User Name',
                'User HQ',
                'Region',
                'Zone',
                'Video Status',
                'Download Ai Video Count',
                'Created At',
                'Updated At',
            ]);

            foreach ($requests as $row) {

                $pstatus = "";
                if ($row->qc_audio_status == 0) {
                    $pstatus = "Pending";
                } else if ($row->qc_audio_status == 1) {
                    $pstatus = "Approved";
                } else if ($row->qc_audio_status == 2) {
                    $pstatus = "Rejected";
                }

                $astatus = "";

                if ($row->qc_status == 0) {
                    $astatus = "Pending";
                } else if ($row->qc_status == 1) {
                    $astatus = "Approved";
                } else if ($row->qc_status == 2) {
                    $astatus = "Low Resolution";
                } else if ($row->qc_status == 3) {
                    $astatus = "Not A Front Facing Photo";
                } else if ($row->qc_status == 4) {
                    $astatus = "Face Missing";
                } else if ($row->qc_status == 5) {
                    $astatus = "Multiple People in Photo";
                } else if ($row->qc_status == 6) {
                    $astatus = "Reject - goggles";
                } else if ($row->qc_status == 7) {
                    $astatus = "Not Compatible with AI — Upload Different Photo";
                }

                $vstatus = "";
                if ($row->dm_videoStatus == 15) {
                    $vstatus = "Done";
                } else {
                    $vstatus = "Pending";
                }

                fputcsv($file, [
                    $row->id,
                    $row->employee_code,
                    $row->name,
                    $row->designation,
                    $row->mobile,
                    $row->gender,
                    $row->photo ? 'https://ihapp.blr1.cdn.digitaloceanspaces.com/' . $row->photo : '',
                    $row->audio ? 'https://ihapp.blr1.cdn.digitaloceanspaces.com/' . $row->audio : '',
                    $astatus,
                    $pstatus,
                    $row->user_name,
                    $row->user_hq,
                    $row->region,
                    $row->zone,
                    $vstatus,
                    $row->videoDownloadCount,
                    $row->created_at,
                    $row->updated_at,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
