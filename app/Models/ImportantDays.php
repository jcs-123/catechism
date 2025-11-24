<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class ImportantDays extends Model
{
    protected $table = 'important_dates';
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
        'title',
        'start_date',
        'end_date',
        'updated_by',
        'updated_date'
    ];
}