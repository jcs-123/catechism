<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class TotalWorkingDays extends Model
{
    protected $table = 'total_working_days';
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
        'class',
        'total_working_days',
        'inserted_by',
        'inserted_date',
    ];
}
