<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobApplication;

class JobVacancy extends Model
{
    use HasFactory,SoftDeletes,HasUuids;
    //* --------------------------- UUID primary key settings ------------------------- */
    //! table name
    protected $table = 'job_vacancies';
    protected $keyType = 'string';
     public $incrementing = false;
    //* --------------------------- Mass assignable attributes ------------------------- */
    protected $fillable = [
        'title',
        'description',
        'location',
        'salary',
        'type',
        'viewCount',
        'company_id',
        'category_id',
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
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class, 'category_id', 'id');
    }
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'job_vacancy_id', 'id');
    }
}
