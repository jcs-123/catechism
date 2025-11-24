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
use App\Models\FormAfields;
use App\Models\FormBfields;
use App\Models\FormCfields;
use App\Models\Districts;
use App\Models\CatechismUnitDetails;
use App\Models\PiousAssoc;
use App\Models\Jobs;
use App\Models\Qualifications;
use App\Models\Activities;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UnitVisitController extends Controller
{
    //
    public function select_unit_visit_inspector()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $foranes = Forane::select('forane_name', 'forane_code')->get();
        $designations = CatechismDesignations::select('designation', 'id')
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
            // print_r($designations);
            // exit;
        }
        return view('general.unit_visit.select_unit_visit_inspector', compact('designations', 'foranes', 'activity_list'));
    }
    public function form_a_creation()
    {
        $Sections = FormAfields::select('section', 'id')->groupBy('section')->get();
        $question = isset($_POST['question']) ? $_POST['question'] : '';
        $section = isset($_POST['section']) ? $_POST['section'] : '';
        $show_order = isset($_POST['order']) ? $_POST['order'] : '';
        if ($question != '') {
            $data = array(
                'question' => $question,
                'section' => $section,
                'show_order' => $show_order,
                'updated_date' => Carbon::now()->format('d-m-Y'),
                'inserted_date' => Carbon::now()->format('d-m-Y')
            );
            $forma_details = FormAfields::insert($data);
        }
        if (isset($forma_details)) {
            return redirect()->back()->with('success', 'Job details have been saved.');
        }
        $forma_data = [];
        $forma_data = FormAfields::select('*')
            ->get();
        return view('general.unit_visit.form_a_creation', compact('forma_data', 'Sections'));

    }
    public function form_b_creation()
    {
        $Sections = FormBfields::select('section', 'id')->groupBy('section')->get();
        $question = isset($_POST['question']) ? $_POST['question'] : '';
        $section = isset($_POST['section']) ? $_POST['section'] : '';
        $show_order = isset($_POST['order']) ? $_POST['order'] : '';
        if ($question != '') {
            $data = array(
                'question' => $question,
                'section' => $section,
                'show_order' => $show_order,
                'updated_date' => Carbon::now()->format('d-m-Y'),
                'inserted_date' => Carbon::now()->format('d-m-Y')
            );
            $formb_details = FormBfields::insert($data);
        }
        if (isset($formb_details)) {
            return redirect()->back()->with('success', 'Job details have been saved.');
        }
        $formb_data = [];
        $formb_data = FormBfields::select('*')
            ->get();
        return view('general.unit_visit.form_b_creation', compact('formb_data', 'Sections'));

    }
    public function form_C_creation()
    {
        $Sections = FormCfields::select('section', 'id')->groupBy('section')->get();
        $question = isset($_POST['question']) ? $_POST['question'] : '';
        $section = isset($_POST['section']) ? $_POST['section'] : '';
        $show_order = isset($_POST['order']) ? $_POST['order'] : '';
        if ($question != '') {
            $data = array(
                'question' => $question,
                'section' => $section,
                'show_order' => $show_order,
                'updated_date' => Carbon::now()->format('d-m-Y'),
                'inserted_date' => Carbon::now()->format('d-m-Y')
            );
            $formc_details = FormCfields::insert($data);
        }
        if (isset($formc_details)) {
            return redirect()->back()->with('success', 'Job details have been saved.');
        }
        $formc_data = [];
        $formc_data = FormCfields::select('*')
            ->get();
        return view('general.unit_visit.form_C_creation', compact('formc_data', 'Sections'));

    }
    public function reset_form_permission(Request $request)
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $reset_form = isset($_POST['reset_form']) ? $_POST['reset_form'] : '';
        $formresetDetails = [];
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $units = isset($_POST['units']) ? $_POST['units'] : '';

        // echo '<pre>';
        // print_r($_POST);
        // exit;
        if ($_POST) {
            $Validate = $request->validate([
                'forane' => 'required|max:255',
                'units' => 'required|max:255',
                'reset_form' => 'required|max:255'
            ]);
            // echo '<pre>';
            // print_r("hi");
            // exit;
            if ($Validate == True) {

            }
        }
        // echo '<pre>';
        // print_r($transferDetails);
        // exit;
        return view('general.unit_visit.reset_form_permission', compact(['foranes', 'formresetDetails']));

    }
    public function unit_visit_report(Request $request)
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();
        $academicYears = AcademicYear::select('*')->get();
        $transferDetails = [];
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $unit_type = isset($_POST['unit_type']) ? $_POST['unit_type'] : '';
        $units = isset($_POST['units']) ? $_POST['units'] : '';
        if ($units == '') {
            $units = isset($_POST['school']) ? $_POST['school'] : '';
        }

        // echo '<pre>';
        // print_r($_POST);
        // exit;
        if ($_POST) {
            $Validate = $request->validate([
                'forane' => 'required|max:255',
                'units' => 'required|max:255',
                'academic_year' => 'required|max:255'
            ]);
            if ($Validate == True) {

            }
            return view('general.unit_visit.unit_visit_report', compact(['academicYears', 'foranes', 'schools', 'transferDetails']));

        }
    }
    public function dairy_form_a_creation()
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $parishes = Parishes::select('parish_code', 'name')->get();
        $usertype = UserRole::select('user_role', 'code')->get();
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();
        $academicYears = AcademicYear::select('*')->get();
        $classes = ClassMaster::select('class')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        //$criterias = StudentsExtraOrdinaryCriteriaType::get();
        $students = '';
        // echo '<pre>';
        // print_r($criterias);
        // exit;
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $division = isset($_POST['division']) ? $_POST['division'] : '';
        $unit_type = isset($_POST['unit_type']) ? $_POST['unit_type'] : '';
        $students_code = isset($_POST['students_code']) ? $_POST['students_code'] : '';
        $units = isset($_POST['units']) ? $_POST['units'] : '';
        if ($units == '') {
            $units = isset($_POST['school']) ? $_POST['school'] : '';
        }
        if ($_POST) {
            $students = [];
            $students = Students::select('students.*');
            if ($units && $units != '') {
                $students->where('students.catechism_unit_code', $units);
            }
            if ($class && $class != '') {
                $students->where('students.class', $class);
            }
            if ($division && $division != '') {
                $students->where('students.division', $division);
            }

            $students = $students->get();
            $stud = isset($_POST['stud']) ? $_POST['stud'] : '';
            if ($stud != '') {
                foreach ($stud as $K => $stu) {
                    //     echo '<pre>';
                    //     print_r($stu);
                    //     exit;
                    $data = array(
                        'year' => $academic_yr,
                        'unit_code' => $units,
                        'class' => $class,
                        'student_code' => $stu['student_code'],
                        'halfyearly_attendance' => $stu['att_till_hlf_yr'],
                        'annual_attendance' => $stu['att_before_hlf_yr']

                    );

                    $exc_stud = AttendanceNew::insert($data);
                }
            }
            if (isset($exc_stud)) {
                return redirect()->back()->with('success', 'Criteria details have been saved.');
            }
        }
        return view('general.unit_visit.dairy_form_a_creation', compact(['academicYears', 'foranes', 'parishes', 'usertype', 'schools', 'classes', 'students', 'forane', 'academic_yr', 'division', 'class', 'units']));
    }
    public function dairy_form_b_creation()
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $parishes = Parishes::select('parish_code', 'name')->get();
        $usertype = UserRole::select('user_role', 'code')->get();
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();
        $academicYears = AcademicYear::select('*')->get();
        $classes = ClassMaster::select('class')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        //$criterias = StudentsExtraOrdinaryCriteriaType::get();
        $students = '';
        // echo '<pre>';
        // print_r($criterias);
        // exit;
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $division = isset($_POST['division']) ? $_POST['division'] : '';
        $unit_type = isset($_POST['unit_type']) ? $_POST['unit_type'] : '';
        $students_code = isset($_POST['students_code']) ? $_POST['students_code'] : '';
        $units = isset($_POST['units']) ? $_POST['units'] : '';
        if ($units == '') {
            $units = isset($_POST['school']) ? $_POST['school'] : '';
        }
        if ($_POST) {
            $students = [];
            $students = Students::select('students.*');
            if ($units && $units != '') {
                $students->where('students.catechism_unit_code', $units);
            }
            if ($class && $class != '') {
                $students->where('students.class', $class);
            }
            if ($division && $division != '') {
                $students->where('students.division', $division);
            }

            $students = $students->get();
            $stud = isset($_POST['stud']) ? $_POST['stud'] : '';
            if ($stud != '') {
                foreach ($stud as $K => $stu) {
                    //     echo '<pre>';
                    //     print_r($stu);
                    //     exit;
                    $data = array(
                        'year' => $academic_yr,
                        'unit_code' => $units,
                        'class' => $class,
                        'student_code' => $stu['student_code'],
                        'halfyearly_attendance' => $stu['att_till_hlf_yr'],
                        'annual_attendance' => $stu['att_before_hlf_yr']

                    );

                    $exc_stud = AttendanceNew::insert($data);
                }
            }
            if (isset($exc_stud)) {
                return redirect()->back()->with('success', 'Criteria details have been saved.');
            }
        }
        return view('general.unit_visit.dairy_form_b_creation', compact(['academicYears', 'foranes', 'parishes', 'usertype', 'schools', 'classes', 'students', 'forane', 'academic_yr', 'division', 'class', 'units']));
    }
    public function dairy_form_c_creation()
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $parishes = Parishes::select('parish_code', 'name')->get();
        $usertype = UserRole::select('user_role', 'code')->get();
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();
        $academicYears = AcademicYear::select('*')->get();
        $classes = ClassMaster::select('class')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        //$criterias = StudentsExtraOrdinaryCriteriaType::get();
        $students = '';
        // echo '<pre>';
        // print_r($criterias);
        // exit;
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $division = isset($_POST['division']) ? $_POST['division'] : '';
        $unit_type = isset($_POST['unit_type']) ? $_POST['unit_type'] : '';
        $students_code = isset($_POST['students_code']) ? $_POST['students_code'] : '';
        $units = isset($_POST['units']) ? $_POST['units'] : '';
        if ($units == '') {
            $units = isset($_POST['school']) ? $_POST['school'] : '';
        }
        if ($_POST) {
            $students = [];
            $students = Students::select('students.*');
            if ($units && $units != '') {
                $students->where('students.catechism_unit_code', $units);
            }
            if ($class && $class != '') {
                $students->where('students.class', $class);
            }
            if ($division && $division != '') {
                $students->where('students.division', $division);
            }

            $students = $students->get();
            $stud = isset($_POST['stud']) ? $_POST['stud'] : '';
            if ($stud != '') {
                foreach ($stud as $K => $stu) {
                    //     echo '<pre>';
                    //     print_r($stu);
                    //     exit;
                    $data = array(
                        'year' => $academic_yr,
                        'unit_code' => $units,
                        'class' => $class,
                        'student_code' => $stu['student_code'],
                        'halfyearly_attendance' => $stu['att_till_hlf_yr'],
                        'annual_attendance' => $stu['att_before_hlf_yr']

                    );

                    $exc_stud = AttendanceNew::insert($data);
                }
            }
            if (isset($exc_stud)) {
                return redirect()->back()->with('success', 'Criteria details have been saved.');
            }
        }
        return view('general.unit_visit.dairy_form_c_creation', compact(['academicYears', 'foranes', 'parishes', 'usertype', 'schools', 'classes', 'students', 'forane', 'academic_yr', 'division', 'class', 'units']));
    }

}