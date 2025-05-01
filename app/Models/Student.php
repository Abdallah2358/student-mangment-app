<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Enums\{SexEnum, GuardianRelationEnum, GraduationStatusEnum};

class Student extends Model
{
    protected $casts = [
        'sex' => SexEnum::class,
        'guardian_relation' => GuardianRelationEnum::class,
        'status' => GraduationStatusEnum::class,
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
