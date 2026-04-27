<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WebCastResource extends Model
{
    use SoftDeletes;
    protected $table = 'web_cast_activity_resources';
    protected $guarded = ['id'];

    protected $fillable = [
        'webcast_activity_id',
        'activity_type',
        'upload_type',
        'pdf_url',
        'url',
        'video_url',
    ];

    /* Labels for display */
    public static array $activityLabels = [
        'pre_read'    => 'Pre-read',
        'teaser'      => 'Teaser',
        'view_agenda' => 'View Agenda',
        'assessment'  => 'Assessment',
        'summary'     => 'Summary',
    ];

    public static array $activityIcons = [
        'pre_read'    => 'fa-book-open',
        'teaser'      => 'fa-circle-play',
        'view_agenda' => 'fa-calendar-check',
        'assessment'  => 'fa-list-check',
        'summary'     => 'fa-file-lines',
    ];

    public function webcast()
    {
        return $this->belongsTo(WebCastActivity::class, 'webcast_activity_id', 'id');
    }

    public function getLabelAttribute(): string
    {
        return self::$activityLabels[$this->activity_type] ?? $this->activity_type;
    }

    public function getIconAttribute(): string
    {
        return self::$activityIcons[$this->activity_type] ?? 'fa-file';
    }
}
