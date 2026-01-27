<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use APP\Models\JobApplication;

class Resume extends Model
{
    use HasFactory,SoftDeletes,HasUuids;
    //* --------------------------- UUID primary key settings ------------------------- */
    //!table name
    protected $table = 'resumes';
    protected $keyType = 'string';

     public $incrementing = false;

     //* --------------------------- Mass assignable attributes ------------------------- */
    protected $fillable = [
        'fileName',
        'fileUri',
        'contactDetails',
        'summary',
        'skills',
        'experience',
        'education',
        'applicant_id',
    ];
    //* ------------------------- The attributes that should be cast.------------------
    protected $dates = ['deleted_at'];
    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];  
    }
    //* ---------------------------------------- Relationships--------------------------------- */
    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id', 'id');
    }
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'resume_id', 'id');
    }

}
