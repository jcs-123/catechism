<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Students extends Model
{
    protected $table = 'students';
    use HasFactory;
    public $timestamps = false;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'student_code',
        'diocese',
        'forane_code',
        'parish_code',
        'member_code',
        'catechish_unit_code',
        'catechish_forane_code',
        'catechish_parish_code'
    ];
}