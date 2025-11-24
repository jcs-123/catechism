<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class StudentTransferDetails extends Model
{
    protected $table = 'student_transfer_details';
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
        'student_id',
        'student_code',
        'student_name',
        'from_forane_code',
        'from_unit_code',
        'to_unit_code',
        'old_admno',
        'old_class',
        'admitted_class',
        'date_of_transfer',
        'transfer_year',
        'transfer_reason',
        'responsible_person',
        'relation_student',
        'character',
        'register_in_unit',
        'hard_copy_received',
        'details_transfered',
        'updated_by',
        'inserted_date',
        'updated_date'

    ];
}