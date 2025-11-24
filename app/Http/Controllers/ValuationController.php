<?php

namespace App\Http\Controllers;
use App\Models\AcademicYear;
use App\Models\StudentsExtraOrdinaryCriteriaType;
use App\Models\Students;
use App\Models\Forane;
use App\Models\staffs;
use App\Models\Units;
use App\Models\Divisions;
use App\Models\Parishes;
use App\Models\Users;
use App\Models\UserRole;
use App\Models\SchoolStudentsStatistics;
use App\Models\FamilyUnits;
use App\Models\CatechismDesignations;
use App\Models\ExtraOrdinaryStudents;
use App\Models\StudentsExtraAttendance;
use App\Models\ClassMaster;
use App\Models\AttendanceNew;
use App\Models\StudentsAttendance;
use App\Models\StaffNotAttending;
use App\Models\StudentTransferDetails;
use App\Models\StaffTransferDetails;
use App\Models\HealthStatus;
use App\Models\PiousAssociation;
use App\Models\JobCategories;
use App\Models\Districts;
use App\Models\CatechismUnitDetails;
use App\Models\PiousAssoc;
use App\Models\Jobs;
use App\Models\Qualifications;
use App\Models\Activities;
use App\Models\ForaneGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ValuationController extends Controller
{
    public function grouped_forane_list()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $academicYears = AcademicYear::select('*')->get();
        $classes = ClassMaster::select('class')->get();

        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $activity_list = '';
        if (isset($class)) {

            $forane_list = ForaneGroup::select('*')
                ->where('academic_year', $academic_yr)
                ->where('class', $class)
                ->first()->toArray();

            $group_names = explode(',', $forane_list['group_name']);
            $group_codes = explode(',', $forane_list['group_code']);

            $grouped_data = [];
            foreach ($group_names as $k => $name) {
                $codes = explode('|', $group_codes[$k]);
                $grouped_data[$name] = $codes;
            }
            // echo '<pre>';
            // print_r($grouped_data);
            // exit;
        }
        return view('general.valuation.grouped_forane_list', compact('academicYears', 'classes', 'grouped_data'));
    }
}
