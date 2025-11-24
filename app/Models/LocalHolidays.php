<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class LocalHolidays extends Model
{
    protected $table = 'local_holidays';
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
        'days',
        'no_of_days',
        'updated_by',
        'updated_date'
    ];
}