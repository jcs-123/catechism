<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Activities extends Model
{
    protected $table = 'activities';
    use HasFactory;
    public $timestamps = false;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'activity_name',
        'certificate_name',
        'certificate_date',
        'activity_no',
        'activity_topic',
        'unit_code',
        'education_year',
        'activity_date',
        'activity_duration',
        'venue',
        'activity_for',
        'activity_type',
        'bishop_sign',
        'resident_seat',
        'seats_available',
        'activity_summary',
        'status',
        'inserted_date',
        'updated_date',
        'updated_by'
    ];
}