<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //
    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }
    
    /**
     * Get the teacher's name through user relation.
     */

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->user?->name,
        );
    }
}
