<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\TotalWorkingDays;
use App\Models\ImportantDays;
use App\Models\AcademicYear;
use Carbon\Carbon;
use App\Models\Students;
use App\Models\Forane;
use App\Models\staffs;
use App\Models\Units;
use App\Models\Divisions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\InitialAdmissionNumber;
use App\Models\ClassPromotionCriteria;
use App\Models\ClassMaster;
use App\Models\ExamType;
use App\Models\ExamSettings;
use App\Models\ExamDateSettings;
use App\Models\News;
use App\Models\Events;
use App\Models\ForanePromoters;
use App\Models\Parishes;
use App\Models\Users;
use App\Models\UserRole;
use App\Models\AttendanceEditReasons;
use App\Models\SchoolStudentsStatistics;
use App\Models\FamilyUnits;
use App\Models\CatechismDesignations;
use App\Models\InternalMarksCriteria;
use App\Models\JobCategories;
use App\Models\Jobs;
use App\Models\Qualifications;
use App\Models\NameTitles;
use App\Models\PiousAssoc;
use App\Models\CatechismAuthorities;
use App\Models\CatechismAuthorityMembers;
use App\Models\UrgentNotifications;
use App\Models\LocalHolidays;
use Illuminate\Support\Facades\Storage;

class GeneralSettings extends Controller
{
    public function academic_year()
    {
        // echo '<pre>';
        // print_r("hii");
        // exit;
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $extra_attendance_hm = isset($_POST['extra_attendance_hm']) ? $_POST['extra_attendance_hm'] : '';
        $extra_attendance_vicar = isset($_POST['extra_attendance_vicar']) ? $_POST['extra_attendance_vicar'] : '';
        $extra_attendance_dbclc = isset($_POST['extra_attendance_dbclc']) ? $_POST['extra_attendance_dbclc'] : '';
        $extra_attendance_permission = isset($_POST['extra_attendance_permission']) ? $_POST['extra_attendance_permission'] : 0;
        $academicYears = AcademicYear::select('*')->get();

        $working_days = [];
        if ($academic_yr != '') {
            $data = array(
                'academic_year' => $academic_yr,
                'extra_attendance_hm_ct' => $extra_attendance_hm,
                'extra_attendance_vicar_ct' => $extra_attendance_vicar,
                'extra_attendance_dbclc_ct' => $extra_attendance_dbclc,
                'extra_attd' => $extra_attendance_permission,
            );
            $acc_yr = AcademicYear::insert($data);
            if (isset($acc_yr)) {
                return redirect()->back()->with('success', 'Accademic Year data have been saved.');
            }
        }
        return view('general.academic_year', compact(['academicYears']));
    }
    public function working_days_list()
    {
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $academicYears = TotalWorkingDays::groupBy('academic_year')
            ->pluck('academic_year', 'id');
        $working_days = [];
        if ($academic_yr != '') {
            $working_days = TotalWorkingDays::where('academic_year', $academic_yr)->get();

        }
        return view('general.working_days_list', compact(['academicYears', 'working_days']));

    }
    public function add_working_days()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $class = isset($_POST['classes']) ? $_POST['classes'] : '';
        $tot_working_days = isset($_POST['tot_working_days']) ? $_POST['tot_working_days'] : '';

        $academicYears = TotalWorkingDays::groupBy('academic_year')
            ->pluck('academic_year', 'id');
        $classes = TotalWorkingDays::groupBy('class')
            ->pluck('class', 'id');
        if ($academic_yr != '' && $class != '') {
            $working_days_exist = TotalWorkingDays::where('academic_year', $academic_yr)->
                where('class', $class)->
                pluck('total_working_days')->toArray();
            if ($working_days_exist[0] == 0 || $working_days_exist[0] == '') {
                // echo '<pre>';
                // print_r("hi");
                // exit;
                $totalWorkingDay = TotalWorkingDays::where('academic_year', $academic_yr)->where('class', $class)->update(['total_working_days' => $tot_working_days]);
            } else {
                $data = array(
                    'academic_year' => $academic_yr,
                    'class' => $class,
                    'total_working_days' => $tot_working_days
                );
                $importnt_dates = TotalWorkingDays::insert($data);
            }
        }

        // echo '<pre>';
        // print_r($working_days_exist);
        // exit;

        //$working_days = [];
        // if ($academic_yr != '') {
        //     $working_days = TotalWorkingDays::where('academic_year', $academic_yr)->get();

        // }
        return view('general.add_working_days', compact(['academicYears', 'classes']));
    }
    public function important_days_list()
    {
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $academicYears = ImportantDays::groupBy('academic_year')
            ->pluck('academic_year', 'id');
        $important_days = [];
        if ($academic_yr != '') {
            $important_days = ImportantDays::where('academic_year', $academic_yr)->get();

        }
        return view('general.important_days_list', compact(['academicYears', 'important_days']));

    }
    public function add_important_days()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
        $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';

        $academicYears = AcademicYear::select('academic_year')->get()->last()->toArray();
        if ($academic_yr != '') {
            $data = array(
                'academic_year' => $academic_yr,
                'title' => $title,
                'start_date' => $start_date,
                'end_date' => $end_date
            );
            $importnt_dates = ImportantDays::insert($data);
        }
        return view('general.add_important_dates', compact(['academicYears']));
    }
    public function common_holiday_settings()
    {
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        // $title = isset($_POST['title']) ? $_POST['title'] : '';
        $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
        $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
        $academicYears = AcademicYear::select('academic_year')->get()->last()->toArray();
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $common_holidays_days = [];
        if ($start_date != '' && $end_date != '') {
            $start_date = Carbon::parse($start_date);
            $end_date = Carbon::parse($end_date);
            while ($start_date <= $end_date) {
                $common_holidays_days[] = $start_date->toDateString();


                $start_date->addDay();
            }
            $dates_string = implode(',', $common_holidays_days);
            $common_holiDay = AcademicYear::where('academic_year', $academic_yr)->update(['common_holidays' => $dates_string]);

            // echo '<pre>';
            // print_r($common_holidays_days);
        }
        return view('general.common_holidays', compact(['academicYears']));

    }
    public function local_holiday_settings()
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();

        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $parish = isset($_POST['parish']) ? $_POST['parish'] : '';
        $unit_type = isset($_POST['unit_type']) ? $_POST['unit_type'] : '';
        $units = isset($_POST['units']) ? $_POST['units'] : '';
        if ($units == '') {
            $units = isset($_POST['units']) ? $_POST['school'] : '';
        }
        // $title = isset($_POST['title']) ? $_POST['title'] : '';
        $dates = isset($_POST['dates']) ? $_POST['dates'] : '';
        $academicYears = AcademicYear::select('academic_year')->get()->last()->toArray();
        $local_holiDays = LocalHolidays::leftJoin('catechism_unit_details', 'local_holidays.unit_code', '=', 'catechism_unit_details.unit_code')
            ->select('*', 'catechism_unit_details.unit_name')->get();
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $local_holidays_days = [];
        if ($dates != '') {
            // $selected_dates = Carbon::parse($dates);
            $dateArray = array_map('trim', explode(',', $dates));
            $numberOfDates = count($dateArray);
            $data = array(
                'academic_year' => $academic_yr,
                'days' => $dates,
                'unit_code' => $units,
                'no_of_days' => $numberOfDates
            );
            $holiday_dates = LocalHolidays::insert($data);
            if (isset($holiday_dates)) {
                return redirect()->back()->with('success', 'Holiday details have been saved.');
            }
            //$dates_string = implode(',', $common_holidays_days);
            // echo '<pre>';
            // print_r($common_holidays_days);
        }
        return view('general.local_holidays', compact(['local_holiDays', 'academicYears', 'foranes', 'schools']));

    }
    public function summary_report()
    {
        $foranes_data = DB::table('forane')
            ->leftJoin('staffs', 'forane.forane_code', '=', 'staffs.forane_code')
            ->leftJoin('students', 'forane.forane_code', '=', 'students.forane_code')
            ->select(
                'forane.*',
                DB::raw('COUNT(DISTINCT staffs.staff_id) as staff_count'),
                DB::raw('COUNT(DISTINCT students.student_id) as student_count')
            )
            ->groupBy('forane.forane_code')
            ->get();
        // echo '<pre>';
        // print_r($foranes_data);
        // exit;
        return view('general.summary_report', compact(['foranes_data']));

    }
    public function summary_detail()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $forane_id = $_POST['forane_id'];
        $detail_data = Units::leftJoin('staffs', 'catechism_unit_details.unit_code', '=', 'staffs.catechism_unit_code')
            ->leftJoin('forane', 'forane.forane_code', '=', 'catechism_unit_details.forane_code')
            ->leftJoin('students', 'catechism_unit_details.unit_code', '=', 'students.catechism_unit_code')
            ->select(
                'catechism_unit_details.*',
                DB::raw('COUNT(DISTINCT staffs.staff_id) as staff_count'),
                DB::raw('COUNT(DISTINCT students.student_id) as student_count')
            )
            ->where('catechism_unit_details.forane_code', $forane_id)
            ->groupBy('forane.forane_code')
            ->get();
        // echo '<pre>';
        // print_r($foranes_data);
        // exit;
        return view('general.summary_report', compact(['foranes_data']));

    }
    public function division_management()
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $units = Units::select('unit_code', 'unit_name')->get();
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $unit = isset($_POST['units']) ? $_POST['units'] : '';
        // echo '<pre>';
        // print_r($unit);
        // exit;
        $divisions = '';
        if ($forane != '' && $unit != '') {
            $divisions = Divisions::where('unit_code', $unit)->get();
            // echo '<pre>';
            // print_r($divisions);
            // exit;
        }
        return view('general.division_management', compact(['foranes', 'units', 'divisions']));
    }
    public function add_last_admission()
    {

        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $units = Units::select('unit_code', 'unit_name')->get();
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $unit = isset($_POST['units']) ? $_POST['units'] : '';
        $admno = isset($_POST['last_admno']) ? $_POST['last_admno'] : '';

        // echo '<pre>';
        // print_r($admno);
        // exit;
        //$divisions = '';
        if ($forane != '' && $unit != '' && $admno != '') {
            // $divisions = Divisions::where('unit_code', $unit)->get();
            // echo '<pre>';
            // print_r($divisions);
            // exit;
            $data = array(
                'forane_code' => $forane,
                'unit_code' => $unit,
                'admission_no' => $admno,
            );
            $importnt_dates = InitialAdmissionNumber::insert($data);
        }
        return view('general.add_last_admno', compact(['foranes', 'units']));
    }
    public function criteria_list()
    {
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $academicYears = ImportantDays::groupBy('academic_year')
            ->pluck('academic_year', 'id');
        $criterias = [];

        if ($academic_yr != '') {
            $criterias = ClassPromotionCriteria::where('academic_year', $academic_yr)->get();
            // echo '<pre>';
            // print_r($criterias);
            // exit;
        }
        return view('general.criteria_list', compact(['academicYears', 'criterias']));

    }
    public function add_criteria()
    {
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $Criteria = isset($_POST['criteria']) ? $_POST['criteria'] : '';
        $half_yearly = isset($_POST['half_yearly']) ? $_POST['half_yearly'] : '';
        $annual = isset($_POST['annual']) ? $_POST['annual'] : '';
        $internal = isset($_POST['internal']) ? $_POST['internal'] : '';
        $min_attendance = isset($_POST['min_attendance']) ? $_POST['min_attendance'] : '';
        $academicYears = AcademicYear::select('academic_year')->get()->last()->toArray();
        $classes = ClassMaster::select('class')->get();
        if ($academic_yr != '') {
            $selectedClasses = $_POST['classes'];
            $classesString = implode(',', $selectedClasses);
            $data = array(
                'academic_year' => $academic_yr,
                'class' => $classesString,
                'criteria' => $Criteria,
                'criteria_type' => 1,
                'half_yearly' => $half_yearly,
                'annual' => $annual,
                'internal' => $internal,
                'minimum_attendance' => $min_attendance
            );
            $class_promotion_criteria = ClassPromotionCriteria::insert($data);
        }
        if (isset($class_promotion_criteria)) {
            return redirect()->back()->with('success', 'Criteria details have been saved.');
        }
        return view('general.add_criteria', compact(['academicYears', 'classes']));
    }
    public function add_settings()
    {
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $academicYears = AcademicYear::select('academic_year')->get()->last()->toArray();
        $examtype = ExamType::select('id', 'type')->get();
        $classes = ClassMaster::select('class')->get();
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $settings = [];
        if ($academic_yr != '') {
            $working_days_exist = ExamSettings::where('academic_year', $academic_yr)->pluck('id')->toArray();
            $class = $_POST['class'];
            $min = $_POST['min'];
            $max = $_POST['max'];
            $extra_qp = $_POST['extra_qp'];
            $duration = $_POST['duration'];
            $r_exam = $_POST['re_exam'];

            $min = array_map(function ($value) {
                return $value === null || $value === '' ? '0' : $value;
            }, $min);

            $max = array_map(function ($value) {
                return $value === null || $value === '' ? '0' : $value;
            }, $max);

            $extra_qp = array_map(function ($value) {
                return $value === null || $value === '' ? '0' : $value;
            }, $extra_qp);

            $duration = array_map(function ($value) {
                return $value === null || $value === '' ? '0' : $value;
            }, $duration);

            $re_exam = array_map(function ($value) {
                return $value === null || $value === '' ? '0' : $value;
            }, $r_exam);

            $min_marks = implode(',', $min);
            $max_marks = implode(',', $max);
            $extra_qp_count = implode(',', $extra_qp);
            $ex_duration = implode(',', $duration);
            $re_exam = implode(',', $re_exam);
            $classesString = implode(',', $class);

            $data = array(
                'academic_year' => $academic_yr,
                'class' => $classesString,
                'min_marks' => $min_marks,
                'max_marks' => $max_marks,
                'extra_qpaper_count' => $extra_qp_count,
                'duration' => $ex_duration,
                're_exam' => $re_exam,
            );
            if (isset($working_days_exist['id'])) {
                $exam_settings = ExamSettings::where('id', $working_days_exist['id'])->update([$data]);
                ;

            } else {

                $exam_settings = ExamSettings::insert($data);
                // echo '<pre>';
                // print_r($_POST);
                // exit;
            }
        }
        if (isset($exam_settings)) {
            return redirect()->back()->with('success', 'Exam settings have been saved.');
        }
        // return view('general.add_criteria', compact(['academicYears', 'classes']));
        return view('general.add_settings', compact(['academicYears', 'examtype', 'classes']));

    }
    public function settings_list()
    {
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $exam_type = isset($_POST['exam_type']) ? $_POST['exam_type'] : '';
        $academicYears = AcademicYear::select('academic_year')->get();
        // echo '<pre>';
        // print_r($academic_yr);
        // exit;
        // $academicYears = ImportantDays::groupBy('academic_year')
        //     ->pluck('academic_year', 'id');
        $settings_data = [];

        if ($academic_yr != '') {
            $settings = ExamSettings::where('academic_year', $academic_yr)->where('exam_type_id', $exam_type)->first();
            $class = $settings['class'];
            $min = $settings['min_marks'];
            $max = $settings['max_marks'];
            $extra_qp = $settings['extra_qpaper_count'];
            $duration = $settings['duration'];
            $r_exam = $settings['re_exam'];

            $min_marks = explode(',', $min);
            $max_marks = explode(',', $max);
            $extra_qp_count = explode(',', $extra_qp);
            $ex_duration = explode(',', $duration);
            $re_exam = explode(',', $r_exam);
            $classesString = explode(',', $class);

            $ex_duration = array_map(function ($value) {
                return $value === null || $value === '' ? '0' : $value;
            }, $ex_duration);
            foreach ($classesString as $k => $clas) {
                $settings_data[$k]['class'] = $clas;
                $settings_data[$k]['min_marks'] = $min_marks[$k];
                $settings_data[$k]['max_marks'] = $max_marks[$k];
                $settings_data[$k]['extra_qp_count'] = $extra_qp_count[$k];
                $settings_data[$k]['duration'] = $ex_duration[$k];
                $settings_data[$k]['re_exam'] = $re_exam[$k];
            }
        }
        return view('general.settings_list', compact(['academicYears', 'settings_data']));
    }
    public function add_date_settings()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
        $last_attn_date = isset($_POST['last_attn_date']) ? $_POST['last_attn_date'] : '';
        $last_attn_entry_date = isset($_POST['last_attn_entry_date']) ? $_POST['last_attn_entry_date'] : '';
        $half_yr_exam_date = isset($_POST['half_yr_exam_date']) ? $_POST['half_yr_exam_date'] : '';
        $half_yr_mark_entry_last_dt = isset($_POST['half_yr_mark_entry_last_dt']) ? $_POST['half_yr_mark_entry_last_dt'] : '';
        $half_yr_re_exam_date = isset($_POST['half_yr_re_exam_date']) ? $_POST['half_yr_re_exam_date'] : '';
        $half_yr_re_mark_last_date = isset($_POST['half_yr_re_mark_last_date']) ? $_POST['half_yr_re_mark_last_date'] : '';
        $extra_attn_entry_last_date = isset($_POST['extra_attn_entry_last_date']) ? $_POST['extra_attn_entry_last_date'] : '';
        $annual_exm_date = isset($_POST['annual_exm_date']) ? $_POST['annual_exm_date'] : '';
        $annual_exm_mrk_en_lst_date = isset($_POST['annual_exm_mrk_en_lst_date']) ? $_POST['annual_exm_mrk_en_lst_date'] : '';
        $annual_re_exam_date = isset($_POST['annual_re_exam_date']) ? $_POST['annual_re_exam_date'] : '';
        $annual_re_exam_mrk_entry_date = isset($_POST['annual_re_exam_mrk_entry_date']) ? $_POST['annual_re_exam_mrk_entry_date'] : '';
        $intrnl_mrks_ent_lst_dt = isset($_POST['intrnl_mrks_ent_lst_dt']) ? $_POST['intrnl_mrks_ent_lst_dt'] : '';

        $academicYears = AcademicYear::select('academic_year')->get()->last()->toArray();
        $classes = ClassMaster::select('class')->get();

        if ($academic_yr != '') {
            $selectedClasses = $_POST['classes'];
            $classesString = implode(',', $selectedClasses);
            $data = array(
                'academic_year' => $academic_yr,
                'class' => $classesString,
                'start_date' => $start_date,
                'last_attd_date' => $last_attn_date,
                'last_attd_entry_date' => $last_attn_entry_date,
                'hy_exam_date' => $half_yr_exam_date,
                'hy_mark_last_date' => $half_yr_mark_entry_last_dt,
                're_exam_hy_exam_date' => $half_yr_re_exam_date,
                're_exam_hy_mark_last_date' => $half_yr_re_mark_last_date,
                'annual_exam_date' => $annual_exm_date,
                'annual_mark_last_date' => $annual_exm_mrk_en_lst_date,
                're_exam_annual_exam_date' => $annual_re_exam_date,
                're_exam_annual_mark_last_date' => $annual_re_exam_mrk_entry_date,
                'int_mark_entry_date' => $intrnl_mrks_ent_lst_dt,
            );
            $exam_date_sttngs = ExamDateSettings::insert($data);
        }
        if (isset($exam_date_sttngs)) {
            return redirect()->back()->with('success', 'Date Settings have been saved.');
        }
        return view('general.add_date_settings', compact(['academicYears', 'classes']));
    }
    public function date_settings_list()
    {
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $classes = isset($_POST['classes']) ? $_POST['classes'] : '';
        $academicYears = AcademicYear::select('academic_year')->get();

        $settings_data = [];
        if ($academic_yr != '') {
            $settings = ExamDateSettings::where('academic_year', $academic_yr)->where('class', $classes)->get()->toArray();
            // echo '<pre>';
            // print_r($settings);
            // exit;
            $class = $settings[0]['class'];
            $start_date = $settings[0]['start_date'];
            $last_attd_date = $settings[0]['last_attd_date'];
            $last_attd_entry_date = $settings[0]['last_attd_entry_date'];
            $hy_exam_date = $settings[0]['hy_exam_date'];
            $hy_mark_last_date = $settings[0]['hy_mark_last_date'];
            $re_exam_hy_exam_date = $settings[0]['re_exam_hy_exam_date'];

            // $settings_data = array(
            //     'academic_year' => $academic_yr,
            //     'class' => $class,
            //     'start_date' => $start_date,
            //     'last_attd_date' => $last_attd_date,
            //     'last_attd_entry_date' => $last_attd_entry_date,
            //     'hy_exam_date' => $hy_exam_date,
            //     'hy_mark_last_date' => $hy_mark_last_date,
            //     're_exam_hy_exam_date' => $re_exam_hy_exam_date,
            // );
        }

        return view('general.date_settings_list', compact(['academicYears', 'settings']));
    }
    public function getClasses($academic_year)
    {
        $classes = ExamDateSettings::select('class')->where('academic_year', $academic_year)->get();
        return response()->json($classes);
    }
    public function internal_criteria_list()
    {
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $academicYears = InternalMarksCriteria::groupBy('academic_year')
            ->pluck('academic_year', 'id');
        $criterias = [];

        if ($academic_yr != '') {
            $criterias = InternalMarksCriteria::where('academic_year', $academic_yr)->get();
            // echo '<pre>';
            // print_r($criterias);
            // exit;
        }
        return view('general.internal_criteria_list', compact(['academicYears', 'criterias']));

    }
    public function add_internal_marks_criteria()
    {
        $academicYears = AcademicYear::select('academic_year')->get()->last()->toArray();
        $examtype = ExamType::select('id', 'type')->get();
        $classes = ClassMaster::select('class')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $no_of_criteria = isset($_POST['no_of_criteria']) ? $_POST['no_of_criteria'] : '';
        $total = isset($_POST['total']) ? $_POST['total'] : '';
        $class_selected = isset($_POST['classes']) ? $_POST['classes'] : [];
        $criteria = isset($_POST['criteria']) ? $_POST['criteria'] : [];
        $type = isset($_POST['type']) ? $_POST['type'] : [];
        $criteria_marks = isset($_POST['max']) ? $_POST['max'] : [];


        // echo '<pre>';
        // print_r($_POST);
        // exit;
        if (($criteria) && $criteria != '') {
            // echo '<pre>';
            // print_r("hi");
            // exit;
            $classesString = implode(',', $class_selected);
            $criteriaString = implode(',', $criteria);
            $typeString = implode(',', $type);
            $criteria_marks = implode(',', $criteria_marks);

            $data = array(
                'academic_year' => $academic_yr,
                'class' => $classesString,
                'criteria' => $criteriaString,
                'criteria_type' => $typeString,
                'criteria_marks' => $criteria_marks,
                'total_marks' => $total


            );
            $internal_criterias = [];
            $internal_criterias = InternalMarksCriteria::insert($data);
            //     // echo '<pre>';
            //     // print_r($_POST);
            //     // exit;
            // }
            if (isset($internal_criterias)) {
                return redirect()->back()->with('success', 'Criteria settings have been saved.');
            }
        }

        // return view('general.add_criteria', compact(['academicYears', 'classes']));
        return view('general.add_internal_criteria', compact(['academicYears', 'no_of_criteria', 'classes', 'total', 'class_selected', 'academic_yr']));

    }

    public function add_news(Request $request)
    {

        //Validate the incoming file. Refuses anything bigger than 2048 kilobyes (=2MB)
        if ($_POST) {
            $newsData = $request->validate([
                'pdf' => 'mimes:pdf,jpg,png|max:2048',
                'news_image' => 'mimes:jpg,png|max:2048'
            ]);

            $newsData['title'] = $request->title;
            $newsData['matter'] = $request->discription;
            $newsData['date'] = $request->published_date;
            $newsData['valid_upto'] = $request->end_date;
            $newsData['link'] = $request->hyperlink;
            $newsData['link_text'] = $request->hyperlink_text;
            $newsData['title'] = $request->title;
            $newsData['updated_by'] = Auth::user()->user_type;

            // Store the file in storage\app\public folder
            if ($request->file('pdf')) {
                $file = $request->file('pdf');
                $fileName = $file->getClientOriginalName();
                $filePath = $file->store('uploads', 'public');
                // Store file information in the database
                $newsData['file_name'] = $fileName;

                //## To display uploaded files  ##
                // storage_path('app/public/uploads')
                // $url = Storage::url("uploads/{$filename}");
            }
            if ($request->file('news_image')) {
                $image = $request->file('news_image');
                $imgFile = $image->getClientOriginalName();
                $filePath = $image->store('images', 'public');
                // Store file information in the database
                $newsData['image_file'] = $imgFile;

                //## To display uploaded files  ##
                // storage_path('app/public/uploads')
                // $url = Storage::url("uploads/{$filename}");
            }
            // echo '<pre>';
            // print_r($newsData);
            // exit;
            $news = News::create($newsData);
        }

        return view('general.add_news');
    }
    public function news_list()
    {
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $academicYears = News::select(DB::raw('YEAR(date) as year'), 'date', 'id')
            ->groupBy(DB::raw('YEAR(date)'))
            ->pluck('year', 'id');
        $news_list = [];
        if ($academic_yr != '') {
            $news_list = News::where(DB::raw('YEAR(date)'), $academic_yr)->get();
            // echo '<pre>';
            // print_r($news_list);
            // exit;
        }
        return view('general.news_list', compact(['academicYears'], 'news_list'));
    }
    public function add_events(Request $request)
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        if ($_POST) {
            $eventData = $request->validate([
                'pdf' => 'mimes:pdf,jpg,png|max:2048',
                'news_image' => 'mimes:jpg,png|max:2048'
            ]);

            $eventData['title'] = $request->title;
            $eventData['matter'] = $request->discription;
            $eventData['date'] = $request->start_date;
            $eventData['valid_upto'] = $request->end_date;
            $eventData['title'] = $request->title;
            // $eventData['updated_by'] = Auth::user()->user_type;

            // Store the file in storage\app\public folder
            if ($request->file('pdf')) {
                $file = $request->file('pdf');
                $fileName = $file->getClientOriginalName();
                $filePath = $file->store('uploads', 'public');
                // Store file information in the database
                $eventData['file_name'] = $fileName;

                //## To display uploaded files  ##
                // storage_path('app/public/uploads')
                // $url = Storage::url("uploads/{$filename}");
            }
            if ($request->file('event_image')) {
                $image = $request->file('event_image');
                $imgFile = $image->getClientOriginalName();
                $filePath = $image->store('images', 'public');
                // Store file information in the database
                $eventData['image_file'] = $imgFile;

                //## To display uploaded files  ##
                // storage_path('app/public/uploads')
                // $url = Storage::url("uploads/{$filename}");
            }
            // echo '<pre>';
            // print_r($eventData);
            // exit;
            $events = Events::create($eventData);
        }
        if (isset($events)) {
            return redirect()->back()->with('success', 'Event have been saved.');
        }
        return view('general.add_event');
    }

    public function events_list()
    {
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        //$exam_type = isset($_POST['exam_type']) ? $_POST['exam_type'] : '';
        $academicYears = AcademicYear::select('academic_year')->get();
        // echo '<pre>';
        // print_r($academic_yr);
        // exit;
        // $academicYears = ImportantDays::groupBy('academic_year')
        //     ->pluck('academic_year', 'id');
        $events_list = [];

        //if ($academic_yr != '') {
        $events_list = Events::select('*')->get();
        // echo '<pre>';
        // print_r($news_list);
        // exit;


        // }
        return view('general.events_list', compact(['academicYears', 'events_list']));
    }
    public function add_forane_promoter()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $foranes = Forane::select('forane_id', 'forane_name')->get();
        $units = Units::select('unit_code', 'unit_name')->get();
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $unit = isset($_POST['unit']) ? $_POST['unit'] : '';
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
        $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';

        $academicYears = AcademicYear::select('academic_year')->get()->last()->toArray();
        if ($academic_yr != '') {
            $data = array(
                'academic_year' => $academic_yr,
                'title' => $title,
                'start_date' => $start_date,
                'end_date' => $end_date
            );
            $importnt_dates = ImportantDays::insert($data);
        }
        return view('general.add_forane', compact(['foranes', 'units']));
    }
    public function forane_promoter_list()
    {
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $academicYears = AcademicYear::select('academic_year')->get();
        $events_list = [];
        if ($academic_yr != '') {
            $forane_promoters_list = ForanePromoters::leftJoin('forane', 'forane.forane_code', '=', 'forane_promoters.forane_code')
                ->select('*')->get();
        }
        // echo '<pre>';
        // print_r($forane_promoters_list);
        // exit;
        return view('general.forane_promoter_list', compact(['academicYears', 'forane_promoters_list']));
    }
    public function forane_promoter_report()
    {
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $academicYears = AcademicYear::select('academic_year')->get();
        $forane_promoter_report = [];
        if ($academic_yr != '') {
            $forane_promoter_report = ForanePromoters::leftJoin('forane', 'forane.forane_code', '=', 'forane_promoters.forane_code')
                ->select('*')->where('forane_promoters.academic_year', $academic_yr)
                ->get();
        }
        // echo '<pre>';
        // print_r($forane_promoters_list);
        // exit;
        return view('general.forane_promoter_report', compact(['academicYears', 'forane_promoter_report']));
    }
    public function forane_management($id = '')
    {
        $foranes = Forane::select('forane_id', 'forane_name', 'display_order')->get();
        $units = Units::select('unit_code', 'unit_name')->get();
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $unit = isset($_POST['unit']) ? $_POST['unit'] : '';
        // echo '<pre>';
        // print_r($id);
        // exit;
        $divisions = '';
        if ($forane != '' && $unit != '') {
            $divisions = Divisions::where('unit_code', $unit)->get();
            // echo '<pre>';
            // print_r($divisions);
            // exit;
        }
        return view('general.forane_management', compact(['foranes', 'units', 'divisions']));
    }
    public function unit_list()
    {
        $forane_code = isset($_POST['forane']) ? $_POST['forane'] : '';
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $unit_list = [];
        if ($forane_code != '') {
            $unit_list = Units::where('forane_code', $forane_code)->get();
        }
        return view('general.unit_list', compact('foranes', 'unit_list'));
    }

    public function add_unit()
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $parishes = Parishes::select('parish_code', 'name')->get();
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $parish = isset($_POST['parish']) ? $_POST['parish'] : '';
        $unit_full_name = isset($_POST['unit_full_name']) ? $_POST['unit_full_name'] : '';
        $mobile_no = isset($_POST['mobile_no']) ? $_POST['mobile_no'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $fax = isset($_POST['fax']) ? $_POST['fax'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $address = isset($_POST['address']) ? $_POST['address'] : '';
        $place = isset($_POST['place']) ? $_POST['place'] : '';
        $post = isset($_POST['post']) ? $_POST['post'] : '';
        $pincode = isset($_POST['pincode']) ? $_POST['pincode'] : '';
        $district = isset($_POST['district']) ? $_POST['district'] : '';
        $state = isset($_POST['state']) ? $_POST['state'] : '';
        $mass_time = isset($_POST['mass_time']) ? $_POST['mass_time'] : '';
        $catechism_time = isset($_POST['catechism_time']) ? $_POST['catechism_time'] : '';
        $vicar_name = isset($_POST['vicar_name']) ? $_POST['vicar_name'] : '';
        $asst_vicar = isset($_POST['asst_vicar']) ? $_POST['asst_vicar'] : '';
        $motto = isset($_POST['motto']) ? $_POST['motto'] : '';
        $remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';

        if ($forane != '') {
            $data = array(
                'forane_code' => $forane,
                'parish_code' => $parish,
                'unit_name' => $unit_full_name,
                'mobile' => $mobile_no,
                'phone' => $phone,
                'fax' => $fax,
                'email' => $email,
                'unit_address' => $address,
                'place' => $place,
                'post' => $post,
                'pincode' => $pincode,
                'district' => $district,
                'state' => $state,
                'mass_time' => $mass_time,
                'cat_time' => $catechism_time,
                'unit_vicar' => $vicar_name,
                'contact_person' => $asst_vicar,
                'motto' => $motto,
                'remarks' => $remarks,

            );
            $catechism_units = Units::insert($data);
        }
        if (isset($catechism_units)) {
            return redirect()->back()->with('success', 'Classes have been saved.');
        }
        return view('general.add_unit', compact(['foranes', 'parishes']));
    }
    public function unit_address_report()
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $forane_code = isset($_POST['forane']) ? $_POST['forane'] : '';
        $unit_add_report = [];
        $unit_add_report = Units::select('*')->get();
        return view('general.unit_address_report', compact(['foranes', 'unit_add_report']));
    }
    public function unit_report()
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $forane_code = isset($_POST['forane']) ? $_POST['forane'] : '';
        $unit_code = isset($_POST['units']) ? $_POST['units'] : '';
        $forane_name = isset($_POST['forane_name']) ? $_POST['forane_name'] : '';
        $class_count = isset($_POST['class_count']) ? $_POST['class_count'] : '';
        $division_count = isset($_POST['division_count']) ? $_POST['division_count'] : '';
        $student_count = isset($_POST['student_count']) ? $_POST['student_count'] : '';
        $staff_count = isset($_POST['staff_count']) ? $_POST['staff_count'] : '';
        $hm_name = isset($_POST['hm_name']) ? $_POST['hm_name'] : '';
        $hm_contact = isset($_POST['hm_contact']) ? $_POST['hm_contact'] : '';
        $hm_sign = isset($_POST['hm_sign']) ? $_POST['hm_sign'] : '';
        $unit_add_report = [];
        $unit_add_report = DB::table('catechism_unit_details')
            ->leftJoin('staffs', 'catechism_unit_details.unit_code', '=', 'staffs.catechism_unit_code')
            ->leftJoin('students', 'catechism_unit_details.unit_code', '=', 'students.catechism_unit_code')
            ->leftJoin('division_master', 'catechism_unit_details.unit_code', '=', 'division_master.unit_code')
            ->leftJoin('forane', 'forane.forane_code', '=', 'catechism_unit_details.forane_code')
            ->leftJoin('staffs as st', function ($join) {
                $join->on('catechism_unit_details.unit_code', '=', 'st.catechism_unit_code');
                $join->whereRaw('st.cat_designation_id =3');
            })
            ->select(
                'catechism_unit_details.*',
                'forane.forane_name',
                'st.staff_name',
                DB::raw('COUNT(DISTINCT staffs.staff_id) as staff_count'),
                DB::raw('COUNT(DISTINCT students.student_id) as student_count'),
                DB::raw('COUNT(DISTINCT division_master.id) as division_count'),
            )
            ->where('catechism_unit_details.unit_code', $unit_code)
            ->groupBy('catechism_unit_details.unit_code')
            ->get();
        // echo '<pre>';
        // print_r($unit_add_report);
        // exit;
        $unit_report = [];
        foreach ($_POST as $key => $data) {
            if ($data != '' && $data == 1) {
                $unit_report[$key] = $unit_add_report[0]->{$key};
            }
        }
        return view('general.unit_report', compact(['foranes', 'unit_report']));
    }
    public function getUnits($forane)
    {
        $units = Units::select('unit_name', 'unit_code')->where('forane_code', $forane)->get();
        return response()->json($units);
    }
    public function getStaffs($forane)
    {
        $staffs = Staffs::select('staff_id', 'staff_name', 'staff_code')->where('forane_code', $forane)->get();
        return response()->json($staffs);
    }
    public function getStudents($forane)
    {
        $students = Students::select('student_id', 'student_name', 'student_code')->where('forane_code', $forane)->get();
        return response()->json($students);
    }
    public function unit_summary_report()
    {
        $units = Units::select('unit_code', 'unit_name')->get();
        $unit_code = isset($_POST['units']) ? $_POST['units'] : '';
        $unit_sum_report = [];
        $unit_sum_report = Units::leftJoin('forane', 'forane.forane_code', '=', 'catechism_unit_details.forane_code')
            ->leftJoin('staffs', 'catechism_unit_details.unit_code', '=', 'staffs.catechism_unit_code')
            ->select(
                'catechism_unit_details.*',
                'forane.forane_name',
                'staffs.staff_name',
                'staffs.permanent_address',
            )
            ->where('staffs.cat_designation_id', 3)
            ->where('catechism_unit_details.unit_code', $unit_code)
            ->get()->toArray();
        $unit_stu_report = Students::
            select(
                'class',
                DB::raw('COUNT(CASE WHEN sex = "male" THEN 1 END) as male_count'),
                DB::raw('COUNT(CASE WHEN sex = "female" THEN 1 END) as female_count'),
                DB::raw('COUNT(student_id) as student_count'),
                DB::raw('COUNT(DISTINCT division) as division_count')
            )
            ->where('catechism_unit_code', $unit_code)
            ->groupBy('class')
            ->get()->toArray();
        $unit_staf_report = Staffs::
            select(
                DB::raw('COUNT(CASE WHEN sex = "male" THEN 1 END) as male'),
                DB::raw('COUNT(CASE WHEN sex = "female" THEN 1 END) as female'),
                DB::raw('COUNT(staff_id) as staff_count')
            )
            ->where('catechism_unit_code', $unit_code)
            ->get()->toArray();

        return view('general.unit_summary_report', compact(['units', 'unit_sum_report', 'unit_stu_report', 'unit_staf_report']));
    }
    public function user_list()
    {
        $user_list = [];
        $user_list = Users::leftJoin('parishes', 'parishes.parish_code', '=', 'users.parish_code')
            ->leftJoin('user_role', 'user_role.code', '=', 'users.user_type')
            ->select('users.*', 'parishes.name as parish_name', 'user_role.user_role')
            ->where('status', 1)
            ->get();
        // echo '<pre>';
        // print_r($user_list);
        // exit;
        return view('general.user_list', compact('user_list'));
    }
    public function add_user()
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $parishes = Parishes::select('parish_code', 'name')->get();
        $usertype = UserRole::select('user_role', 'code')->get();
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();

        if ($_POST) {
            $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
            $parish = isset($_POST['parish']) ? $_POST['parish'] : '';
            $full_name = isset($_POST['full_name']) ? $_POST['full_name'] : '';
            $mobile_no = isset($_POST['mobile_no']) ? $_POST['mobile_no'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
            $pass = isset($_POST['password']) ? $_POST['password'] : '';
            $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
            $unit_type = isset($_POST['unit_type']) ? $_POST['unit_type'] : '';
            $units = isset($_POST['units']) ? $_POST['units'] : $_POST['school'];
            if ($units == '') {
                $units = $_POST['school'];
            }
            // echo '<pre>';
            // print_r($units);
            // exit;
            //   $school = isset($_POST['units']) ? $_POST['school'] : '';
            $usertype = isset($_POST['usertype']) ? $_POST['usertype'] : '';
            $status = isset($_POST['status']) ? $_POST['status'] : '';
            if ($pass == $confirm_password) {
                $data = array(
                    'forane_code' => $forane,
                    'parish_code' => $parish,
                    'name' => $full_name,
                    'mobile' => $mobile_no,
                    'email' => $email,
                    'username' => $user_name,
                    'password' => Hash::make($pass),
                    'unit_code' => $units,
                    'user_type' => $usertype
                );
                // echo '<pre>';
                // print_r($data);
                // exit;
                $catechism_users = Users::where('username', $user_name)->update($data);
            } else {
                return redirect()->back()->with('success', 'Re-enter the password');
            }
        }
        if (isset($catechism_users)) {
            return redirect()->back()->with('success', 'Data have been updated');

        }
        return view('general.add_user', compact(['foranes', 'parishes', 'usertype', 'schools']));
    }
    public function attendance_edit_reasons()
    {
        $reason = isset($_POST['reason']) ? $_POST['reason'] : '';
        $display_order = isset($_POST['order']) ? $_POST['order'] : 0;
        if ($reason != '') {
            $data = array(
                'reason' => $reason,
                'display_order' => $display_order,
                'updated_date' => Carbon::now()->format('d-m-Y'),
                'inserted_date' => Carbon::now()->format('d-m-Y')
            );
            $attendande_edit = AttendanceEditReasons::insert($data);
        }
        if (isset($attendande_edit)) {
            return redirect()->back()->with('success', 'Edited Attendance have been saved.');
        }
        $at_ed_reasons = [];
        $at_ed_reasons = AttendanceEditReasons::select('*')
            ->get();

        return view('general.attendance_edit_reasons', compact('at_ed_reasons'));
    }
    public function family_unit()
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $usertype = UserRole::select('user_role', 'code')->get();
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();
        // echo '<pre>';
        // print_r($_POST['school']);
        // exit;
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $parish = isset($_POST['parish']) ? $_POST['parish'] : '';
        $family_unit_name = isset($_POST['family_unit_name']) ? $_POST['family_unit_name'] : '';
        $units = isset($_POST['units']) ? $_POST['units'] : '';
        if ($units == '') {
            $units = isset($_POST['school']) ? $_POST['school'] : '';
        }
        if ($family_unit_name != '') {
            $data = array(
                'unit_code' => $units,
                'family_unit_name' => $family_unit_name,
                'updated_date' => Carbon::now()->format('d-m-Y'),
                'inserted_date' => Carbon::now()->format('d-m-Y')
            );
            $family_unit_add = FamilyUnits::insert($data);
        }
        if (isset($family_unit_add)) {
            return redirect()->back()->with('success', 'Family unit have been saved.');
        }
        $family_units_data = [];
        $family_units_data = FamilyUnits::select('family_units.*', 'catechism_unit_details.unit_name')
            ->leftJoin('catechism_unit_details', 'catechism_unit_details.unit_code', '=', 'family_units.unit_code')
            ->get();
        // echo '<pre>';
        // print_r($family_units_data);
        // exit;
        return view('general.family_unit', compact('family_units_data', 'foranes', 'schools'));
    }
    public function designation_management()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $designation = isset($_POST['designation']) ? $_POST['designation'] : '';
        $show_order = isset($_POST['order']) ? $_POST['order'] : '';
        if ($designation != '') {
            $data = array(
                'designation' => $designation,
                'show_order' => $show_order,
                'updated_date' => Carbon::now()->format('d-m-Y'),
                'inserted_date' => Carbon::now()->format('d-m-Y')
            );
            $designations = CatechismDesignations::insert($data);
        }
        if (isset($designations)) {
            return redirect()->back()->with('success', 'Designation have been saved.');
        }
        $designations_data = [];
        $designations_data = CatechismDesignations::select('*')
            ->get();
        // echo '<pre>';
        // print_r($designations_data);
        // exit;
        return view('general.designations', compact('designations_data'));
    }
    public function job_categories()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $job_category = isset($_POST['job_category']) ? $_POST['job_category'] : '';
        $show_order = isset($_POST['order']) ? $_POST['order'] : '';
        if ($job_category != '') {
            $data = array(
                'cat_name' => $job_category,
                'cat_order' => $show_order,
                'updated_date' => Carbon::now()->format('d-m-Y'),
                'inserted_date' => Carbon::now()->format('d-m-Y')
            );
            $job_category = JobCategories::insert($data);
        }
        if (isset($job_category)) {
            return redirect()->back()->with('success', 'Job category have been saved.');
        }
        $category_data = [];
        $category_data = JobCategories::select('*')
            ->get();
        return view('general.job_categories', compact('category_data'));
    }
    public function job_titles()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $JobCategory = JobCategories::select('cat_name', 'cat_id')->get();
        $job_name = isset($_POST['job_name']) ? $_POST['job_name'] : '';
        $job_category = isset($_POST['job_category']) ? $_POST['job_category'] : '';
        $show_order = isset($_POST['order']) ? $_POST['order'] : '';
        if ($job_name != '') {
            $data = array(
                'job_name' => $job_name,
                'job_cat_id' => $job_category,
                'show_order' => $show_order,
                'updated_date' => Carbon::now()->format('d-m-Y'),
                'inserted_date' => Carbon::now()->format('d-m-Y')
            );
            $job_details = Jobs::insert($data);
        }
        if (isset($job_details)) {
            return redirect()->back()->with('success', 'Job details have been saved.');
        }
        $job_data = [];
        $job_data = Jobs::select('jobs.*', 'job_categories.cat_name')
            ->leftJoin('job_categories', 'job_categories.cat_id', '=', 'jobs.job_cat_id')
            ->get();
        return view('general.jobs', compact('job_data', 'JobCategory'));
    }
    public function qualification_management()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $qualification = isset($_POST['qualification']) ? $_POST['qualification'] : '';
        $qualification_type = isset($_POST['qualification_type']) ? $_POST['qualification_type'] : '';
        $show_order = isset($_POST['order']) ? $_POST['order'] : '';
        if ($qualification != '') {
            $data = array(
                'qualification' => $qualification,
                'category' => $qualification_type,
                'show_order' => $show_order,
                'updated_date' => Carbon::now()->format('d-m-Y'),
                'inserted_date' => Carbon::now()->format('d-m-Y')
            );
            $qualifications = Qualifications::insert($data);
        }
        if (isset($qualifications)) {
            return redirect()->back()->with('success', 'qualification have been saved.');
        }
        $qualifications_data = [];
        $qualifications_data = Qualifications::select('*')
            ->get();
        // echo '<pre>';
        // print_r($qualifications_data);
        // exit;
        return view('general.qualifications', compact('qualifications_data'));
    }
    public function name_titles()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $name_title = isset($_POST['name_title']) ? $_POST['name_title'] : '';
        $show_order = isset($_POST['order']) ? $_POST['order'] : '';
        if ($name_title != '') {
            $data = array(
                'title' => $name_title,
                'show_order' => $show_order,
                'updated_date' => Carbon::now()->format('d-m-Y'),
                'inserted_date' => Carbon::now()->format('d-m-Y')
            );
            $name_titles = NameTitles::insert($data);
        }
        if (isset($name_titles)) {
            return redirect()->back()->with('success', 'name titles have been saved.');
        }
        $name_title_data = [];
        $name_title_data = NameTitles::select('*')
            ->get();
        return view('general.name_titles', compact('name_title_data'));
    }
    public function pious_associations()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $pious_assoc_name = isset($_POST['pious_assoc_name']) ? $_POST['pious_assoc_name'] : '';
        if ($pious_assoc_name != '') {
            $data = array(
                'name' => $pious_assoc_name,
                'updated_date' => Carbon::now()->format('d-m-Y'),
                'inserted_date' => Carbon::now()->format('d-m-Y')
            );
            $pious_assoc = PiousAssoc::insert($data);
        }
        if (isset($pious_assoc)) {
            return redirect()->back()->with('success', 'pious association name have been saved.');
        }
        $pious_assoc_data = [];
        $pious_assoc_data = PiousAssoc::select('*')
            ->get();
        return view('general.pious_associations', compact('pious_assoc_data'));
    }
    public function add_authority()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $academicYears = AcademicYear::select('academic_year')->get()->last()->toArray();
        $academic_year = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $authority_name = isset($_POST['authority_name']) ? $_POST['authority_name'] : '';
        $duration = isset($_POST['duration']) ? $_POST['duration'] : '';
        $unit_member = isset($_POST['unit_member']) ? $_POST['unit_member'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : '';

        if ($authority_name != '') {
            $data = array(
                'academic_year' => $academic_year,
                'authority_name' => $authority_name,
                'duration' => $duration,
                'unit_entry' => $unit_member,
                'status' => $status,
            );
            $catechism_authorities = CatechismAuthorities::insert($data);
        }
        if (isset($catechism_authorities)) {
            return redirect()->back()->with('success', 'Authority details have been saved.');
        }
        return view('general.add_authority', compact('academicYears'));
    }
    public function authority_list()
    {
        $status = isset($_POST['status']) ? $_POST['status'] : '';

        $authorities = [];

        if ($status != '') {
            $authorities = CatechismAuthorities::where('status', $status)->get();
            // echo '<pre>';
            // print_r($authorities);
            // exit;
        }

        return view('general.authority_list', compact(['authorities']));
    }
    public function authority_report()
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        $authorities = CatechismAuthorities::select('authority_name', 'id')->get();
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $religi_lai = isset($_POST['religi_lai']) ? $_POST['religi_lai'] : '';
        $unit_code = isset($_POST['units']) ? $_POST['units'] : '';
        $authority = isset($_POST['authority']) ? $_POST['authority'] : '';
        $designations = isset($_POST['designations']) ? $_POST['designations'] : '';
        $gender = isset($_POST['gender']) ? $_POST['gender'] : '';

        $forane_name = isset($_POST['forane_name']) ? $_POST['forane_name'] : '';
        $member_name = isset($_POST['member_name']) ? $_POST['member_name'] : '';
        $member_category = isset($_POST['category']) ? $_POST['category'] : '';
        $unit_name = isset($_POST['unit_name']) ? $_POST['unit_name'] : '';
        $designation = isset($_POST['designation']) ? $_POST['designation'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $mobile_no = isset($_POST['mobile_no']) ? $_POST['mobile_no'] : '';
        $gend = isset($_POST['gend']) ? $_POST['gend'] : '';
        $religious_laity = isset($_POST['religious_laity']) ? $_POST['religious_laity'] : '';
        $duration = isset($_POST['duration']) ? $_POST['duration'] : '';
        $hm_sign = isset($_POST['hm_sign']) ? $_POST['hm_sign'] : '';

        $catechism_authority_report = [];
        $catechism_authority_report = DB::table('catechism_authority_members')
            ->leftJoin('catechism_unit_details', 'catechism_authority_members.unit_code', '=', 'catechism_unit_details.unit_code')
            ->select(
                'catechism_authority_members.*',
                'catechism_unit_details.unit_name'
            );

        if ($authority && $authority != '') {
            $catechism_authority_report->where('authority_id', $authority);
        }

        if ($designations && $designations != '') {
            $catechism_authority_report->where('designation', $designations);
        }

        if ($gender && $gender != '') {
            $catechism_authority_report->where('gender', $gender);
        }

        if ($unit_code && $unit_code != '') {
            $catechism_authority_report->where('unit_code1', $unit_code);
        }

        if ($religi_lai && $religi_lai != '') {
            $catechism_authority_report->where('religious_laity', $religi_lai);
        }

        $catechism_authority_report = $catechism_authority_report->get();
        $authority_report = [];
        if ($unit_code != '' || $authority != '' || $designations != '' || $gender != '') {
            foreach ($catechism_authority_report as $k => $row) {
                foreach ($_POST as $key => $data) {
                    if ($data != '' && $data == 1) {
                        // echo '<pre>';
                        // print_r($row);
                        // exit;
                        $authority_report[$k][$key] = $row->{$key};
                    }
                }
            }
        }
        // echo '<pre>';
        // print_r($authority_report);
        // exit;
        return view('general.authority_report', compact(['authorities', 'foranes', 'authority_report']));
    }
    public function getDesignations($authority)
    {
        $designation = CatechismAuthorityMembers::select('designation')->where('authority_id', $authority)->get();
        return response()->json($designation);
    }
    public function add_urgent_notifications()
    {
        $notification = isset($_POST['notification']) ? $_POST['notification'] : '';

        if ($notification != '') {
            $data = array(
                'notification' => $notification,
                'inserted_date' => Carbon::now()->format('d-m-Y')
            );
            $add_notification = UrgentNotifications::insert($data);
        }

        if (isset($add_notification)) {
            return redirect()->back()->with('success', 'Urgent notification have been saved.');
        }
        return view('general.add_urgent_notifications');
    }
    public function getDivisions($classes)
    {
        $dvns = ClassMaster::select('division', 'class')->where('class', $classes)->get();
        $divisions_arr = explode(',', $dvns[0]['division']);
        foreach ($divisions_arr as $key => $value) {
            $divisions[]['division'] = $value;
        }
        // echo '<pre>';
        // print_r($);
        // exit;
        return response()->json($divisions);
    }
}