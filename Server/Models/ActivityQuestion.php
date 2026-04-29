<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\WebCastActivity;

class ActivityQuestion extends Model
{
    use SoftDeletes;

    protected $table = 'activity_questions';

    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    // Only active questions
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    // Filter by type
    public function scopeType($query, $type)
    {
        return $query->where('question_type', $type);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    // Add / update answer
    public function setAnswer($answer)
    {
        $this->update([
            'answer' => $answer
        ]);
    }

    // Enable question
    public function enable()
    {
        $this->update(['status' => 1]);
    }

    // Disable question
    public function disable()
    {
        $this->update(['status' => 0]);
    }

    public function questionTypeLabel($type)
    {
        $types = config('wc_connect.question_types');
        return isset($types[$type]) ? $types[$type] : ucwords(str_replace('_', ' ', $type));
    }
}
