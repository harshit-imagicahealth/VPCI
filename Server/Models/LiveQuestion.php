<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\WebCastActivity;


class LiveQuestion extends Model
{
    use SoftDeletes;

    protected $table = 'live_questions';

    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Question belongs to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Question belongs to activity
    public function activity()
    {
        return $this->belongsTo(WebCastActivity::class, 'web_cast_activity_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    // Get latest questions first
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Filter by activity
    public function scopeByActivity($query, $activityId)
    {
        return $query->where('web_cast_activity_id', $activityId);
    }
    // Only unread questions
    public function scopeUnread($query)
    {
        return $query->where('is_read', 0);
    }

    // Only read questions
    public function scopeRead($query)
    {
        return $query->where('is_read', 1);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    // Short question preview
    public function shortQuestion($limit = 50)
    {
        return \Str::limit($this->question, $limit);
    }

    // Mark as read
    public function markAsRead()
    {
        return $this->update(['is_read' => 1]);
    }

    // Mark as unread
    public function markAsUnread()
    {
        return $this->update(['is_read' => 0]);
    }

    // Check if read
    public function isRead()
    {
        return $this->is_read == 1;
    }

    // Check if unread
    public function isUnread()
    {
        return $this->is_read == 0;
    }
}
