<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    protected $fillable = ['score', 'semester', 'student_id', 'classroom_id', 'subject_id'];

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public const getSemesters = [
        1 => '1',
        2 => '2',
    ];

    public function getLetterScore()
    {
        $score = $this->attributes['score'];
        if ($score > 90) return 'A';
        if ($score > 80) return 'B';
        if ($score > 70) return 'C';
        if ($score > 60) return 'D';
        return 'E';
    }
}
