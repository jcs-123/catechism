<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class CatechismUnitDetails extends Model
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
        'unit_it',
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
        'state',
        'pincode',
        'phone',
        'fax',
        'mobile',
        'email',
        'unit_vicar',
        'contact_person',
        'mass_time',
        'cat_time',
        'remarks',
        'hm_sign',
        'vicar_sign',
        'logo',
        'motto',
        'status',
        'net_flag'
    ];
}