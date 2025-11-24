<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class StudentsExtraOrdinaryCriteriaType extends Model
{
    protected $table = 'students_extraordinary_criteria_type';
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
        'type_title',
        'type_desc',
        'inserted_by',
        'inserted_date',
    ];
}
