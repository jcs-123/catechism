<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class ExamSettings extends Model
{
    protected $table = 'exam_settings';
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
        'academic_year',
        'exam_type_id',
        'class',
        'min_marks',
        'total_min_marks',
        'max_marks',
        'min_attendance'
    ];
}