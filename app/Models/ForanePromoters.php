<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class ForanePromoters extends Model
{
    protected $table = 'forane_promoters';
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
        'forane_code',
        'unit_code',
        'name',
        'address',
        'mobile',
        'phone',
        'email',
        'status'
    ];
}