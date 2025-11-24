<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class common extends Model
{
    //get gender wise member count
    public static function get_distinct_class_division($unit_code)
    {

        $classDivision = \DB::table('students')
            ->select(
                'students.class',
                'students.division'
            )
            ->join('class_master', 'students.class', '=', 'class_master.class')
            ->where('students.catechism_unit_code', '=', $unit_code)->where('class_master.display', '1')
            ->where('students.status', '1')
            ->orderBy('class_master.show_order', 'ASC')->groupBy('students.class')->get();
        foreach ($classDivision as $divn => $each) {
            $class_login_exist = \DB::table('class_login')
                ->select(
                    'id',
                    'class',
                    'division',
                    'staff_code',
                    'username',
                    'password_decrypted',
                    'attend_perm',
                    'mark_perm',
                    'internal_perm'
                )
                ->where('unit_code', '=', $unit_code)->where('class', '=', $each->class)
                ->where('division', '=', $each->division)->get();
            $classDivision[$divn]->class_login_exist = $class_login_exist[0] ?? [];
        }

        return $classDivision;
    }
}