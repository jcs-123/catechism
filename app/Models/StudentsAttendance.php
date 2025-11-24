<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class StudentsAttendance extends Model
{
    protected $table = 'students_attendance';
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
        'attendance'
    ];
}