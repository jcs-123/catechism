<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class AttendanceNew extends Model
{
    protected $table = 'attendance_new';
    use HasFactory;
    public $timestamps = false;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'year',
        'class',
        'division',
        'unit_code',
        'student_code',
        'halfyearly_attendance',
        'annual_attendance',
        'updated_date',
        'updated_by'
    ];
}
