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
use App\Models\NameTitles;
use App\Models\ContactClass;
use App\Models\StaffsAttendance;
use App\Models\Months;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class StaffsController extends Controller
{
    public function staff_list()
    {
        // echo '<pre>';
        // print_r("hu");
        // exit;
        $foranes = Forane::select('forane_name', 'forane_code')->get();
        $parishes = Parishes::select('name', 'parish_code')->get();
        $designations = CatechismDesignations::select('designation', 'id')
            ->get();
        $JobCategory = JobCategories::select('cat_name', 'cat_id')->get();
        $JobTitles = Jobs::select('job_name', 'job_id')->get();
        $years = range(2000, date('Y'));
        $Experience_range = range(0, 55);
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
        $age_from = null; // Replace with your logic to get the current 'age_from'
        $age_to = null; // Replace with your logic to get the current 'age_to'
        return view('general.staffs.staff_list', compact('foranes', 'parishes', 'designations', 'JobCategory', 'districts', 'selectedDistrict', 'catechismUnits', 'healthStatus', 'selectedhealthStatus', 'classes', 'pious_assoc', 'age_from', 'age_to', 'JobTitles', 'years', 'Experience_range'));
    }
    public function staff_summary_report()
    {
        // echo '<pre>';
        // print_r("hu");
        // exit;
        $foranes = Forane::select('forane_name', 'forane_code')->get();
        $forane_code = isset($_POST['forane']) ? $_POST['forane'] : '';
        $staff_summary = '';
        if ($forane_code) {
            $staff_summary = Staffs::select(
                'catechism_designations.designation as designation_name',
                'staffs.cat_designation_id',
                DB::raw('COUNT(*) as total')
            )
                ->join('catechism_designations', 'staffs.cat_designation_id', '=', 'catechism_designations.id')
                ->where('staffs.forane_code', $forane_code)
                ->groupBy('staffs.cat_designation_id', 'catechism_designations.designation') // Group by both columns to avoid SQL errors
                ->orderBy('total', 'desc') // Optional: Order by count
                ->get();
            // echo '<pre>';
            // print_r($staff_summary);
            // exit;
        }

        return view('general.staffs.staff_summary_report', compact('foranes', 'staff_summary'));
    }
    public function cancel_tc_list(Request $request)
    {
        $data['cat_units'] = CatechismUnitDetails::pluck('unit_name', 'unit_code');
        $data['action_type'] = 'Load';
        $data['unit_code'] = '';

        if ($request->unit_code) {

            $unit_code = $request->unit_code;
            // dd($unit_code);


            $data['transfered_staffs'] = StaffTransferDetails::select('staff_transfer_details.transfer_id', 'staff_transfer_details.transfer_reason', 'staff_transfer_details.to_unit_code', 'staff_transfer_details.staff_name', 'catechism_unit_details.unit_name as to_unit_name')
                ->join('catechism_unit_details', 'staff_transfer_details.to_unit_code', '=', 'catechism_unit_details.unit_code')

                ->where('from_unit_code', $unit_code)
                ->where('register_in_unit', '0')->orderBy('staff_name', 'ASC')->get();
            // dd($data['active_staffs']);
            // echo '<pre>';
            // print_r($data['transfered_staffs']);
            // exit;
            $data['action_type'] = 'Save';
        }
        return view('general.staffs.cancel_tc', $data);
    }
    public function cancelTC($transfer_id)
    {
        // echo '<pre>';
        // print_r($transfer_id);
        // exit;
        $updated_date = date('Y-m-d H:i:s');
        $transfer_row = StaffTransferDetails::select('staff_id', 'from_unit_code')
            ->where('transfer_id', $transfer_id)->first();
        if ($transfer_row) {
            // echo '<pre>';
            // print_r($transfer_row['staff_id']);
            // exit;
            $update_staffs = Staffs::where('staff_id', $transfer_row['staff_id'])->update(['status' => '0', 'updated_date' => $updated_date]);
            $notattnd_row = StaffNotAttending::where('staff_id', $transfer_row['staff_id'])->get();
            // echo '<pre>';
            // print_r($notattnd_row);
            // exit;
            if ($notattnd_row) {
                $update_notattnd = StaffNotAttending::where('staff_id', $transfer_row['staff_id'])->delete();
            }
            $delete_stafftransfer = StaffTransferDetails::where('transfer_id', $transfer_id)->delete();

        }
        // Handle the request with $unit_code
        if ($update_staffs) {
            return redirect()->back()->with('success', 'TC canceled successfully!');
        } else {
            return response()->json(['message' => 'TC is not canceled']);

        }
    }
    public function staff_transfer_list()
    {
        // echo '<pre>';
        // print_r("hu");
        // exit;

        $foranes = Forane::select('forane_name', 'forane_code')->get();
        $parishes = Parishes::select('name', 'parish_code')->get();
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();
        $academicYears = AcademicYear::select('*')->get();
        $catechismUnits = CatechismUnitDetails::where('status', '1')
            ->where('unit_type', 'Parish')
            ->orderBy('unit_name', 'asc')
            ->get();
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $unit_type = isset($_POST['unit_type']) ? $_POST['unit_type'] : '';
        $units = isset($_POST['units']) ? $_POST['units'] : '';
        if ($units == '') {
            $units = isset($_POST['school']) ? $_POST['school'] : '';
        }
        $trans_list = '';
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        if ($academic_yr != '') {
            $trans_list = StaffTransferDetails::select('staff_transfer_details.transfer_id', 'staff_transfer_details.date_of_transfer', 'staff_transfer_details.to_unit_code', 'staff_transfer_details.staff_name', 'catechism_unit_details.unit_name as to_unit_name')
                ->join('catechism_unit_details', 'staff_transfer_details.to_unit_code', '=', 'catechism_unit_details.unit_code')
            ;
            if ($units && $units != '') {
                $trans_list->where('from_unit_code', $units);
            }
            if ($forane && $forane != '') {
                $trans_list->where('from_forane_code', $forane);
            }
            if ($academic_yr && $academic_yr != '') {
                $trans_list->where('transfer_year', $academic_yr);
            }
            $trans_list = $trans_list->get();

            // echo '<pre>';
            // print_r($trans_list);
            // exit;
        }

        return view('general.staffs.staff_transfer_list', compact('foranes', 'academicYears', 'schools', 'catechismUnits', 'trans_list'));
    }
    public function staff_list_report(Request $request)
    {
        // echo '<pre>';
        // print_r($_POST);
        // exit;
        if ($_POST) {
            $Validate = $request->validate([
                'forane' => 'required|max:255',
                'units' => 'required|max:255',
            ]);
        }
        $forane_code = isset($_POST['forane']) ? $_POST['forane'] : '';
        $units = isset($_POST['units']) ? $_POST['units'] : '';
        // if ($units == '') {
        //     $units = isset($_POST['school']) ? $_POST['school'] : '';
        // }
        // $unit_code = isset($_POST['units']) ? $_POST['units'] : '';
        $class = isset($_POST['curr_class']) ? $_POST['curr_class'] : '';
        $genders = isset($_POST['genders']) ? $_POST['genders'] : '';
        $dob_from = isset($_POST['dob_from']) ? $_POST['dob_from'] : '';
        $dob_to = isset($_POST['dob_to']) ? $_POST['dob_to'] : '';
        $status = isset($_POST['stat']) ? $_POST['stat'] : '';
        $age_from = isset($_POST['age_from']) ? $_POST['age_from'] : '';
        $age_to = isset($_POST['age_to']) ? $_POST['age_to'] : '';
        $contact_class = isset($_POST['cont_class']) ? $_POST['cont_class'] : '';
        $ctc_year = isset($_POST['ctc_year']) ? $_POST['ctc_year'] : '';
        $adm_no = isset($_POST['adm_no']) ? $_POST['adm_no'] : '';
        $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
        $student_diocese = isset($_POST['stud_dioc']) ? $_POST['stud_dioc'] : '';
        $job_title = isset($_POST['job_title']) ? $_POST['job_title'] : '';
        $job_category = isset($_POST['job_category']) ? $_POST['job_category'] : '';
        $religi_lai = isset($_POST['religi_lai']) ? $_POST['religi_lai'] : '';
        $member_code = isset($_POST['mem_code']) ? $_POST['mem_code'] : '';
        $designation = isset($_POST['designation']) ? $_POST['designation'] : '';
        $student_forane = isset($_POST['forane_code']) ? $_POST['forane_code'] : '';
        $post = isset($_POST['post']) ? $_POST['post'] : '';
        $staf_name = isset($_POST['staf_name']) ? $_POST['staf_name'] : '';
        $curr_age = isset($_POST['age']) ? $_POST['age'] : '';
        $cate_unit = isset($_POST['catechism_unit_code']) ? $_POST['catechism_unit_code'] : '';
        $contact_class = isset($_POST['contact_class']) ? $_POST['contact_class'] : '';
        $secu_qualification = isset($_POST['secu_qualification']) ? $_POST['secu_qualification'] : '';
        $relig_qualification = isset($_POST['relig_qualification']) ? $_POST['relig_qualification'] : '';
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
        $secularQualification = Qualifications::select('id', 'qualification')
            ->where('category', 'Secular')
            ->orderBy('id', 'asc')
            ->get();
        $religiousQualification = Qualifications::select('id', 'qualification')
            ->where('category', 'Religious')
            ->orderBy('id', 'asc')
            ->get();
        $designations = CatechismDesignations::select('designation', 'id')
            ->get();
        $JobCategory = JobCategories::select('cat_name', 'cat_id')->get();
        $JobTitles = Jobs::select('job_name', 'job_id')->get();
        $years = range(2000, date('Y'));
        $age_range = range(0, 55);
        $selectedhealthStatus = 'Healthy';
        // if ($forane_code != '' && $units != '') {
        $staffs = Staffs::query();

        if (isset($_POST['forane']) ? $_POST['forane'] : '') {
            $staffs->where('forane_code', $_POST['forane']);
        }
        if (isset($_POST['units']) ? $_POST['units'] : '') {
            $staffs->where('catechism_unit_code', $_POST['units']);
        }

        if (isset($_POST['religi_lai']) ? $_POST['religi_lai'] : '') {
            $staffs->where('religios_laity', $_POST['religi_lai']);
        }

        if (isset($_POST['cat_designation_id']) ? $_POST['cat_designation_id'] : '') {
            $staffs->where('division', $_POST['designation']);
        }

        if (isset($_POST['gender']) ? $_POST['gender'] : '') {
            $staffs->where('sex', $_POST['gender']);
        }
        if (isset($_POST['job_category']) ? $_POST['job_category'] : '') {
            $staffs->where('job_category', $_POST['job_category']);
        }

        if (isset($_POST['job_title']) ? $_POST['job_title'] : '') {
            $staffs->where('job_title', $_POST['job_title']);
        }
        if (isset($_POST['dob_from']) ? $_POST['dob_from'] : '') {
            $staffs->where('dob_from', $_POST['dob_from']);
        }
        if (isset($_POST['dob_to']) ? $_POST['dob_to'] : '') {
            $staffs->where('dob_to', $_POST['dob_to']);
        }
        if (isset($_POST['stat']) ? $_POST['stat'] : '') {
            $staffs->where('status', '1');
        }
        if (isset($_POST['age_from']) ? $_POST['age_from'] : '') {
            $staffs->where('age_from', $_POST['age_from']);
        }
        if (isset($_POST['age_to']) ? $_POST['age_to'] : '') {
            $staffs->where('age_to', $_POST['age_to']);
        }
        if (isset($_POST['cont_class']) ? $_POST['cont_class'] : '') {
            $staffs->where('contact_class', $_POST['cont_class']);
        }
        if (isset($_POST['ctc_year']) ? $_POST['ctc_year'] : '') {
            $staffs->where('ctc_year', $_POST['ctc_year']);
        }
        if (isset($_POST['secu_qualification']) ? $_POST['secu_qualification'] : '') {
            $staffs->where('secular_qualification', $_POST['secu_qualification']);
        }
        if (isset($_POST['relig_qualification']) ? $_POST['relig_qualification'] : '') {
            $staffs->where('religious_qualification', $_POST['relig_qualification']);
        }
        if (isset($_POST['staf_name']) ? $_POST['staf_name'] : '') {
            $staffs->where('staff_name', 'like', '%' . $_POST['staf_name'] . '%');
        }
        $staffs = $staffs->get();
        // echo '<pre>';
        // print_r($staffs);
        // exit;
        $staffs_report = [];
        foreach ($staffs as $k => $row) {
            foreach ($_POST as $key => $data) {
                if ($data != '' && $data == 1) {
                    $staffs_report[$k][$key] = $row->{$key};
                }
            }
        }
        // echo '<pre>';
        // print_r($unit_name);
        // exit;
        return view('general.staffs.staff_list_report', compact('foranes', 'parishes', 'staffs_report', 'usertype', 'schools', 'classes', 'selectedhealthStatus', 'classes', 'designations', 'forane_name', 'unit_name', 'academicYear', 'JobCategory', 'JobTitles', 'years', 'age_range', 'secularQualification', 'religiousQualification'));

    }
    public function staff_list_without_header(Request $request)
    {
        if ($_POST) {
            $Validate = $request->validate([
                'forane' => 'required|max:255',
                'units' => 'required|max:255',
            ]);
        }
        $forane_code = isset($_POST['forane']) ? $_POST['forane'] : '';
        $units = isset($_POST['units']) ? $_POST['units'] : '';
        // if ($units == '') {
        //     $units = isset($_POST['school']) ? $_POST['school'] : '';
        // }
        // $unit_code = isset($_POST['units']) ? $_POST['units'] : '';
        $class = isset($_POST['curr_class']) ? $_POST['curr_class'] : '';
        $genders = isset($_POST['genders']) ? $_POST['genders'] : '';
        $dob_from = isset($_POST['dob_from']) ? $_POST['dob_from'] : '';
        $dob_to = isset($_POST['dob_to']) ? $_POST['dob_to'] : '';
        $status = isset($_POST['stat']) ? $_POST['stat'] : '';
        $age_from = isset($_POST['age_from']) ? $_POST['age_from'] : '';
        $age_to = isset($_POST['age_to']) ? $_POST['age_to'] : '';
        $contact_class = isset($_POST['cont_class']) ? $_POST['cont_class'] : '';
        $ctc_year = isset($_POST['ctc_year']) ? $_POST['ctc_year'] : '';
        $adm_no = isset($_POST['adm_no']) ? $_POST['adm_no'] : '';
        $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
        $student_diocese = isset($_POST['stud_dioc']) ? $_POST['stud_dioc'] : '';
        $job_title = isset($_POST['job_title']) ? $_POST['job_title'] : '';
        $job_category = isset($_POST['job_category']) ? $_POST['job_category'] : '';
        $religi_lai = isset($_POST['religi_lai']) ? $_POST['religi_lai'] : '';
        $member_code = isset($_POST['mem_code']) ? $_POST['mem_code'] : '';
        $designation = isset($_POST['designation']) ? $_POST['designation'] : '';
        $student_forane = isset($_POST['forane_code']) ? $_POST['forane_code'] : '';
        $post = isset($_POST['post']) ? $_POST['post'] : '';
        $staf_name = isset($_POST['staf_name']) ? $_POST['staf_name'] : '';
        $curr_age = isset($_POST['age']) ? $_POST['age'] : '';
        $cate_unit = isset($_POST['catechism_unit_code']) ? $_POST['catechism_unit_code'] : '';
        $contact_class = isset($_POST['contact_class']) ? $_POST['contact_class'] : '';
        $secu_qualification = isset($_POST['secu_qualification']) ? $_POST['secu_qualification'] : '';
        $relig_qualification = isset($_POST['relig_qualification']) ? $_POST['relig_qualification'] : '';
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
        $secularQualification = Qualifications::select('id', 'qualification')
            ->where('category', 'Secular')
            ->orderBy('id', 'asc')
            ->get();
        $religiousQualification = Qualifications::select('id', 'qualification')
            ->where('category', 'Religious')
            ->orderBy('id', 'asc')
            ->get();
        $designations = CatechismDesignations::select('designation', 'id')
            ->get();
        $JobCategory = JobCategories::select('cat_name', 'cat_id')->get();
        $JobTitles = Jobs::select('job_name', 'job_id')->get();
        $years = range(2000, date('Y'));
        $age_range = range(0, 55);
        $selectedhealthStatus = 'Healthy';
        // if ($forane_code != '' && $units != '') {
        $staffs = Staffs::query();

        if (isset($_POST['forane']) ? $_POST['forane'] : '') {
            $staffs->where('forane_code', $_POST['forane']);
        }
        if (isset($_POST['units']) ? $_POST['units'] : '') {
            $staffs->where('catechism_unit_code', $_POST['units']);
        }

        if (isset($_POST['religi_lai']) ? $_POST['religi_lai'] : '') {
            $staffs->where('religious_laity', $_POST['religi_lai']);
        }

        if (isset($_POST['cat_designation_id']) ? $_POST['cat_designation_id'] : '') {
            $staffs->where('division', $_POST['designation']);
        }

        if (isset($_POST['gender']) ? $_POST['gender'] : '') {
            $staffs->where('sex', $_POST['gender']);
        }
        if (isset($_POST['job_category']) ? $_POST['job_category'] : '') {
            $staffs->where('job_category', $_POST['job_category']);
        }

        if (isset($_POST['job_title']) ? $_POST['job_title'] : '') {
            $staffs->where('job_title', $_POST['job_title']);
        }
        if (isset($_POST['dob_from']) ? $_POST['dob_from'] : '') {
            $staffs->where('dob_from', $_POST['dob_from']);
        }
        if (isset($_POST['dob_to']) ? $_POST['dob_to'] : '') {
            $staffs->where('dob_to', $_POST['dob_to']);
        }
        if (isset($_POST['stat']) ? $_POST['stat'] : '') {
            $staffs->where('status', '1');
        }
        if (isset($_POST['age_from']) ? $_POST['age_from'] : '') {
            $staffs->where('age_from', $_POST['age_from']);
        }
        if (isset($_POST['age_to']) ? $_POST['age_to'] : '') {
            $staffs->where('age_to', $_POST['age_to']);
        }
        if (isset($_POST['cont_class']) ? $_POST['cont_class'] : '') {
            $staffs->where('contact_class', $_POST['cont_class']);
        }
        if (isset($_POST['ctc_year']) ? $_POST['ctc_year'] : '') {
            $staffs->where('ctc_year', $_POST['ctc_year']);
        }
        if (isset($_POST['secu_qualification']) ? $_POST['secu_qualification'] : '') {
            $staffs->where('secular_qualification', $_POST['secu_qualification']);
        }
        if (isset($_POST['relig_qualification']) ? $_POST['relig_qualification'] : '') {
            $staffs->where('religious_qualification', $_POST['relig_qualification']);
        }
        if (isset($_POST['staf_name']) ? $_POST['staf_name'] : '') {
            $staffs->where('staff_name', 'like', '%' . $_POST['staf_name'] . '%');
        }
        $staffs = $staffs->get();
        // echo '<pre>';
        // print_r($staffs);
        // exit;
        $staffs_report = [];
        foreach ($staffs as $k => $row) {
            foreach ($_POST as $key => $data) {
                if ($data != '' && $data == 1) {
                    $staffs_report[$k][$key] = $row->{$key};
                }
            }
        }
        return view('general.staffs.staff_list_without_header', compact('foranes', 'parishes', 'staffs_report', 'usertype', 'schools', 'classes', 'selectedhealthStatus', 'classes', 'designations', 'forane_name', 'unit_name', 'academicYear', 'JobCategory', 'JobTitles', 'years', 'age_range', 'secularQualification', 'religiousQualification'));
    }

    public function staff_transfer()
    {
        // echo '<pre>';
        // print_r("hu");
        // exit;

        $foranes = Forane::select('forane_name', 'forane_code')->get();
        $parishes = Parishes::select('name', 'parish_code')->get();
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();
        $academicYears = AcademicYear::select('*')->get();
        $catechismUnits = CatechismUnitDetails::where('status', '1')
            ->orderBy('unit_name', 'asc')
            ->get();
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $staff_code = isset($_POST['staff_name']) ? $_POST['staff_name'] : '';
        $transfer_reason = isset($_POST['transfer_reason']) ? $_POST['transfer_reason'] : '';
        $transfer_date = isset($_POST['transfer_date']) ? $_POST['transfer_date'] : '';
        $to_unit = isset($_POST['catechism_unit']) ? $_POST['catechism_unit'] : '';
        $unit_type = isset($_POST['unit_type']) ? $_POST['unit_type'] : '';
        $units = isset($_POST['units']) ? $_POST['units'] : '';
        if ($units == '') {
            $units = isset($_POST['school']) ? $_POST['school'] : '';
        }
        $trans_list = '';
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';

        $staffs = Staffs::where('staff_code', $staff_code);
        $staff_name = $staffs->first('staff_name');
        $staff_id = $staffs->first('staff_id');

        if ($_POST) {
            $data = array(
                'transfer_year' => '2025-2026',
                'from_unit_code' => $units,
                'to_unit_code' => $to_unit,
                'date_of_transfer' => $transfer_date,
                'from_forane_code' => $forane,
                'staff_id' => $staff_id['staff_id'],
                'staff_code' => $staff_code,
                'staff_name' => $staff_name['staff_name'],
                'transfer_reason' => $transfer_reason
            );
            // echo '<pre>';
            // print_r($data);
            // exit;
            $transfer_staff = StaffTransferDetails::insert($data);
            if ($transfer_staff) {
                return redirect()->back()->with('success', 'Transfer issued successfully!');
            } else {
                return response()->json(['message' => 'TC is not canceled']);

            }
        }


        // echo '<pre>';
        // print_r($catechismUnits);
        // exit;
        return view('general.staffs.staff_transfer', compact('foranes', 'academicYears', 'schools', 'catechismUnits', 'trans_list'));
    }
    public function staff_register()
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

        $nameTitles = NameTitles::select('*')
            ->get();
        $familyUnits = FamilyUnits::select('unit_code', 'family_unit_name')->get();
        $designations = CatechismDesignations::select('designation', 'id')
            ->get();
        $secularQualification = Qualifications::select('id', 'qualification')
            ->where('category', 'Secular')
            ->orderBy('id', 'asc')
            ->get();
        $religiousQualification = Qualifications::select('id', 'qualification')
            ->where('category', 'Religious')
            ->orderBy('id', 'asc')
            ->get();
        $JobCategory = JobCategories::select('cat_name', 'cat_id')->get();
        $JobTitles = Jobs::select('job_name', 'job_id')->get();
        $years = range(2000, date('Y'));
        $CTCbatch = ContactClass::select('*')->get();

        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        //$criterias = StudentsExtraOrdinaryCriteriaType::get();
        $students = '';
        // echo '<pre>';
        // print_r($CTCbatch);
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
        return view('general.staffs.staff_register', compact(['academicYears', 'foranes', 'parishes', 'usertype', 'schools', 'religiousQualification', 'JobCategory', 'forane', 'academic_yr', 'JobTitles', 'years', 'catechismUnits', 'districts', 'designations', 'secularQualification', 'familyUnits', 'nameTitles', 'CTCbatch']));
    }
    public function attendance_management(Request $request)
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $parishes = Parishes::select('parish_code', 'name')->get();
        $usertype = UserRole::select('user_role', 'code')->get();
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();
        $academicYears = AcademicYear::select('academic_year')->get()->last()->toArray();
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
        $students_code = isset($_POST['students_code']) ? $_POST['students_code'] : '';
        $units = isset($_POST['units']) ? $_POST['units'] : '';
        if ($units == '') {
            $units = isset($_POST['school']) ? $_POST['school'] : '';
        }
        $class_date = isset($_POST['class_date']) ? $_POST['class_date'] : '';
        $staffs = [];
        if ($_POST) {
            // $Validate = $request->validate([
            //     'forane' => 'required|max:255',
            //     'units' => 'required|max:255',
            // ]);
            $staff_present = isset($_POST['staff_present']) ? $_POST['staff_present'] : '';
            $staffs = Staffs::select('staffs.*');
            if ($forane && $forane != '') {
                $staffs->where('staffs.catechism_forane_code', $forane);
            }
            if ($units && $units != '') {
                $staffs->where('staffs.catechism_unit_code', $units);
            }
            $staffs = $staffs->get();
            // $stud = isset($_POST['stud']) ? $_POST['stud'] : '';
            if ($staff_present != '') {
                //     foreach ($stud as $K => $stu) {
                //         // echo '<pre>';
                //         // print_r($stu);
                //         // exit;


                foreach ($staff_present as $key => $data) {
                    $staf_string = implode(', ', $staff_present);

                }
                $data = array(
                    'year' => $academic_yr,
                    'unit_code' => $units,
                    'attendance' => $staf_string,
                    'date' => $class_date
                );
                // echo '<pre>';
                // print_r($_POST);
                // exit;
                $set_attend = StaffsAttendance::insert($data);


            }

            if (isset($set_attend)) {
                return redirect()->back()->with('success', 'Criteria details have been saved.');
            }
        }
        return view('general.staffs.attendance_management', compact(['academicYears', 'foranes', 'parishes', 'usertype', 'schools', 'classes', 'staffs', 'forane', 'academic_yr', 'division', 'class', 'units']));
    }
    public function staff_emigrants(Request $request)
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
                $transferDetails = StaffTransferDetails::leftJoin('catechism_unit_details as a', 'a.unit_code', '=', 'staff_transfer_details.from_unit_code')
                    ->leftJoin('catechism_unit_details as b', 'b.unit_code', '=', 'staff_transfer_details.to_unit_code')
                    ->select('staff_transfer_details.*', 'a.unit_name as transfered_from', 'b.unit_name as transfered_to')
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
        return view('general.staffs.staff_emigrants', compact(['academicYears', 'foranes', 'schools', 'transferDetails']));

    }
    public function staff_immigrants(Request $request)
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
                $transferDetails = StaffTransferDetails::leftJoin('catechism_unit_details as a', 'a.unit_code', '=', 'staff_transfer_details.from_unit_code')
                    ->leftJoin('catechism_unit_details as b', 'b.unit_code', '=', 'staff_transfer_details.to_unit_code')
                    ->select('staff_transfer_details.*', 'a.unit_name as transfered_from', 'b.unit_name as transfered_to')
                    ->
                    where('transfer_year', $academic_yr)
                    ->where('to_unit_code', $units)
                    ->get();
            }
        }
        // echo '<pre>';
        // print_r($transferDetails);
        // exit;
        return view('general.staffs.staff_immigrants', compact(['academicYears', 'foranes', 'schools', 'transferDetails']));

    }

    public function staff_birthday_report()
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();
        $months = Months::select('*')->get();
        $month = isset($_POST['month']) ? $_POST['month'] : '';
        $staffs = '';
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
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
            $staffs = Staffs::select('*');
            if ($units && $units != '') {
                $staffs->where('catechism_unit_code', $units);
            }
            if ($month && $month != '') {
                $staffs->whereMonth('date_of_birth', $month);
            }
            $birthday_list = $staffs->get();

            // echo '<pre>';
            // print_r($birthday_list);
            // exit;
        }
        return view('general.staffs.staffs_birthday_report', compact([
            'months',
            'foranes',
            'schools',
            'birthday_list'
        ]));
    }
    public function staff_address_report()
    {
        $foranes = Forane::select('forane_code', 'forane_name')->get();
        $academic_yr = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();
        $classes = ClassMaster::select('class')->get();
        $designations = CatechismDesignations::select('designation', 'id')
            ->get();
        $staffs = '';
        $forane = isset($_POST['forane']) ? $_POST['forane'] : '';
        $designation = isset($_POST['designation']) ? $_POST['designation'] : '';
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
            $staffs = Staffs::select('*');
            if ($units && $units != '') {
                $staffs->where('catechism_unit_code', $units);
            }
            if ($designation && $designation != '') {
                $staffs->where('cat_designation_id', $designation);
            }

            $address_list = $staffs->get();

            // echo '<pre>';
            // print_r($address_list);
            // exit;
        }
        return view('general.staffs.staff_address_report', compact([
            'foranes',
            'designations',
            'address_list'
        ]));
    }
    public function staff_count()
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

        $schools = SchoolStudentsStatistics::select('address', 'unit_code')->get();

        $age_from = null; // Replace with your logic to get the current 'age_from'
        $age_to = null; // Replace with your logic to get the current 'age_to'
        $staffs_count = '';
        if ($_POST) {
            $staffs = Staffs::selectRaw("religios_laity, sex,
    catechism_unit_code,COUNT(*) AS total_count

");
            if (isset($_POST['forane']) ? $_POST['forane'] : '') {
                $staffs->where('forane_code', $_POST['forane']);
            }
            if (isset($_POST['units']) ? $_POST['units'] : '') {
                $staffs->where('catechism_unit_code', $_POST['units']);
            }

            $staffs_count = $staffs->groupBy('religios_laity', 'sex')->get();
        }

        foreach ($staffs_count as $key => $row) {
            if (!isset($total[$row['sex']])) {
                $total[$row['sex']] = 0;   // initialize as number
            }
            $total[$row['sex']] += $row['total_count'];
        }

        // echo '<pre>';
        // print_r($total);
        // exit;
        return view('general.staffs.staff_count', compact('foranes', 'total', 'staffs_count'));
    }
}
