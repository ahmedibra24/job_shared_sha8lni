<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\JobVacancy;
use App\Models\User;
use App\Models\Resume;

class JobApplication extends Model
{
    use HasFactory,SoftDeletes,HasUuids;
    //* --------------------------- UUID primary key settings ------------------------- */
    //! table name
    protected $table = 'job_applications';
    protected $keyType = 'string';
     public $incrementing = false;
    //* --------------------------- Mass assignable attributes ------------------------- */
    protected $fillable = [
        'status',
        'aiGeneratedScore',
        'aiGeneratedFeedback',
        'job_vacancy_id',
        'resume_id',
        'applicant_id',
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
    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id', 'id');
    }
    public function resume()
    {
        return $this->belongsTo(Resume::class, 'resume_id', 'id');
    }
    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id', 'id');
    }


}
