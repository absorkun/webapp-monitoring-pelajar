<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Teacher extends Model
{
    protected $fillable = [
        'name',
        'nuptk',
        'gender',
        'birthdate',
        'address',
        'user_id',
        'subject_id'
    ];

    public const getGenders = ['L' => 'Laki-laki', 'P' => 'Perempuan'];

    protected $casts = [
        'birthdate' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}
