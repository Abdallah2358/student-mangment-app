<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    //
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function readSoraStart(): BelongsTo
    {
        return $this->belongsTo(Surah::class, 'read_sora_start_id');
    }

    public function readSoraEnd(): BelongsTo
    {
        return $this->belongsTo(Surah::class, 'read_sora_end_id');
    }

    public function hafzSoraStart(): BelongsTo
    {
        return $this->belongsTo(Surah::class, 'hafz_sora_start_id');
    }

    public function hafzSoraEnd(): BelongsTo
    {
        return $this->belongsTo(Surah::class, 'hafz_sora_end_id');
    }

    public function reviewNSoraStart(): BelongsTo
    {
        return $this->belongsTo(Surah::class, 'review_n_sora_start_id');
    }

    public function reviewNSoraEnd(): BelongsTo
    {
        return $this->belongsTo(Surah::class, 'review_n_sora_end_id');
    }

    public function reviewFSoraStart(): BelongsTo
    {
        return $this->belongsTo(Surah::class, 'review_f_sora_start_id');
    }

    public function reviewFSoraEnd(): BelongsTo
    {
        return $this->belongsTo(Surah::class, 'review_f_sora_end_id');
    }
}
