<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\WebCastActivity;

class UserTrack extends Model
{
    use HasFactory;

    protected $table = 'user_tracks';

    protected $guarded = ['id'];

    protected $casts = [
        'complete_status' => 'boolean',
        'completed_at'   => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Each track belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function activity()
    {
        return $this->belongsTo(WebCastActivity::class, 'web_cast_activity_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES (Optional but useful)
    |--------------------------------------------------------------------------
    */

    // Get completed records
    public function scopeCompleted($query)
    {
        return $query->where('complete_status', 1);
    }

    // Get by type (pre_read, teaser, etc.)
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS (Optional)
    |--------------------------------------------------------------------------
    */

    // Mark as completed
    public function isCompleted($type)
    {
        return UserTrack::where('user_id', Auth::id())
            ->where('type', $type)
            ->where('complete_status', 1)
            ->exists();
    }
}
