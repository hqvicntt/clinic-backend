<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $fillable = ['appointment_id', 'diagnosis', 'doctor_notes'];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'appointment_medicine', 'appointment_id', 'medicine_id', 'appointment_id')
            ->withPivot('dosage')
            ->withTimestamps();
    }
}
