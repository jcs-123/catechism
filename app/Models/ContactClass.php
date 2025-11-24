<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class ContactClass extends Model
{
    protected $table = 'contact_class';
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
        'days',
        'attd_entry_last_date',
        'pass_percentage',
        'assignment',
        'test',
        'attendance',
        'internal_total',
        'written',
        'updated_date',
        'updated_by'
    ];
}
