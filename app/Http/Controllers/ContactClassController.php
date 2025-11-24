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
use App\Models\ContactClass;
use App\Models\ContactStudentsAttendance;
use App\Models\ContactClassStudentData;

use Illuminate\Http\Request;

class ContactClassController extends Controller
{
    //
    public function contact_class_settings()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $classes = ClassMaster::select('class')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $cc_days = isset($_POST['cc_days']) ? $_POST['cc_days'] : '';
        $attnd_last_date = isset($_POST['attnd_last_date']) ? $_POST['attnd_last_date'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $pass_percentage = isset($_POST['pass_percentage']) ? $_POST['pass_percentage'] : '';
        $written_mark = isset($_POST['written_mark']) ? $_POST['written_mark'] : '';
        $assignment_mark = isset($_POST['assignment_mark']) ? $_POST['assignment_mark'] : '';
        $test_mark = isset($_POST['test_mark']) ? $_POST['test_mark'] : '';
        $attendance_mark = isset($_POST['attendance_mark']) ? $_POST['attendance_mark'] : '';
        $academicYears = AcademicYear::select('academic_year')->get()->last()->toArray();
        $ContactClasses = ContactClass::select('*')->get();
        $contact_class_settings = [];
        if ($cc_days != '') {
            // $selected_dates = Carbon::parse($dates);
            //$dateArray = array_map('trim', explode(',', $dates));
            $internal_total = $attendance_mark + $test_mark + $assignment_mark;
            $data = array(
                'academic_year' => $academic_yr,
                'class' => $class,
                'days' => $cc_days,
                'attd_entry_last_date' => $attnd_last_date,
                'pass_percentage' => $pass_percentage,
                'assignment' => $assignment_mark,
                'test' => $test_mark,
                'attendance' => $attendance_mark,
                'written' => $written_mark,
                'internal_total' => $internal_total

            );
            // echo '<pre>';
            // print_r($data);
            $save_cc = ContactClass::insert($data);
            if (isset($save_cc)) {
                return redirect()->back()->with('success', 'Contact Class have been saved.');
            }
            //$dates_string = implode(',', $common_holidays_days);

        }
        return view('general.contact_class.contact_class_settings', compact(['academicYears', 'classes', 'ContactClasses']));

    }
    public function non_public_mark_entry()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $classes = ClassMaster::select('class')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $academicYears = AcademicYear::select('academic_year')->get()->last()->toArray();

        return view('general.contact_class.non_public_mark_entry', compact(['academicYears', 'classes']));

    }
    public function non_public_mark_list()
    {

        $classes = ClassMaster::select('class')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $academicYears = AcademicYear::select('*')->get();
        $students_data = '';
        if (isset($class) && $class != '') {
            $non_mark_list = ContactClassStudentData::select('*');
            if ($class && $class != '') {
                $non_mark_list->where('class', $class);
            }
            if ($academic_yr && $academic_yr != '') {
                $non_mark_list->where('academic_year', $academic_yr);
            }
            $non_pulic_mark_records = $non_mark_list->get();

            $cont_class_details = ContactClass::select('*');
            if ($class && $class != '') {
                $cont_class_details->where('class', $class);
            }
            if ($academic_yr && $academic_yr != '') {
                $cont_class_details->where('academic_year', $academic_yr);
            }
            $cont_class_details = $cont_class_details->first();
            $internal_total = $cont_class_details->internal_total;
            $written = $cont_class_details->written;
            $pass_percentage = $cont_class_details->pass_percentage;

            $max_total = $internal_total + $written;
            $sep_pass_mark = ceil($written * $pass_percentage * 0.01);

            $pass_mark = ceil($max_total * $pass_percentage * 0.01);

            $students_data = [];

            foreach ($non_pulic_mark_records as $rec) {

                // explode student codes
                $student_codes = explode(',', $rec->students);

                // helper to extract "student_code|value"
                $parseMarks = function ($str) {
                    $data = [];
                    if ($str) {
                        foreach (explode(',', $str) as $pair) {
                            if (str_contains($pair, '|')) {
                                [$code, $value] = explode('|', $pair);
                                $data[trim($code)] = trim($value);
                            }
                        }
                    }
                    return $data;
                };

                $reg_nums = $parseMarks($rec->register_numbers ?? '');
                $assign = $parseMarks($rec->assignment ?? '');
                $test = $parseMarks($rec->test ?? '');
                $att = $parseMarks($rec->attendance ?? '');
                $written = $parseMarks($rec->written ?? '');
                $total = $parseMarks($rec->total_marks ?? '');
                $exam_att = explode(',', $rec->exam_attendance ?? '');

                foreach ($student_codes as $code) {
                    $code = trim($code);

                    $written_mark = floatval($written[$code] ?? 0);
                    $total_mark = floatval($total[$code] ?? 0);

                    // Determine remarks
                    if (!in_array($code, $exam_att)) {
                        $remarks = 'Absent';
                    } elseif ($written_mark >= $sep_pass_mark && $total_mark >= $pass_mark) {
                        $remarks = 'Pass';
                    } else {
                        $remarks = 'Fail';
                    }
                    $students_data[] = [
                        'student_code' => $code,
                        'reg' => $reg_nums[$code] ?? '',
                        'assign' => $assign[$code] ?? 0,
                        'test' => $test[$code] ?? 0,
                        'att' => $att[$code] ?? 0,
                        'written' => $written[$code] ?? 0,
                        'total' => $total[$code] ?? 0,
                        'remarks' => $remarks
                    ];
                }
            }

            // echo '<pre>';
            // print_r($internal_total);
            // exit;
        }
        return view('general.contact_class.non_public_mark_list', compact(['academicYears', 'classes', 'students_data']));

    }
    public function contact_class_attendance_list()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $classes = ClassMaster::select('class')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $academicYears = AcademicYear::select('*')->get();
        $studentexta_Attendance = [];
        $all_students = '';
        $dates = '';
        $cont_students_att = '';

        // echo '<pre>';
        // print_r($_POST);
        // exit;
        if (isset($class) && $class != '') {
            $cont_students = ContactStudentsAttendance::select('*');
            if ($class && $class != '') {
                $cont_students->where('class', $class);
            }
            if ($academic_yr && $academic_yr != '') {
                $cont_students->where('year', $academic_yr);
            }
            $cont_students_att = $cont_students->get();

            $all_students = [];
            foreach ($cont_students_att as $record) {
                $students = explode(',', $record['attendance']);
                foreach ($students as $student) {
                    $all_students[$student] = true;
                }
            }
            $all_students = array_keys($all_students);

            // Step 2: Extract all dates
            $dates = array_column($cont_students_att->toArray(), 'date');

            // echo '<pre>';
            // print_r($all_students);
            // exit;

        }
        return view('general.contact_class.contact_class_attendance_list', compact(['academicYears', 'classes', 'all_students', 'dates', 'cont_students_att']));

    }
    public function add_contact_attendance()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $classes = ClassMaster::select('class')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $academicYears = AcademicYear::select('*')->get();

        return view('general.contact_class.add_contact_attendance', compact(['academicYears', 'classes']));

    }
    public function register_no_generation()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $classes = ClassMaster::select('class')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $academicYears = AcademicYear::select('academic_year')->get()->last()->toArray();

        return view('general.contact_class.register_no_generation', compact(['academicYears', 'classes']));

    }
    public function register_no_report()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $classes = ClassMaster::select('class')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $academicYears = AcademicYear::select('*')->get();

        return view('general.contact_class.register_no_report', compact(['academicYears', 'classes']));

    }
    public function public_exam_mark_entry()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $classes = ClassMaster::select('class')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $academicYears = AcademicYear::select('academic_year')->get()->last()->toArray();

        return view('general.contact_class.public_exam_mark_entry', compact(['academicYears', 'classes']));

    }
    public function public_exam_mark_list()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $classes = ClassMaster::select('class')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $academicYears = AcademicYear::select('*')->get();
        $students_data = '';
        if (isset($class) && $class != '') {
            $mark_list = ContactClassStudentData::select('*');
            if ($class && $class != '') {
                $mark_list->where('class', $class);
            }
            if ($academic_yr && $academic_yr != '') {
                $mark_list->where('academic_year', $academic_yr);
            }
            $pulic_mark_records = $mark_list->get();

            $cont_class_details = ContactClass::select('*');
            if ($class && $class != '') {
                $cont_class_details->where('class', $class);
            }
            if ($academic_yr && $academic_yr != '') {
                $cont_class_details->where('academic_year', $academic_yr);
            }
            $cont_class_details = $cont_class_details->first();
            $internal_total = $cont_class_details->internal_total;
            $written = $cont_class_details->written;
            $pass_percentage = $cont_class_details->pass_percentage;

            $max_total = $internal_total + $written;
            $sep_pass_mark = ceil($written * $pass_percentage * 0.01);

            $pass_mark = ceil($max_total * $pass_percentage * 0.01);

            $students_data = [];

            foreach ($pulic_mark_records as $rec) {

                // explode student codes
                $student_codes = explode(',', $rec->students);

                // helper to extract "student_code|value"
                $parseMarks = function ($str) {
                    $data = [];
                    if ($str) {
                        foreach (explode(',', $str) as $pair) {
                            if (str_contains($pair, '|')) {
                                [$code, $value] = explode('|', $pair);
                                $data[trim($code)] = trim($value);
                            }
                        }
                    }
                    return $data;
                };

                $reg_nums = $parseMarks($rec->register_numbers ?? '');
                $assign = $parseMarks($rec->assignment ?? '');
                $test = $parseMarks($rec->test ?? '');
                $att = $parseMarks($rec->attendance ?? '');
                $written = $parseMarks($rec->written ?? '');
                $total = $parseMarks($rec->total_marks ?? '');
                $exam_att = explode(',', $rec->exam_attendance ?? '');

                foreach ($student_codes as $code) {
                    $code = trim($code);

                    $written_mark = floatval($written[$code] ?? 0);
                    $total_mark = floatval($total[$code] ?? 0);

                    // Determine remarks
                    if (!in_array($code, $exam_att)) {
                        $remarks = 'Absent';
                    } elseif ($written_mark >= $sep_pass_mark && $total_mark >= $pass_mark) {
                        $remarks = 'Pass';
                    } else {
                        $remarks = 'Fail';
                    }
                    $students_data[] = [
                        'student_code' => $code,
                        'reg' => $reg_nums[$code] ?? '',
                        'assign' => $assign[$code] ?? 0,
                        'test' => $test[$code] ?? 0,
                        'att' => $att[$code] ?? 0,
                        'written' => $written[$code] ?? 0,
                        'total' => $total[$code] ?? 0,
                        'remarks' => $remarks
                    ];
                }
            }
        }
        return view('general.contact_class.public_exam_mark_list', compact(['academicYears', 'classes', 'students_data']));

    }
}
