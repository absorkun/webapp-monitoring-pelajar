<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'name',
        'nisn',
        'gender',
        'birthdate',
        'address',
        'is_active',
        'user_id',
        'classroom_id'
    ];

    public const getGenders = ['L' => 'Laki-laki', 'P' => 'Perempuan'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}
