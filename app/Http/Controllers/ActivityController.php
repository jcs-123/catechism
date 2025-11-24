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
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
    //
    public function activity_list()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $activities_for = Activities::select('activity_for')->groupBy('activity_for')
            ->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $activity_for = isset($_POST['activity_for']) ? $_POST['activity_for'] : '';
        $academicYears = AcademicYear::select('*')->get();
        $activity_list = '';
        if (isset($activity_for)) {

            $activity_list = Activities::select('*')
                ->where('education_year', $academic_yr)
                ->where('activity_for', $activity_for)
                ->get();
            // echo '<pre>';
            // print_r($activity_for);
            // exit;
        }
        return view('general.activities.activity_list', compact('academicYears', 'activities_for', 'activity_list'));
    }
    public function activity_creation(Request $request)
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $activities_for = Activities::select('activity_for')->groupBy('activity_for')->get();
        $activities_type = Activities::select('activity_type')->groupBy('activity_type')->get();
        $academicYears = AcademicYear::select('*')->get();

        $activity_no = isset($_POST['activity_no']) ? $_POST['activity_no'] : '';
        $certi_date = isset($_POST['certificate_date']) ? $_POST['certificate_date'] : '';
        $activity_name = isset($_POST['activity_name']) ? $_POST['activity_name'] : '';
        $certificate_name = isset($_POST['certificate_name']) ? $_POST['certificate_name'] : '';
        $activity_topic = isset($_POST['activity_topic']) ? $_POST['activity_topic'] : '';
        $activity_for = isset($_POST['activity_for']) ? $_POST['activity_for'] : '';
        $activity_type = isset($_POST['activity_type']) ? $_POST['activity_type'] : '';
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $resident_seat = isset($_POST['resident_seat']) ? $_POST['resident_seat'] : '';
        $venue = isset($_POST['venue']) ? $_POST['venue'] : '';
        $activity_dates = isset($_POST['activity_dates']) ? $_POST['activity_dates'] : '';
        $acti_duration = isset($_POST['activity_duration']) ? $_POST['activity_duration'] : '';
        $hr_day = isset($_POST['hr_day']) ? $_POST['hr_day'] : '';
        $bishop_sign = isset($_POST['bishop_sign']) ? $_POST['bishop_sign'] : '';
        $activity_summary = isset($_POST['activity_summary']) ? $_POST['activity_summary'] : '';
        $activity_duration = implode(' ', [$acti_duration, $hr_day]);

        if ($_POST) {
            $Validate = $request->validate([
                'activity_name' => 'required|max:255',
                'activity_for' => 'required|max:255',
                'activity_type' => 'required|max:255',
                'resident_seat' => 'required|max:255',
                'academic_year' => 'required',
                'venue' => 'required|max:255',
                'activity_dates' => 'required|max:255',
                'activity_duration' => 'required|max:255',
                'bishop_sign' => 'required|max:255',

            ]);

            $activity_dates_array = explode(',', $request->input('activity_dates'));
            $formatted_dates = array_map(function ($date) {
                return Carbon::parse(trim($date))->format('d-m-y');
            }, $activity_dates_array);
            $formatted_dates_string = implode(', ', $formatted_dates);

            $certificate_date = Carbon::parse($certi_date)->format('d-m-y');
            $activity_creation = Activities::create([
                'activity_no' => $request->input('activity_no'),
                'certificate_name' => $request->input('certificate_name'),
                'certificate_date' => $certificate_date,
                'activity_name' => $request->input('activity_name'),
                'activity_summary' => $request->input('activity_summary'),
                'activity_for' => $request->input('activity_for'),
                'activity_type' => $request->input('activity_type'),
                'resident_seat' => $request->input('resident_seat'),
                'academic_yr' => $request->input('academic_yr'),
                'venue' => $request->input('venue'),
                'activity_dates' => $formatted_dates_string, // Save formatted dates
                'activity_duration' => $activity_duration,
                'bishop_sign' => $request->input('bishop_sign'),
            ]);

        }
        if (isset($activity_creation)) {

            return redirect()->back()->with('success', 'Activity Created successfully!');

        }
        return view('general.activities.activity_creation', compact('academicYears', 'activities_for', 'activities_type'));
    }

}
