<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\JobVacancy;

class JobCategory extends Model
{
    use HasFactory,SoftDeletes,HasUuids;
    //* --------------------------- UUID primary key settings ------------------------- */
    //! table name
    protected $table = 'job_categories';
    protected $keyType = 'string';
     public $incrementing = false;
    //* --------------------------- Mass assignable attributes ------------------------- */
    protected $fillable = [
        'name',
        'description',
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
    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class, 'category_id', 'id');
    }

}
