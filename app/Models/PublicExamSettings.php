<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicExamSettings extends Model
{
    protected $table = 'public_exam_settings';
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
        'category',
        'qualification',
        'show_order',
        'inserted_by',
        'updated_date',
        'status'
    ];
}
