<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    protected $fillable = ['specialty_id', 'name', 'avatar', 'schedule', 'is_active'];

    // Relationship (BelongsTo)
    public function specialty(): BelongsTo
    {
        return $this->belongsTo(Specialty::class);
    }

    // Relationship (HasMany)
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
