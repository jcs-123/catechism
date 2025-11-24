<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class ClassPromotionCriteria extends Model
{
    protected $table = 'class_promotion_criteria';
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
        'criteria',
        'criteria_type',
        'half_yearly',
        'annual',
        'internal',
        'minimum_attendance',
        'inserted_by',
        'inserted_date'
    ];
}