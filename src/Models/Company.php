<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\JobVacancy;
use App\Models\JobApplication;
use App\Models\User;
class Company extends Model
{
    use HasFactory,SoftDeletes,HasUuids;
    //* --------------------------- UUID primary key settings ------------------------- */
    //! table name
    protected $table = 'companies';
    protected $keyType = 'string';
     public $incrementing = false;
    //* --------------------------- Mass assignable attributes ------------------------- */
    protected $fillable = [
        'name',
        'address',
        'industry',
        'website',
        'logoName',
        'logoUri',
        'email',
        'owner_id',
    ];
    //* ------------------------- The attributes that should be cast.------------------ */
    protected $dates = ['deleted_at'];
    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }
    //* ---------------------------------------- Relationships--------------------------------- */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class, 'company_id', 'id');
    }

    //? cascading soft deletes and force deletes for companies when user is deleted
    protected static function booted(): void
    {
     static::deleting(function (Company $company) {
         if (! $company->isForceDeleting()) {
             $company->companies()->get()->each->delete();
         }
     });

     static::forceDeleting(function (Company $company) {
         $company->companies()->withTrashed()->get()->each->forceDelete();
     });

     static::restoring(function (Company $company) {
         $company->companies()->onlyTrashed()->get()->each->restore();
     });
    }


    public function applications()
    {
        // Returns all job applications for this company 
        //there is no direct relationship between Company and JobApplication
        return $this->hasManyThrough(JobApplication::class, JobVacancy::class, 'company_id', 'job_vacancy_id', 'id', 'id');
    }


}
