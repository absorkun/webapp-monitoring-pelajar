<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    public function isAdmin()
    {
        return $this->attributes['role'] === 'admin';
    }

    public function isGuru()
    {
        return $this->attributes['role'] === 'guru';
    }

    public function isSiswa()
    {
        return $this->attributes['role'] === 'siswa';
    }


    public const getRolesOptions = [
        'admin' => 'Admin',
        'guru' => 'Guru',
        'siswa' => 'Siswa',
    ];

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

     public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
