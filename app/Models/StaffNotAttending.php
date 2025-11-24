<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class StaffNotAttending extends Model
{
    protected $table = 'staff_notattending';
    use HasFactory;
    public $timestamps = false;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'year',
        'staff_id',
        'staff_code',
        'staff_name',
        'unit_code',
        'start_date',
        'end_date',
        'updated_by',
        'inserted_date',
        'updated_date'

    ];
}
