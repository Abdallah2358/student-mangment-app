<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Enums\{GenderEnum, GuardianRelationEnum, GraduationStatusEnum};

class Student extends Model
{
    protected $casts = [
        'gender' => GenderEnum::class,
        'guardian_relation' => GuardianRelationEnum::class,
        'status' => GraduationStatusEnum::class,
        'birth_date' => 'date',
        'enrollment_date' => 'date',
    ];
    //
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_student');
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
