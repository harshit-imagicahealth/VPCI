<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class TrackService
{
    public function trackRecord($user, $type, $activityId)
    {
        try {
            if (!$user) return;

            $user->tracks()->updateOrCreate(
                [
                    'type' => $type,
                    'web_cast_activity_id' => $activityId

                ],
                [
                    'complete_status' => 1,
                    'completed_at' => Carbon::now()
                ]
            );
            // Count completed tracks (exclude certificate)
            $completedCount = $user->tracks()
                ->where('web_cast_activity_id', $activityId)
                ->where('complete_status', 1)
                ->where('type', '!=', 'certificate')
                ->count();

            //  If cirtificate count completed → unlock certificate
            if ($completedCount == collect(config('wc_connect.cirtificate_complate_count'))->count()) {
                $user->tracks()->updateOrCreate(
                    [
                        'type' => 'certificate',
                        'web_cast_activity_id' => $activityId,
                    ],
                    [
                        'complete_status' => 1,
                        'completed_at' => Carbon::now(),
                    ]
                );
            }

            return;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return;
        }
    }
}
