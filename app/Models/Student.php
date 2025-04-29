<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    //
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_student');
    }
}
