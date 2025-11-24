<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class InternalMarksCriteria extends Model
{
    protected $table = 'internal_marks_criteria';
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
        'unit_code',
        'class',
        'criteria',
        'criteria_type',
        'criteria_marks',
        'total_marks',
        'inserted_by',
        'inserted_date'
    ];
}