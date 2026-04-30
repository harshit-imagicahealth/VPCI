<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ActivityQuestion;
use App\Models\User;

class Assessment extends Model
{
    use SoftDeletes;

    protected $table = 'user_assessment_questions_ans';

    protected $guarded = ['id'];

    public function question()
    {
        return $this->belongsTo(ActivityQuestion::class, 'question_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
