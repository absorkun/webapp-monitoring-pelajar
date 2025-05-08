<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends Model
{
    protected $fillable = ['name'];

    public function getGrade(): ?int
    {
        $name = $this->attributes['name'];

        if (str_starts_with($name, 'VII')) {
            return 7;
        } elseif (str_starts_with($name, 'VIII')) {
            return 8;
        } elseif (str_starts_with($name, 'IX')) {
            return 9;
        }

        return null;
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
