<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class CatechismAuthorityMembers extends Model
{
    protected $table = 'catechism_authority_members';
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
        'member_id',
        'authority_id',
        'category',
        'unit_code',
        'staff_code',
        'member_name',
        'gender',
        'religious_laity',
        'designation',
        'mobile_no',
        'selected_date',
        'end_date',
        'status',
        'inserted_date',
        'updated_date',
        'updated_by'
    ];
}