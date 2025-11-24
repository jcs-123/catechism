<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class StaffTransferDetails extends Model
{
    protected $table = 'staff_transfer_details';
    use HasFactory;
    public $timestamps = false;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transfer_id',
        'transfer_code',
        'staff_id',
        'staff_code',
        'staff_name',
        'from_forane_code',
        'from_unit_code',
        'to_unit_code',
        'date_of_transfer',
        'transfer_year',
        'transfer_reason',
        'register_in_unit',
        'hard_copy_received',
        'updated_by',
        'inserted_date',
        'updated_date'

    ];
}
