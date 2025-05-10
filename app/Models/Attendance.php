<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'classroom_id',
        'teacher_id',
        'subject_id',
        'student_id',
        'date',
        'start',
        'end',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'start' => 'datetime:H:i:s',
        'end'   => 'datetime:H:i:s',
    ];

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
