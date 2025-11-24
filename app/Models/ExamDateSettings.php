<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class ExamDateSettings extends Model
{
    protected $table = 'exam_date_settings';
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
        'class',
        'start_date',
        'last_attd_date',
        'last_attd_entry_date',
        'hy_exam_date',
        'hy_mark_last_date',
        're_exam_hy_exam_date',
        're_exam_hy_mark_last_date',
        'annual_exam_date',
        'annual_mark_last_date',
        're_exam_annual_exam_date',
        're_exam_annual_mark_last_date',
        'int_mark_entry_date'
    ];
}