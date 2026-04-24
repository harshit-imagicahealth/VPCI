<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WebCastActivity extends Model
{
    use SoftDeletes;
    protected $table = 'web_cast_activities';
    protected $guarded = ['id'];
}
