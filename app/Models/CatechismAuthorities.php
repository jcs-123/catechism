<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class CatechismAuthorities extends Model
{
    protected $table = 'catechism_authorities';
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
        'authority_name',
        'duration',
        'unit_entry',
        'status',
        'inserted_date',
        'updated_date',
        'updated_by'
    ];
}