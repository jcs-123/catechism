<?php

namespace App\Http\Controllers;

use App\Models\CatechismUnitDetails;
use App\Models\common;
use App\Models\staffs;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data['cat_units'] = CatechismUnitDetails::pluck('unit_name', 'unit_code');
        $data['action_type'] = 'Load';
        $data['unit_code'] = '';
        if ($request->unit_code) {
            $data['unit_code'] = $request->unit_code;
            $data['active_staffs'] = staffs::select('staff_code', 't_status', 'staff_name')
                ->where('catechism_unit_code', '=', $request->unit_code)
                ->where('status', '1')->where('delete', '0')->orderBy('staff_name', 'ASC')->get();
            $data['distinct_class_divisions'] = common::get_distinct_class_division($request->unit_code);
            $data['action_type'] = 'Save';
        }
        return view('general.layouts.login-permission-settings', $data);
    }
}