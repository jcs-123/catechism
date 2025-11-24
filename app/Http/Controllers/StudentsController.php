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
use App\Models\StudentTransferDetails;
use App\Models\HealthStatus;
use App\Models\PiousAssociation;
use App\Models\Districts;
use App\Models\CatechismUnitDetails;
use App\Models\PiousAssoc;
use App\Models\StudentNotAttending;
use App\Models\Months;


use Illuminate\Http\Request;

class StudentsController extends Controller
{

    public function add_excellence_criteria()
    {
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $desc = isset($_POST['desc']) ? $_POST['desc'] : '';
        $no_of_criteria = isset($_POST['no_of_criteria']) ? $_POST['no_of_criteria'] : '';
        $academicYears = AcademicYear::select('academic_year')->get()->last()->toArray();
        if ($title != '') {
            // $criteriaString = implode(',', $criteria);
            // $typeString = implode(',', $type);
            foreach ($title as $K => $row) {
                $data = array(
                    'academic_year' => $academic_yr,
                    'type_title' => $row,
                    'type_desc' => $desc[$K]
                );
                $class_promotion_criteria = StudentsExtraOrdinaryCriteriaType::insert($data);
            }
        }
        if (isset($class_promotion_criteria)) {
            return redirect()->back()->with('success', 'Criteria details have been saved.');
        }
        return view('general.add_excellence_criteria', compact(['academicYears', 'no_of_criteria']));
    }
    public function excellence_criteria_list()
    {
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $academicYears = StudentsExtraOrdinaryCriteriaType::groupBy('academic_year')
            ->pluck('academic_year', 'id');
        $criterias = [];

        if ($academic_yr != '') {
            $criterias = StudentsExtraOrdinaryCriteriaType::where('academic_year', $academic_yr)->get();
            // echo '<pre>';
            // print_r($criterias);
            // exit;
        }
        return view('general.excellence_criteria_list', compact(['academicYears', 'criterias']));

    }
    public function add_excellence_students()
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $parishes = Parishes::select('parish_code', 'name')->get();
        $usertype = UserRole::select('user_role', 'code')->get();
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();
        $academicYears = AcademicYear::select('*')->get();
        $classes = ClassMaster::select('class')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $criterias = StudentsExtraOrdinaryCriteriaType::get();

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
            $students = Students::
                select('*');
            // if ($academic_yr && $academic_yr != '') {
            //     $students->where('academic_year', $academic_yr);
            // }
            if ($units && $units != '') {
                $students->where('catechism_unit_code', $units);
            }
            if ($class && $class != '') {
                $students->where('class', $class);
            }
            if ($division && $division != '') {
                $students->where('division', $division);
            }

            $students = $students->get();
            // $students_string = $exce_students['student_code'];
            // $studentCodes = array_map('trim', explode(',', $students_string));
            // $students = Students::whereIn('student_code', $studentCodes)
            //     ->pluck('student_name', 'student_code');

            //   $school = isset($_POST['units']) ? $_POST['school'] : '';
            $criteria = isset($_POST['criteria']) ? $_POST['criteria'] : '';
            $students_code = isset($_POST['exce_stud']) ? $_POST['exce_stud'] : '';
            // echo '<pre>';
            // print_r($_POST);
            // exit;
            if ($criteria != '' && $students_code != '') {
                // $criteriaString = implode(',', $criteria);
                // $typeString = implode(',', $type);
                foreach ($students_code as $K => $row) {
                    $data = array(
                        'academic_year' => $academic_yr,
                        'unit_code' => $units,
                        'class' => $class,
                        'student_code' => $row,
                        'excellence_type_id' => $criteria,

                    );
                    $exc_stud = ExtraOrdinaryStudents::insert($data);
                }
            }
            if (isset($exc_stud)) {
                return redirect()->back()->with('success', 'Criteria details have been saved.');
            }
        }
        return view('general.add_excellence_students', compact(['academicYears', 'foranes', 'parishes', 'usertype', 'schools', 'classes', 'students', 'forane', 'academic_yr', 'division', 'class', 'units', 'criterias']));
    }

    public function excellence_students_list()
    {
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $academicYears = AcademicYear::select('academic_year')->get();
        $exord_students = [];
        if ($academic_yr != '') {
            $exord_students = ExtraOrdinaryStudents::leftJoin('students', 'students.student_id', '=', 'exord_students.student_id')
                ->leftJoin('catechism_unit_details', 'catechism_unit_details.unit_code', '=', 'exord_students.unit_code')
                ->leftJoin('students_extraordinary_criteria_type', 'students_extraordinary_criteria_type.id', '=', 'exord_students.excellence_type_id')
                ->select('exord_students.*', 'students.*', 'catechism_unit_details.unit_name', 'students_extraordinary_criteria_type.type_title')->where('exord_students.academic_year', $academic_yr)
                ->get();
            // echo '<pre>';
            // print_r($exord_students);
            // exit;
        }
        return view('general.excellence_students_list', compact(['academicYears', 'exord_students']));
    }
    //Students Management
    public function add_attendance()
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
        return view('general.students.add_attendance', compact(['academicYears', 'foranes', 'parishes', 'usertype', 'schools', 'classes', 'students', 'forane', 'academic_yr', 'division', 'class', 'units']));
    }
    public function delete_attendance()
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

        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $division = isset($_POST['division']) ? $_POST['division'] : '';
        $unit_type = isset($_POST['unit_type']) ? $_POST['unit_type'] : '';
        $dates = isset($_POST['dates']) ? $_POST['dates'] : '';
        $units = isset($_POST['units']) ? $_POST['units'] : '';
        $dateArray = array_map('trim', explode(',', $dates));

        if ($units == '') {
            $units = isset($_POST['school']) ? $_POST['school'] : '';
        }
        if ($_POST) {
            $students = [];
            foreach ($dateArray as $row) {
                $students = StudentsAttendance::select('*');
                if ($units && $units != '') {
                    $students->where('catechism_unit_code', $units);
                }
                if ($class && $class != '') {
                    $students->where('class', $class);
                }
                if ($division && $division != '') {
                    $students->where('division', $division);
                }
                if ($row && $row != '') {
                    $students->where('date', $row);
                }
                $students = $students->delete();


            }
            // echo '<pre>';
            // print_r($row);
            // exit;
            if (isset($students)) {
                return redirect()->back()->with('success', 'Attendance deleted Successfully.');
            }
        }
        return view('general.students.delete_attendance', compact(['academicYears', 'foranes', 'parishes', 'usertype', 'schools', 'classes', 'students', 'forane', 'academic_yr', 'division', 'class', 'units']));
    }
    public function emigrants(Request $request)
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
            // echo '<pre>';
            // print_r("hi");
            // exit;
            if ($Validate == True) {
                $transferDetails = StudentTransferDetails::leftJoin('catechism_unit_details as a', 'a.unit_code', '=', 'student_transfer_details.from_unit_code')
                    ->leftJoin('catechism_unit_details as b', 'b.unit_code', '=', 'student_transfer_details.to_unit_code')
                    ->select('student_transfer_details.*', 'a.unit_name as transfered_from', 'b.unit_name as transfered_to')
                    ->
                    where('transfer_year', $academic_yr)
                    ->where('from_forane_code', $forane)
                    ->where('from_unit_code', $units)
                    ->get();
            }
        }
        // echo '<pre>';
        // print_r($transferDetails);
        // exit;
        return view('general.students.emigrants', compact(['academicYears', 'foranes', 'schools', 'transferDetails']));

    }
    public function immigrants(Request $request)
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
            // echo '<pre>';
            // print_r("hi");
            // exit;
            if ($Validate == True) {
                $transferDetails = StudentTransferDetails::leftJoin('catechism_unit_details as a', 'a.unit_code', '=', 'student_transfer_details.from_unit_code')
                    ->leftJoin('catechism_unit_details as b', 'b.unit_code', '=', 'student_transfer_details.to_unit_code')
                    ->select('student_transfer_details.*', 'a.unit_name as transfered_from', 'b.unit_name as transfered_to')
                    ->
                    where('transfer_year', $academic_yr)
                    ->where('to_unit_code', $units)
                    ->get();
            }
        }
        // echo '<pre>';
        // print_r($transferDetails);
        // exit;
        return view('general.students.immigrants', compact(['academicYears', 'foranes', 'schools', 'transferDetails']));

    }
    public function extra_attendance()
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
        // print_r($_POST);
        // exit;
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $division = isset($_POST['division']) ? $_POST['division'] : '';
        $unit_type = isset($_POST['unit_type']) ? $_POST['unit_type'] : '';
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
            $student_code = [];
            if ($stud != '') {
                foreach ($stud as $K => $stu) {
                    //$student_code = implode(',', $stu['student_code']);
                    $students_code[] = $stu['student_code'];
                    $extra_attd_hm[] = $stu['extra_attd_hm'];
                    $extra_attd_vicar[] = $stu['extra_attd_vicar'];
                    $extra_attd_dbclc[] = $stu['extra_attd_dbclc'];
                }
                $students_code = array_map(function ($value) {
                    return $value === null || $value === '' ? '0' : $value;
                }, $students_code);

                $extra_attd_hm = array_map(function ($value) {
                    return $value === null || $value === '' ? '0' : $value;
                }, $extra_attd_hm);

                $extra_attd_vicar = array_map(function ($value) {
                    return $value === null || $value === '' ? '0' : $value;
                }, $extra_attd_vicar);

                $extra_attd_dbclc = array_map(function ($value) {
                    return $value === null || $value === '' ? '0' : $value;
                }, $extra_attd_dbclc);

                $student_code = implode(',', $students_code);
                $extra_attdnce_hm = implode(',', $extra_attd_hm);
                $extra_attdnce_vicar = implode(',', $extra_attd_vicar);
                $extra_attdnce_dbclc = implode(',', $extra_attd_dbclc);

                $data = array(
                    'academic_year' => $academic_yr,
                    'student_code' => $student_code,
                    'extra_attendance_hm' => $extra_attdnce_hm,
                    'extra_attendance_vicar' => $extra_attdnce_vicar,
                    'extra_attendance_dbclc' => $extra_attdnce_dbclc,
                    'class' => $class,
                    // 'class' => $class,
                    // 'class' => $class,
                    'unit_code' => $units
                );

                $extra_attnd = StudentsExtraAttendance::insert($data);


            }
            // echo '<pre>';
            // print_r($_POST);
            // exit;
            if (isset($extra_attnd)) {
                return redirect()->back()->with('success', 'Criteria details have been saved.');
            }
        }
        return view('general.students.extra_attendance', compact(['academicYears', 'foranes', 'parishes', 'usertype', 'schools', 'classes', 'students', 'forane', 'academic_yr', 'division', 'class', 'units']));
    }
    public function student_search_report()
    {
        // Fetch other necessary data
        $forane_code = isset($_POST['forane_code']) ? $_POST['forane_code'] : '';
        $unit_code = isset($_POST['unit_code']) ? $_POST['unit_code'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $division = isset($_POST['division']) ? $_POST['division'] : '';
        $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
        $admn_no = isset($_POST['gender']) ? $_POST['admn_no'] : '';
        $student_code = isset($_POST['student_code']) ? $_POST['student_code'] : '';
        $foranes = Forane::select('forane_name', 'forane_code')->get();
        $classes = ClassMaster::orderBy('show_order', 'asc')->get();

        $students = Students::query();

        if (isset($_POST['forane_code']) ? $_POST['forane_code'] : '') {
            $students->where('forane_code', $_POST['forane_code']);
        }
        if (isset($_POST['unit_code']) ? $_POST['unit_code'] : '') {
            $students->where('catechism_unit_code', $_POST['unit_code']);
        }

        if (isset($_POST['class']) ? $_POST['class'] : '') {
            $students->where('class', $_POST['class']);
        }

        if (isset($_POST['division']) ? $_POST['division'] : '') {
            $students->where('division', $_POST['division']);
        }

        if (isset($_POST['gender']) ? $_POST['gender'] : '') {
            $students->where('sex', $_POST['gender']);
        }
        if (isset($_POST['admn_no']) ? $_POST['admn_no'] : '') {
            $students->where('admn_no', $_POST['admn_no']);
        }

        if (isset($_POST['student_code']) ? $_POST['student_code'] : '') {
            $students->where('student_code', $_POST['student_code']);
        }

        if (isset($_POST['student_name']) ? $_POST['student_name'] : '') {
            $students->where('student_name', 'like', '%' . $_POST['student_name'] . '%');
        }
        $students = $students->get();
        // Return the view with students data
        return view('general.students.student_search_report', compact('foranes', 'classes'));
    }
    public function attendance_list()
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();
        $academicYears = AcademicYear::select('*')->get();
        $classes = ClassMaster::select('class')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $students = '';
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $division = isset($_POST['division']) ? $_POST['division'] : '';
        $unit_type = isset($_POST['unit_type']) ? $_POST['unit_type'] : '';
        $dates = isset($_POST['dates']) ? $_POST['dates'] : '';
        $units = isset($_POST['units']) ? $_POST['units'] : '';
        if ($units == '') {
            $units = isset($_POST['school']) ? $_POST['school'] : '';
        }
        $students_attendance = [];
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        if (isset($forane) && $forane != '') {
            $students = StudentsAttendance::select('*');
            if ($units && $units != '') {
                $students->where('unit_code', $units);
            }
            if ($class && $class != '') {
                $students->where('class', $class);
            }
            if ($division && $division != '') {
                $students->where('division', $division);
            }
            if ($academic_yr && $academic_yr != '') {
                $students->where('year', $academic_yr);
            }
            $attendances = $students->get();
            $studentAttendance = [];
            foreach ($attendances as $key => $attendance) {
                $students = array_map('trim', explode(',', $attendance->attendance));

                foreach ($students as $studentId) {
                    if (!isset($studentAttendance[$studentId])) {
                        $studentAttendance[$studentId] = [];
                    }
                    $studentAttendance[$studentId][$attendance->date] = true;
                }
            }
            $finalAttendance = [];

            foreach ($studentAttendance as $studentId => $dates) {
                $students = Students::where('student_code', $studentId);
                $student_name = $students->first('student_name');

                $finalAttendance[$student_name['student_name']] = count($dates);
                // echo '<pre>';
                // print_r($finalAttendance);
                // exit;
            }



        }
        return view('general.students.attendance_list', compact([
            'academicYears',
            'foranes',
            'schools',
            'classes',
            'finalAttendance'
        ]));
    }
    public function student_list_report()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $forane_code = isset($_POST['forane']) ? $_POST['forane'] : '';
        $units = isset($_POST['units']) ? $_POST['units'] : '';
        if ($units == '') {
            $units = isset($_POST['school']) ? $_POST['school'] : '';
        }
        // $unit_code = isset($_POST['units']) ? $_POST['units'] : '';
        $class = isset($_POST['stud_class']) ? $_POST['stud_class'] : '';
        $division = isset($_POST['class_division']) ? $_POST['class_division'] : '';
        $genders = isset($_POST['genders']) ? $_POST['genders'] : '';
        $health_statuses = isset($_POST['health_statuses']) ? $_POST['health_statuses'] : '';
        $dob_from = isset($_POST['dob_from']) ? $_POST['dob_from'] : '';
        $dob_to = isset($_POST['dob_to']) ? $_POST['dob_to'] : '';
        $status = isset($_POST['stat']) ? $_POST['stat'] : '';
        $age_from = isset($_POST['age_from']) ? $_POST['age_from'] : '';
        $age_to = isset($_POST['age_to']) ? $_POST['age_to'] : '';
        $contact_class = isset($_POST['cont_class']) ? $_POST['cont_class'] : '';
        $denomination = isset($_POST['denom']) ? $_POST['denom'] : '';
        $adm_no = isset($_POST['adm_no']) ? $_POST['adm_no'] : '';
        $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
        $student_diocese = isset($_POST['stud_dioc']) ? $_POST['stud_dioc'] : '';
        $house_name = isset($_POST['house_name']) ? $_POST['house_name'] : '';
        $permenant_address = isset($_POST['perm_addr']) ? $_POST['perm_addr'] : '';
        $class_medium = isset($_POST['class_medium']) ? $_POST['class_medium'] : '';
        $member_code = isset($_POST['mem_code']) ? $_POST['mem_code'] : '';
        $date_of_birth = isset($_POST['date_of_birth']) ? $_POST['date_of_birth'] : '';
        $student_forane = isset($_POST['forane_code']) ? $_POST['forane_code'] : '';
        $post = isset($_POST['post']) ? $_POST['post'] : '';
        $pres_addr = isset($_POST['present_address']) ? $_POST['present_address'] : '';
        $exam_unit = isset($_POST['exam_unit']) ? $_POST['exam_unit'] : '';
        $stud_name = isset($_POST['student_name']) ? $_POST['student_name'] : '';
        $curr_age = isset($_POST['age']) ? $_POST['age'] : '';
        $stud_parish = isset($_POST['parish_code']) ? $_POST['parish_code'] : '';
        $place = isset($_POST['place']) ? $_POST['place'] : '';
        $phone_num = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';
        $stud_class = isset($_POST['class']) ? $_POST['class'] : '';
        $baptismal_date = isset($_POST['BaptDate']) ? $_POST['BaptDate'] : '';
        $cate_forane = isset($_POST['catechism_forane_code']) ? $_POST['catechism_forane_code'] : '';
        $pincode = isset($_POST['pin_code']) ? $_POST['pin_code'] : '';
        $mob_num = isset($_POST['mobile']) ? $_POST['mobile'] : '';
        $div = isset($_POST['division']) ? $_POST['division'] : '';
        $father = isset($_POST['father_name']) ? $_POST['father_name'] : '';
        $baptism_name = isset($_POST['BaptName']) ? $_POST['BaptName'] : '';
        $cate_unit = isset($_POST['catechism_unit_code']) ? $_POST['catechism_unit_code'] : '';
        $district = isset($_POST['district']) ? $_POST['district'] : '';
        $email = isset($_POST['emailid']) ? $_POST['emailid'] : '';
        $reg_no = isset($_POST['reg_no']) ? $_POST['reg_no'] : '';
        $mother = isset($_POST['mother_name']) ? $_POST['mother_name'] : '';
        $identif_mark = isset($_POST['identification_mark']) ? $_POST['identification_mark'] : '';
        $cate_type = isset($_POST['catechism_type']) ? $_POST['catechism_type'] : '';
        $join_date = isset($_POST['join_date']) ? $_POST['join_date'] : '';
        $pious_assoc = isset($_POST['pious']) ? $_POST['pious'] : '';
        $fam_unit = isset($_POST['family_unit_id']) ? $_POST['family_unit_id'] : '';
        $health_sta = isset($_POST['health_status']) ? $_POST['health_status'] : '';
        $check_status = isset($_POST['status']) ? $_POST['status'] : '';
        $contact_class = isset($_POST['contact_class']) ? $_POST['contact_class'] : '';
        $division_count = isset($_POST['division_count']) ? $_POST['division_count'] : '';
        $denom = isset($_POST['denomination']) ? $_POST['denomination'] : '';
        $sign = isset($_POST['sign']) ? $_POST['sign'] : '';
        $forane_name = Forane::select('forane_name')->where('forane_code', $forane_code)->first();
        $unit_name = Units::select('unit_name')->where('unit_code', $units)->first();
        $academicYear = AcademicYear::select('academic_year')->get()->last()->toArray();
        $student_code = isset($_POST['student_code']) ? $_POST['student_code'] : '';
        $foranes = Forane::select('forane_name', 'forane_code')->get();
        $parishes = Parishes::select('parish_code', 'name')->get();
        $usertype = UserRole::select('user_role', 'code')->get();
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();
        $academicYears = AcademicYear::select('*')->get();
        $classes = ClassMaster::select('class')->get();
        $healthStatus = HealthStatus::where('status', '1')
            ->orderBy('order', 'asc')
            ->get();
        $pious_assoc = PiousAssociation::where('status', '1')
            ->get();
        $selectedhealthStatus = 'Healthy';
        $students = Students::query();

        if (isset($_POST['forane']) ? $_POST['forane'] : '') {
            $students->where('forane_code', $_POST['forane']);
        }
        if (isset($_POST['units']) ? $_POST['units'] : '') {
            $students->where('catechism_unit_code', $_POST['units']);
        }

        if (isset($_POST['stud_class']) ? $_POST['stud_class'] : '') {
            $students->where('class', $_POST['stud_class']);
        }

        if (isset($_POST['class_division']) ? $_POST['class_division'] : '') {
            $students->where('division', $_POST['class_division']);
        }

        if (isset($_POST['gender']) ? $_POST['gender'] : '') {
            $students->where('sex', $_POST['gender']);
        }
        if (isset($_POST['admn_no']) ? $_POST['admn_no'] : '') {
            $students->where('admn_no', $_POST['admn_no']);
        }

        if (isset($_POST['health_status']) ? $_POST['health_status'] : '') {
            $students->where('health_status', $_POST['health_status']);
        }
        if (isset($_POST['dob_from']) ? $_POST['dob_from'] : '') {
            $students->where('dob_from', $_POST['dob_from']);
        }
        if (isset($_POST['dob_to']) ? $_POST['dob_to'] : '') {
            $students->where('dob_to', $_POST['dob_to']);
        }
        if (isset($_POST['status']) ? $_POST['status'] : '') {
            $students->where('status', '1');
        }
        if (isset($_POST['age_from']) ? $_POST['age_from'] : '') {
            $students->where('age_from', $_POST['age_from']);
        }
        if (isset($_POST['age_to']) ? $_POST['age_to'] : '') {
            $students->where('age_to', $_POST['age_to']);
        }
        if (isset($_POST['cont_class']) ? $_POST['cont_class'] : '') {
            $students->where('contact_class', $_POST['cont_class']);
        }
        if (isset($_POST['denom']) ? $_POST['denom'] : '') {
            $students->where('denomination', $_POST['denom']);
        }
        // if (isset($_POST['student_name']) ? $_POST['student_name'] : '') {
        //     $students->where('student_name', 'like', '%' . $_POST['student_name'] . '%');
        // }
        $students = $students->get();
        // echo '<pre>';
        // print_r($students);
        // exit;
        $students_report = [];
        foreach ($students as $k => $row) {
            foreach ($_POST as $key => $data) {
                if ($data != '' && $data == 1) {
                    $students_report[$k][$key] = $row->{$key};
                }
            }
        }
        // echo '<pre>';
        // print_r($academicYears);
        // exit;
        return view('general.students.student_list_report', compact('foranes', 'parishes', 'students_report', 'usertype', 'schools', 'classes', 'healthStatus', 'selectedhealthStatus', 'classes', 'pious_assoc', 'forane_name', 'unit_name', 'academicYear'));
    }
    public function student_list_without_header()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $forane_code = isset($_POST['forane']) ? $_POST['forane'] : '';
        $units = isset($_POST['units']) ? $_POST['units'] : '';
        if ($units == '') {
            $units = isset($_POST['school']) ? $_POST['school'] : '';
        }
        // $unit_code = isset($_POST['units']) ? $_POST['units'] : '';
        $class = isset($_POST['stud_class']) ? $_POST['stud_class'] : '';
        $division = isset($_POST['class_division']) ? $_POST['class_division'] : '';
        $genders = isset($_POST['genders']) ? $_POST['genders'] : '';
        $health_statuses = isset($_POST['health_statuses']) ? $_POST['health_statuses'] : '';
        $dob_from = isset($_POST['dob_from']) ? $_POST['dob_from'] : '';
        $dob_to = isset($_POST['dob_to']) ? $_POST['dob_to'] : '';
        $status = isset($_POST['stat']) ? $_POST['stat'] : '';
        $age_from = isset($_POST['age_from']) ? $_POST['age_from'] : '';
        $age_to = isset($_POST['age_to']) ? $_POST['age_to'] : '';
        $contact_class = isset($_POST['cont_class']) ? $_POST['cont_class'] : '';
        $denomination = isset($_POST['denom']) ? $_POST['denom'] : '';
        $adm_no = isset($_POST['adm_no']) ? $_POST['adm_no'] : '';
        $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
        $student_diocese = isset($_POST['stud_dioc']) ? $_POST['stud_dioc'] : '';
        $house_name = isset($_POST['house_name']) ? $_POST['house_name'] : '';
        $permenant_address = isset($_POST['perm_addr']) ? $_POST['perm_addr'] : '';
        $class_medium = isset($_POST['class_medium']) ? $_POST['class_medium'] : '';
        $member_code = isset($_POST['mem_code']) ? $_POST['mem_code'] : '';
        $date_of_birth = isset($_POST['date_of_birth']) ? $_POST['date_of_birth'] : '';
        $student_forane = isset($_POST['forane_code']) ? $_POST['forane_code'] : '';
        $post = isset($_POST['post']) ? $_POST['post'] : '';
        $pres_addr = isset($_POST['present_address']) ? $_POST['present_address'] : '';
        $exam_unit = isset($_POST['exam_unit']) ? $_POST['exam_unit'] : '';
        $student_name = isset($_POST['student_name']) ? $_POST['student_name'] : '';
        $curr_age = isset($_POST['age']) ? $_POST['age'] : '';
        $stud_parish = isset($_POST['parish_code']) ? $_POST['parish_code'] : '';
        $place = isset($_POST['place']) ? $_POST['place'] : '';
        $phone_num = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';
        $stud_class = isset($_POST['class']) ? $_POST['class'] : '';
        $baptismal_date = isset($_POST['BaptDate']) ? $_POST['BaptDate'] : '';
        $cate_forane = isset($_POST['catechism_forane_code']) ? $_POST['catechism_forane_code'] : '';
        $pincode = isset($_POST['pin_code']) ? $_POST['pin_code'] : '';
        $mob_num = isset($_POST['mobile']) ? $_POST['mobile'] : '';
        $div = isset($_POST['division']) ? $_POST['division'] : '';
        $father = isset($_POST['father_name']) ? $_POST['father_name'] : '';
        $baptism_name = isset($_POST['BaptName']) ? $_POST['BaptName'] : '';
        $cate_unit = isset($_POST['catechism_unit_code']) ? $_POST['catechism_unit_code'] : '';
        $district = isset($_POST['district']) ? $_POST['district'] : '';
        $email = isset($_POST['emailid']) ? $_POST['emailid'] : '';
        $reg_no = isset($_POST['reg_no']) ? $_POST['reg_no'] : '';
        $mother = isset($_POST['mother_name']) ? $_POST['mother_name'] : '';
        $identif_mark = isset($_POST['identification_mark']) ? $_POST['identification_mark'] : '';
        $cate_type = isset($_POST['catechism_type']) ? $_POST['catechism_type'] : '';
        $join_date = isset($_POST['join_date']) ? $_POST['join_date'] : '';
        $pious_assoc = isset($_POST['pious']) ? $_POST['pious'] : '';
        $fam_unit = isset($_POST['family_unit_id']) ? $_POST['family_unit_id'] : '';
        $health_sta = isset($_POST['health_status']) ? $_POST['health_status'] : '';
        $check_status = isset($_POST['status']) ? $_POST['status'] : '';
        $contact_class = isset($_POST['contact_class']) ? $_POST['contact_class'] : '';
        $division_count = isset($_POST['division_count']) ? $_POST['division_count'] : '';
        $denom = isset($_POST['denomination']) ? $_POST['denomination'] : '';
        $sign = isset($_POST['sign']) ? $_POST['sign'] : '';
        $forane_name = Forane::select('forane_name')->where('forane_code', $forane_code)->first();
        $unit_name = Units::select('unit_name')->where('unit_code', $units)->first();
        $academicYear = AcademicYear::select('academic_year')->get()->last()->toArray();
        $student_code = isset($_POST['student_code']) ? $_POST['student_code'] : '';
        $foranes = Forane::select('forane_name', 'forane_code')->get();
        $parishes = Parishes::select('parish_code', 'name')->get();
        $usertype = UserRole::select('user_role', 'code')->get();
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();
        $academicYears = AcademicYear::select('*')->get();
        $classes = ClassMaster::select('class')->get();
        $healthStatus = HealthStatus::where('status', '1')
            ->orderBy('order', 'asc')
            ->get();
        $pious_assoc = PiousAssociation::where('status', '1')
            ->get();
        $selectedhealthStatus = 'Healthy';
        $students = Students::query();

        if (isset($_POST['forane']) ? $_POST['forane'] : '') {
            $students->where('forane_code', $_POST['forane']);
        }
        if (isset($_POST['units']) ? $_POST['units'] : '') {
            $students->where('catechism_unit_code', $_POST['units']);
        }

        if (isset($_POST['stud_class']) ? $_POST['stud_class'] : '') {
            $students->where('class', $_POST['stud_class']);
        }

        if (isset($_POST['class_division']) ? $_POST['class_division'] : '') {
            $students->where('division', $_POST['class_division']);
        }

        if (isset($_POST['gender']) ? $_POST['gender'] : '') {
            $students->where('sex', $_POST['gender']);
        }
        if (isset($_POST['admn_no']) ? $_POST['admn_no'] : '') {
            $students->where('admn_no', $_POST['admn_no']);
        }

        if (isset($_POST['health_status']) ? $_POST['health_status'] : '') {
            $students->where('health_status', $_POST['health_status']);
        }
        if (isset($_POST['dob_from']) ? $_POST['dob_from'] : '') {
            $students->where('dob_from', $_POST['dob_from']);
        }
        if (isset($_POST['dob_to']) ? $_POST['dob_to'] : '') {
            $students->where('dob_to', $_POST['dob_to']);
        }
        if (isset($_POST['status']) ? $_POST['status'] : '') {
            $students->where('status', '1');
        }
        if (isset($_POST['age_from']) ? $_POST['age_from'] : '') {
            $students->where('age_from', $_POST['age_from']);
        }
        if (isset($_POST['age_to']) ? $_POST['age_to'] : '') {
            $students->where('age_to', $_POST['age_to']);
        }
        if (isset($_POST['cont_class']) ? $_POST['cont_class'] : '') {
            $students->where('contact_class', $_POST['cont_class']);
        }
        if (isset($_POST['denom']) ? $_POST['denom'] : '') {
            $students->where('denomination', $_POST['denom']);
        }
        // if (isset($_POST['student_name']) ? $_POST['student_name'] : '') {
        //     $students->where('student_name', 'like', '%' . $_POST['student_name'] . '%');
        // }
        $students = $students->get();
        // echo '<pre>';
        // print_r($students);
        // exit;
        $students_report = [];
        foreach ($students as $k => $row) {
            foreach ($_POST as $key => $data) {
                if ($data != '' && $data == 1) {
                    $students_report[$k][$key] = $row->{$key};
                }
            }
        }
        // echo '<pre>';
        // print_r($academicYears);
        // exit;
        return view('general.students.student_list_without_header', compact('foranes', 'parishes', 'students_report', 'usertype', 'schools', 'classes', 'healthStatus', 'selectedhealthStatus', 'classes', 'pious_assoc', 'academicYear'));
    }
    public function student_list()
    {
        // echo '<pre>';
        // print_r("hi");
        // exit;
        $foranes = Forane::select('forane_name', 'forane_code')->get();
        $parishes = Parishes::select('name', 'parish_code')->get();
        $districts = Districts::select('district_name')->get();
        $selectedDistrict = 'Thrissur';
        $catechismUnits = CatechismUnitDetails::where('status', '1')
            ->where('unit_type', 'Parish')
            ->orderBy('unit_name', 'asc')
            ->get();
        $healthStatus = HealthStatus::where('status', '1')
            ->orderBy('order', 'asc')
            ->get();
        $selectedhealthStatus = 'Healthy';
        $classes = classMaster::orderBy('show_order', 'asc')
            ->get();
        $pious_assoc = PiousAssoc::where('status', '1')
            ->get();
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();

        $age_from = null; // Replace with your logic to get the current 'age_from'
        $age_to = null; // Replace with your logic to get the current 'age_to'
        $students_list = '';
        if ($_POST) {
            $students = Students::select('students.adm_no', 'students.catechism_unit_code', 'students.student_name', 'students.division', 'students.class', 'students.present_address', 'students.mobile', 'students.status', 'students.health_status', 'catechism_unit_details.unit_name')
                ->leftJoin('catechism_unit_details', 'catechism_unit_details.unit_code', '=', 'students.catechism_unit_code');

            if (isset($_POST['forane']) ? $_POST['forane'] : '') {
                $students->where('students.forane_code', $_POST['forane']);
            }
            if (isset($_POST['units']) ? $_POST['units'] : '') {
                $students->where('students.catechism_unit_code', $_POST['units']);
            }

            if (isset($_POST['stud_class']) ? $_POST['stud_class'] : '') {
                $students->where('students.class', $_POST['stud_class']);
            }

            if (isset($_POST['class_division']) ? $_POST['class_division'] : '') {
                $students->where('students.division', $_POST['class_division']);
            }

            if (isset($_POST['gender']) ? $_POST['gender'] : '') {
                $students->where('students.sex', $_POST['gender']);
            }
            if (isset($_POST['admn_no']) ? $_POST['admn_no'] : '') {
                $students->where('students.admn_no', $_POST['admn_no']);
            }

            if (isset($_POST['health_status']) ? $_POST['health_status'] : '') {
                $students->where('students.health_status', $_POST['health_status']);
            }
            if (isset($_POST['dob_from']) ? $_POST['dob_from'] : '') {
                $students->where('students.dob_from', $_POST['dob_from']);
            }
            if (isset($_POST['dob_to']) ? $_POST['dob_to'] : '') {
                $students->where('students.dob_to', $_POST['dob_to']);
            }
            if (isset($_POST['status']) ? $_POST['status'] : '') {
                $students->where('students.status', '1');
            }
            if (isset($_POST['age_from']) ? $_POST['age_from'] : '') {
                $students->where('students.age_from', $_POST['age_from']);
            }
            if (isset($_POST['age_to']) ? $_POST['age_to'] : '') {
                $students->where('students.age_to', $_POST['age_to']);
            }
            if (isset($_POST['cont_class']) ? $_POST['cont_class'] : '') {
                $students->where('students.contact_class', $_POST['cont_class']);
            }
            if (isset($_POST['denom']) ? $_POST['denom'] : '') {
                $students->where('students.denomination', $_POST['denom']);
            }
            if (isset($_POST['student_name']) ? $_POST['student_name'] : '') {
                $students->where('students.student_name', 'like', '%' . $_POST['student_name'] . '%');
            }
            $students_list = $students->get();
        }
        // echo '<pre>';
        // print_r($students_list);
        // exit;
        return view('general.students.student_list', compact('foranes', 'parishes', 'districts', 'selectedDistrict', 'catechismUnits', 'healthStatus', 'selectedhealthStatus', 'classes', 'pious_assoc', 'age_from', 'age_to', 'schools', 'students_list'));
    }
    public function student_strength()
    {
        // echo '<pre>';
        // print_r("hi");
        // exit;
        $foranes = Forane::select('forane_name', 'forane_code')->get();
        $parishes = Parishes::select('name', 'parish_code')->get();
        $districts = Districts::select('district_name')->get();
        $selectedDistrict = 'Thrissur';
        $catechismUnits = CatechismUnitDetails::where('status', '1')
            ->where('unit_type', 'Parish')
            ->orderBy('unit_name', 'asc')
            ->get();
        $healthStatus = HealthStatus::where('status', '1')
            ->orderBy('order', 'asc')
            ->get();
        $selectedhealthStatus = 'Healthy';
        $classes = classMaster::orderBy('show_order', 'asc')
            ->get();
        $pious_assoc = PiousAssoc::where('status', '1')
            ->get();
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();

        $age_from = null; // Replace with your logic to get the current 'age_from'
        $age_to = null; // Replace with your logic to get the current 'age_to'
        $students_strength = '';
        if ($_POST) {
            $students = Students::selectRaw("
    catechism_unit_code,class,
    class_medium,
    SUM(CASE WHEN sex = 'Male' AND class_medium = 'Malayalam' THEN 1 ELSE 0 END) AS m_boys_count,
    SUM(CASE WHEN sex = 'Female' AND class_medium = 'Malayalam' THEN 1 ELSE 0 END) AS m_girls_count,
        SUM(CASE WHEN sex = 'Male' AND class_medium = 'English' THEN 1 ELSE 0 END) AS e_boys_count,
        SUM(CASE WHEN sex = 'Female' AND class_medium = 'English' THEN 1 ELSE 0 END) AS e_girls_count,COUNT(*) AS total_count

");
            if (isset($_POST['forane']) ? $_POST['forane'] : '') {
                $students->where('forane_code', $_POST['forane']);
            }
            if (isset($_POST['units']) ? $_POST['units'] : '') {
                $students->where('catechism_unit_code', $_POST['units']);
            }

            $students_strength = $students->groupBy('catechism_unit_code', 'class')->get();
        }
        // echo '<pre>';
        // print_r($students_list);
        // exit;
        return view('general.students.student_strength', compact('foranes', 'catechismUnits', 'students_strength'));
    }
    public function student_register()
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $parishes = Parishes::select('parish_code', 'name')->get();
        $usertype = UserRole::select('user_role', 'code')->get();
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();
        $academicYears = AcademicYear::select('*')->get();
        $classes = ClassMaster::select('class')->get();
        $districts = Districts::select('district_name')->get();
        $catechismUnits = Units::select('unit_code', 'unit_name')->get();
        $healthStatus = HealthStatus::where('status', '1')
            ->orderBy('order', 'asc')
            ->get();
        $selectedhealthStatus = 'Healthy';
        $familyUnits = FamilyUnits::select('unit_code', 'family_unit_name')->get();

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
        return view('general.students.student_register', compact(['academicYears', 'foranes', 'parishes', 'usertype', 'schools', 'classes', 'students', 'forane', 'academic_yr', 'division', 'class', 'catechismUnits', 'districts', 'healthStatus', 'selectedhealthStatus', 'familyUnits']));
    }
    public function transfer_certificate()
    {
        // Fetch other necessary data
        $forane_code = isset($_POST['forane_code']) ? $_POST['forane_code'] : '';
        $unit_code = isset($_POST['unit_code']) ? $_POST['unit_code'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $division = isset($_POST['division']) ? $_POST['division'] : '';
        $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
        $admn_no = isset($_POST['gender']) ? $_POST['admn_no'] : '';
        $student_code = isset($_POST['student_code']) ? $_POST['student_code'] : '';
        $foranes = Forane::select('forane_name', 'forane_code')->get();
        $classes = ClassMaster::orderBy('show_order', 'asc')->get();
        $catechismUnits = Units::select('unit_code', 'unit_name')->get();

        $students = '';
        if ($_POST) {
            $students = Students::query();
            if (isset($_POST['student']) ? $_POST['student'] : '') {
                $students->where('student_code', $_POST['student']);
            }
            $students = $students->get();
            foreach ($students as $K => $stud) {
                //     echo '<pre>';
                //     print_r($stu);
                //     exit;
                $student_details = array(
                    'student_name' => $stud['student_name'],
                    'date_of_birth' => $stud['date_of_birth'],
                    'adm_no' => $stud['adm_no'],
                    'permanent_address' => $stud['permanent_address'],
                    'present_address' => $stud['present_address'],
                    'emailid' => $stud['emailid'],
                    'father_name' => $stud['father_name'],
                    'mother_name' => $stud['mother_name'],
                    'join_date' => $stud['join_date'],
                    'gender' => $stud['sex'],
                    // 'halfyearly_attendance' => $stu['att_till_hlf_yr'],
                    // 'annual_attendance' => $stu['att_before_hlf_yr']

                );
            }
            // echo '<pre>';
            // print_r($students);
            // exit;
            // Return the view with students data
            return view('general.students.transfer_certificate', compact('foranes', 'classes', 'catechismUnits', 'student_details'));
        }
    }
    public function cancel_tc(Request $request)
    {
        $data['cat_units'] = CatechismUnitDetails::pluck('unit_name', 'unit_code');
        $data['action_type'] = 'Load';
        $data['unit_code'] = '';

        if ($request->unit_code) {

            $unit_code = $request->unit_code;
            // dd($unit_code);


            $data['transfered_students'] = StudentTransferDetails::select('student_transfer_details.transfer_id', 'student_transfer_details.transfer_reason', 'student_transfer_details.to_unit_code', 'student_transfer_details.student_name', 'catechism_unit_details.unit_name as to_unit_name')
                ->join('catechism_unit_details', 'student_transfer_details.to_unit_code', '=', 'catechism_unit_details.unit_code')

                ->where('from_unit_code', $unit_code)
                ->where('register_in_unit', '0')->orderBy('student_name', 'ASC')->get();
            // dd($data['active_staffs']);
            // echo '<pre>';
            // print_r($data['transfered_staffs']);
            // exit;
            $data['action_type'] = 'Save';
        }
        return view('general.students.cancel_tc', $data);
    }
    public function cancel_student_TC($transfer_id)
    {
        // echo '<pre>';
        // print_r($transfer_id);
        // exit;
        $updated_date = date('Y-m-d H:i:s');
        $transfer_row = StudentTransferDetails::select('student_id', 'from_unit_code')
            ->where('transfer_id', $transfer_id)->first();
        if ($transfer_row) {
            // echo '<pre>';
            // print_r($transfer_row['student_id']);
            // exit;
            $update_students = Students::where('student_id', $transfer_row['student_id'])->update(['status' => '0', 'updated_date' => $updated_date]);
            $notattnd_row = StudentNotAttending::where('student_id', $transfer_row['student_id'])->get();
            // echo '<pre>';
            // print_r($notattnd_row);
            // exit;
            if ($notattnd_row) {
                $update_notattnd = StudentNotAttending::where('student_id', $transfer_row['student_id'])->delete();
            }
            $delete_studenttransfer = StudentTransferDetails::where('transfer_id', $transfer_id)->delete();

        }
        // Handle the request with $unit_code
        if ($update_students) {
            return redirect()->back()->with('success', 'TC canceled successfully!');
        } else {
            return response()->json(['message' => 'TC is not canceled']);

        }
    }
    public function birthday_list()
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();
        $months = Months::select('*')->get();
        $classes = ClassMaster::select('class')->get();
        $month = isset($_POST['month']) ? $_POST['month'] : '';
        $students = '';
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $division = isset($_POST['division']) ? $_POST['division'] : '';
        $unit_type = isset($_POST['unit_type']) ? $_POST['unit_type'] : '';
        $dates = isset($_POST['dates']) ? $_POST['dates'] : '';
        $units = isset($_POST['units']) ? $_POST['units'] : '';
        if ($units == '') {
            $units = isset($_POST['school']) ? $_POST['school'] : '';
        }
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $birthday_list = [];
        if (isset($forane) && $forane != '' && $month) {
            $students = Students::select('*');
            if ($units && $units != '') {
                $students->where('unit_code', $units);
            }
            if ($class && $class != '') {
                $students->where('class', $class);
            }
            if ($division && $division != '') {
                $students->where('division', $division);
            }
            if ($month && $month != '') {
                $students->whereMonth('date_of_birth', $month);
            }
            $birthday_list = $students->get();

            // echo '<pre>';
            // print_r($birthday_list);
            // exit;
        }
        return view('general.students.birthday_list', compact([
            'months',
            'foranes',
            'schools',
            'classes',
            'birthday_list'
        ]));
    }
    public function student_address_report()
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();
        $classes = ClassMaster::select('class')->get();
        $students = '';
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $division = isset($_POST['division']) ? $_POST['division'] : '';
        $unit_type = isset($_POST['unit_type']) ? $_POST['unit_type'] : '';
        $dates = isset($_POST['dates']) ? $_POST['dates'] : '';
        $units = isset($_POST['units']) ? $_POST['units'] : '';
        if ($units == '') {
            $units = isset($_POST['school']) ? $_POST['school'] : '';
        }
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $address_list = [];
        if (isset($forane) && $forane != '') {
            $students = Students::select('*');
            if ($units && $units != '') {
                $students->where('catechism_unit_code', $units);
            }
            if ($class && $class != '') {
                $students->where('class', $class);
            }
            if ($division && $division != '') {
                $students->where('division', $division);
            }
            $address_list = $students->get();

            // echo '<pre>';
            // print_r($address_list);
            // exit;
        }
        return view('general.students.address_report', compact([
            'foranes',
            'schools',
            'classes',
            'address_list'
        ]));
    }
    public function student_summary_report()
    {
        // echo '<pre>';
        // print_r("hu");
        // exit;
        $foranes = Forane::select('forane_name', 'forane_code')->get();
        $forane_code = isset($_POST['forane']) ? $_POST['forane'] : '';
        $units = isset($_POST['units']) ? $_POST['units'] : '';
        if ($units == '') {
            $units = isset($_POST['school']) ? $_POST['school'] : '';
        }
        $student_summary = '';
        if ($forane_code) {
            $student_summary = Students::selectRaw("
            students.catechism_unit_code,
            students.class,
            SUM(CASE WHEN students.sex = 'Male' AND class_medium = 'Malayalam' THEN 1 ELSE 0 END) AS m_boys_count,
            SUM(CASE WHEN students.sex = 'Female' AND class_medium = 'Malayalam' THEN 1 ELSE 0 END) AS m_girls_count,
                SUM(CASE WHEN students.sex = 'Male' AND class_medium = 'English' THEN 1 ELSE 0 END) AS e_boys_count,
                SUM(CASE WHEN students.sex = 'Female' AND class_medium = 'English' THEN 1 ELSE 0 END) AS e_girls_count,
                SUM(CASE WHEN class_medium = 'Malayalam' THEN 1 ELSE 0 END) AS m_total,
                SUM(CASE WHEN class_medium = 'English' THEN 1 ELSE 0 END) AS e_total,
                COUNT(*) AS total_count,
                COUNT(DISTINCT students.division) AS division_count
        
        ")
                ->where('students.forane_code', $forane_code)
                ->where('students.catechism_unit_code', $units)
                ->groupBy('students.catechism_unit_code')
                ->groupBy('students.class') // Group by both columns to avoid SQL errors
                // Group by both columns to avoid SQL errors
                ->get();
            // echo '<pre>';
            // print_r($student_summary);
            // exit;
        }

        return view('general.students.student_summary', compact('foranes', 'student_summary'));
    }
    public function full_attendance()
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();
        $academicYears = AcademicYear::select('*')->get();
        $classes = ClassMaster::select('class')->get();
        $students = '';
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $division = isset($_POST['division']) ? $_POST['division'] : '';
        $unit_type = isset($_POST['unit_type']) ? $_POST['unit_type'] : '';
        $dates = isset($_POST['dates']) ? $_POST['dates'] : '';
        $units = isset($_POST['units']) ? $_POST['units'] : '';
        if ($units == '') {
            $units = isset($_POST['school']) ? $_POST['school'] : '';
        }
        $exord_students = [];
        if ($academic_yr != '') {
            $students = StudentsAttendance::select('*');
            if ($units && $units != '') {
                $students->where('unit_code', $units);
            }
            if ($class && $class != '') {
                $students->where('class', $class);
            }
            if ($division && $division != '') {
                $students->where('division', $division);
            }
            if ($academic_yr && $academic_yr != '') {
                $students->where('year', $academic_yr);
            }
            $students = $students->delete();

            // echo '<pre>';
            // print_r($exord_students);
            // exit;
        }
        return view('general.students.full_attendance', compact([
            'academicYears',
            'foranes',
            'schools',
            'classes',
            'exord_students'
        ]));
    }
    public function not_attending()
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();
        $academicYears = AcademicYear::select('*')->get();
        $classes = ClassMaster::select('class')->get();
        $students = '';
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $division = isset($_POST['division']) ? $_POST['division'] : '';
        $unit_type = isset($_POST['unit_type']) ? $_POST['unit_type'] : '';
        $dates = isset($_POST['dates']) ? $_POST['dates'] : '';
        $units = isset($_POST['units']) ? $_POST['units'] : '';
        if ($units == '') {
            $units = isset($_POST['school']) ? $_POST['school'] : '';
        }
        $exord_students = [];
        if ($academic_yr != '') {
            $students = StudentsAttendance::select('*');
            if ($units && $units != '') {
                $students->where('unit_code', $units);
            }
            if ($class && $class != '') {
                $students->where('class', $class);
            }
            if ($division && $division != '') {
                $students->where('division', $division);
            }
            if ($academic_yr && $academic_yr != '') {
                $students->where('year', $academic_yr);
            }
            $students = $students->delete();

            // echo '<pre>';
            // print_r($exord_students);
            // exit;
        }
        return view('general.students.not_attending', compact([
            'academicYears',
            'foranes',
            'schools',
            'classes',
            'exord_students'
        ]));
    }
    public function extra_attendance_list()
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();
        $academicYears = AcademicYear::select('*')->get();
        $classes = ClassMaster::select('class')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $students = '';
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $division = isset($_POST['division']) ? $_POST['division'] : '';
        $unit_type = isset($_POST['unit_type']) ? $_POST['unit_type'] : '';
        $dates = isset($_POST['dates']) ? $_POST['dates'] : '';
        $units = isset($_POST['units']) ? $_POST['units'] : '';
        if ($units == '') {
            $units = isset($_POST['school']) ? $_POST['school'] : '';
        }
        $studentexta_Attendance = [];
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        if (isset($forane) && $forane != '') {
            $students = StudentsExtraAttendance::select('*');
            if ($units && $units != '') {
                $students->where('unit_code', $units);
            }
            if ($class && $class != '') {
                $students->where('class', $class);
            }
            if ($division && $division != '') {
                $students->where('division', $division);
            }
            if ($academic_yr && $academic_yr != '') {
                $students->where('academic_year', $academic_yr);
            }
            $exta_attendances = $students->get();
            $studentexta_Attendance = [];
            foreach ($exta_attendances as $key => $exta_attendance) {
                $students = array_map('trim', explode(',', $exta_attendance->student_code));
                $tot_attend = array_map('trim', explode(',', $exta_attendance->total_attendance));

                foreach ($students as $key => $studentId) {
                    $students = Students::where('student_code', $studentId);
                    $student_name = $students->first('student_name');

                    if (isset($tot_attend[$key])) {
                        $studentexta_Attendance[$studentId]['name'] = $student_name['student_name'];
                        $studentexta_Attendance[$studentId]['total_attendance'] = $tot_attend[$key];
                    }
                }
            }
            //$finalexta_Attendance = [];

            // foreach ($studentexta_Attendance as $studentId => $dates) {

            //     $finalexta_Attendance[$student_name['student_name']] = count($dates);
            //     // echo '<pre>';
            //     // print_r($finalexta_Attendance);
            //     // exit;
            // }



        }
        return view('general.students.extra_attendance_list', compact([
            'academicYears',
            'foranes',
            'schools',
            'classes',
            'studentexta_Attendance'
        ]));
    }
    public function annual_exam_ineligibility_list()
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();
        $academicYears = AcademicYear::select('*')->get();
        $classes = ClassMaster::select('class')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $students = '';
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $division = isset($_POST['division']) ? $_POST['division'] : '';
        $unit_type = isset($_POST['unit_type']) ? $_POST['unit_type'] : '';
        $dates = isset($_POST['dates']) ? $_POST['dates'] : '';
        $units = isset($_POST['units']) ? $_POST['units'] : '';
        if ($units == '') {
            $units = isset($_POST['school']) ? $_POST['school'] : '';
        }
        $studentexta_Attendance = [];
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        if (isset($forane) && $forane != '') {
            $students = StudentsExtraAttendance::select('*');
            if ($units && $units != '') {
                $students->where('unit_code', $units);
            }
            if ($class && $class != '') {
                $students->where('class', $class);
            }
            if ($division && $division != '') {
                $students->where('division', $division);
            }
            if ($academic_yr && $academic_yr != '') {
                $students->where('academic_year', $academic_yr);
            }
            $exta_attendances = $students->get();
            $studentexta_Attendance = [];
            foreach ($exta_attendances as $key => $exta_attendance) {
                $students = array_map('trim', explode(',', $exta_attendance->student_code));
                $tot_attend = array_map('trim', explode(',', $exta_attendance->total_attendance));

                foreach ($students as $key => $studentId) {
                    $students = Students::where('student_code', $studentId);
                    $student_name = $students->first('student_name');

                    if (isset($tot_attend[$key])) {
                        $studentexta_Attendance[$studentId]['name'] = $student_name['student_name'];
                        $studentexta_Attendance[$studentId]['total_attendance'] = $tot_attend[$key];
                    }
                }
            }
            //$finalexta_Attendance = [];

            // foreach ($studentexta_Attendance as $studentId => $dates) {

            //     $finalexta_Attendance[$student_name['student_name']] = count($dates);
            //     // echo '<pre>';
            //     // print_r($finalexta_Attendance);
            //     // exit;
            // }



        }
        return view('general.students.annual_exam_ineligibility_list', compact([
            'academicYears',
            'foranes',
            'schools',
            'classes',
            'studentexta_Attendance'
        ]));
    }
    public function annual_exam_eligibility_list()
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();
        $academicYears = AcademicYear::select('*')->get();
        $classes = ClassMaster::select('class')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $students = '';
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $division = isset($_POST['division']) ? $_POST['division'] : '';
        $unit_type = isset($_POST['unit_type']) ? $_POST['unit_type'] : '';
        $dates = isset($_POST['dates']) ? $_POST['dates'] : '';
        $units = isset($_POST['units']) ? $_POST['units'] : '';
        if ($units == '') {
            $units = isset($_POST['school']) ? $_POST['school'] : '';
        }
        $studentexta_Attendance = [];
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        if (isset($forane) && $forane != '') {
            $students = StudentsExtraAttendance::select('*');
            if ($units && $units != '') {
                $students->where('unit_code', $units);
            }
            if ($class && $class != '') {
                $students->where('class', $class);
            }
            if ($division && $division != '') {
                $students->where('division', $division);
            }
            if ($academic_yr && $academic_yr != '') {
                $students->where('academic_year', $academic_yr);
            }
            $exta_attendances = $students->get();
            $studentexta_Attendance = [];
            foreach ($exta_attendances as $key => $exta_attendance) {
                $students = array_map('trim', explode(',', $exta_attendance->student_code));
                $tot_attend = array_map('trim', explode(',', $exta_attendance->total_attendance));

                foreach ($students as $key => $studentId) {
                    $students = Students::where('student_code', $studentId);
                    $student_name = $students->first('student_name');

                    if (isset($tot_attend[$key])) {
                        $studentexta_Attendance[$studentId]['name'] = $student_name['student_name'];
                        $studentexta_Attendance[$studentId]['total_attendance'] = $tot_attend[$key];
                    }
                }
            }
            //$finalexta_Attendance = [];

            // foreach ($studentexta_Attendance as $studentId => $dates) {

            //     $finalexta_Attendance[$student_name['student_name']] = count($dates);
            //     // echo '<pre>';
            //     // print_r($finalexta_Attendance);
            //     // exit;
            // }



        }
        return view('general.students.annual_exam_eligibility_list', compact([
            'academicYears',
            'foranes',
            'schools',
            'classes',
            'studentexta_Attendance'
        ]));
    }
    public function transfer_student_list(Request $request)
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $transfer_year = isset($_POST['transfer_year']) ? $_POST['transfer_year'] : '2023-2024';
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
        // if ($_POST) {
        //     $Validate = $request->validate([
        //         'forane' => 'required|max:255',
        //         'units' => 'required|max:255',
        //         'transfer_year' => 'required|max:255'
        //     ]);
        // echo '<pre>';
        // print_r("hi");
        // exit;
        // if ($Validate == True) {
        $transferDetails = StudentTransferDetails::leftJoin('catechism_unit_details as a', 'a.unit_code', '=', 'student_transfer_details.from_unit_code')
            ->leftJoin('catechism_unit_details as b', 'b.unit_code', '=', 'student_transfer_details.to_unit_code')
            ->leftJoin('forane as f', 'f.forane_code', '=', 'student_transfer_details.from_forane_code')
            ->select('student_transfer_details.*', 'a.unit_name as transfered_from', 'b.unit_name as transfered_to', 'f.forane_name as forane_name');
        if ($units && $units != '') {
            $transferDetails->where('from_unit_code', $units);
        }
        if ($transfer_year && $transfer_year != '') {
            $transferDetails->where('transfer_year', $transfer_year);
        }
        if ($forane && $forane != '') {
            $transferDetails->where('from_forane_code', $forane);
        }

        $transferDetails = $transferDetails //->groupBy('from_unit_code')
            ->get();
        $stud_transferDetails = [];

        foreach ($transferDetails as $key => $studentDetails) {
            $stud_transferDetails[$studentDetails['from_unit_code']][] = $studentDetails;
        }
        // }
        // }
        // echo '<pre>';
        // print_r($stud_transferDetails);
        // exit;
        return view('general.students.transfer_student_list', compact(['academicYears', 'foranes', 'schools', 'stud_transferDetails']));

    }
}
