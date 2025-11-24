<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class SchoolStudentsStatistics extends Model
{
    protected $table = 'school_students_statistics';
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
        'unit_code',
        'acd_year',
        'address',
        'phone',
        'pincode',
        'total_staff',
        'catechism_staff',
        'moral_staff',
        'cat_count',
        'mal_moral_count',
        'eng_moral_count',
        'total_count',
        'cat_total_count',
        'mal_moral_total_count',
        'eng_moral_total_count',
        'ctotal_count',
        'days_time',
        'updated_by',
        'inserted_date',
        'updated_date'
    ];
}