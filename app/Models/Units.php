<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Units extends Model
{
    protected $table = 'catechism_unit_details';
    use HasFactory;
    public $timestamps = false;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'unit_id',
        'unit_code',
        'forane_unit_code',
        'forane_code',
        'parish_code',
        'unit_name',
        'unit_type',
        'unit_address',
        'place',
        'post',
        'district',
        'state'
    ];
}