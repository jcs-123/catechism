<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Divisions extends Model
{
    protected $table = 'division_master';
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
        'class',
        'divisions',
        'unit_code',
        'show_order',
        'status',
        'net_flag',
        'inserted_date',
        'updated_date',
        'updated_by'
    ];
}