<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class AcademicYear extends Model
{
    protected $table = 'academic_year';
    use HasFactory;
    public $timestamps = false;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'academic_year',
        'acc_syllabus',
        'extra_attendance_hm_ct',
        'extra_attendance_vicar_ct',
        'extra_attendance_dbclc_ct',
        'commom_holidays',
        'no_of_days',
        'status',
        'extra_attd'
    ];
}
