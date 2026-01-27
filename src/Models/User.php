<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Company;
use App\Models\JobApplication;
use App\Models\Resume ;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasUuids,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    //* --------------------------- UUID primary key settings -------------------------
    protected $keyType = 'string';
     public $incrementing = false;
    //* --------------------------- Mass assignable attributes ------------------------- */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];
    /**
     ** ----------------------The attributes that should be hidden for serialization.-------------
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    //* ------------------------- The attributes that should be cast.------------------
    protected $dates = ['deleted_at'];
    //? $dates -> is used to specify which attributes should be treated as date instances.

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
            'deleted_at' => 'datetime',
        ];
    }
    //? casts() -> is used to define how attributes should be cast when accessed or set.

    //* ---------------------------------------- Relationships---------------------------------
    public function companies()
    {
        return $this->hasOne(Company::class, 'owner_id', 'id');
    }
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'applicant_id', 'id');
    }
    public function resumes()
    {
        return $this->hasMany(Resume::class, 'applicant_id', 'id');
    }
}
