<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class StudentsExtraAttendance extends Model
{
    protected $table = 'students_extra_attendance';
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
        'unit_code',
        'class',
        'division',
        'student_code',
        'attendance',
        'extra_attendance_hm',
        'extra_attendance_vicar',
        'extra_attendance_dbclc',
        'total_attendance'
    ];
}