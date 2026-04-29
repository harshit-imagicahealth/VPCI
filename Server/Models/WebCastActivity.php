<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\WebCastResource;
use App\Models\UserTrack;

class WebCastActivity extends Model
{
    use SoftDeletes;
    protected $table = 'web_cast_activities';
    protected $guarded = ['id'];

    public function resources()
    {
        return $this->hasMany(WebCastResource::class, 'webcast_activity_id', 'id');
    }
    public function tracks()
    {
        return $this->hasMany(UserTrack::class, 'web_cast_activity_id');
    }
}
