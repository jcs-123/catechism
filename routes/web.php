<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\icons\MdiIcons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\tables\Basic as TablesBasic;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GeneralSettings;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\StaffsController;
use App\Http\Controllers\ContactClassController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\UnitVisitController;
use App\Http\Controllers\ValuationController;
use App\Http\Controllers\ExamController;


// Main Page Route
Route::get('/', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/logout', [LoginBasic::class, 'logout'])->name('logout');

// layout

// Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
// Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
// Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
// Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

// pages
// Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
// Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
// Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
// Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
// Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');

// authentication
// Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
// Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
Route::get('/register', [RegisterBasic::class, 'register'])->name('auth-register-save');
Route::post('/login', [LoginBasic::class, 'login'])->name('auth-login-save');

Route::middleware(['auth'])
        ->group(function () {

                Route::get('/dashboard', [Analytics::class, 'index'])->name('dashboard-analytics');
                // cards
                Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');

                Route::match(['get', 'post'], '/login-permission-settings', [UserController::class, 'index'])->name('login-permission-settings');

                //general settings
                Route::match(['get', 'post'], '/academic-year', [GeneralSettings::class, 'academic_year'])->name('academic-year');
                Route::match(['get', 'post'], '/working-days-list', [GeneralSettings::class, 'working_days_list'])->name('working-days-list');
                Route::match(['get', 'post'], '/add-working-days', [GeneralSettings::class, 'add_working_days'])->name('add-working-days');
                Route::match(['get', 'post'], '/important-days-list', [GeneralSettings::class, 'important_days_list'])->name('important-days-list');
                Route::match(['get', 'post'], '/add-important-days', [GeneralSettings::class, 'add_important_days'])->name('add-important-days');
                Route::match(['get', 'post'], '/common-holiday-settings', [GeneralSettings::class, 'common_holiday_settings'])->name('common-holiday-settings');
                Route::match(['get', 'post'], '/local-holiday-settings', [GeneralSettings::class, 'local_holiday_settings'])->name('local-holiday-settings');
                Route::match(['get', 'post'], '/summary-report', [GeneralSettings::class, 'summary_report'])->name('summary-report');
                Route::match(['get', 'post'], '/detail-summary', [GeneralSettings::class, 'summary_detail'])->name('detail-summary');
                Route::match(['get', 'post'], '/division-management', [GeneralSettings::class, 'division_management'])->name('division-management');
                Route::match(['get', 'post'], '/add-last-admission', [GeneralSettings::class, 'add_last_admission'])->name('add-last-admission');
                Route::match(['get', 'post'], '/criteria-list', [GeneralSettings::class, 'criteria_list'])->name('criteria-list');
                Route::match(['get', 'post'], '/add-criteria', [GeneralSettings::class, 'add_criteria'])->name('add-criteria');
                Route::match(['get', 'post'], '/settings-list', [GeneralSettings::class, 'settings_list'])->name('settings-list');
                Route::match(['get', 'post'], '/add-settings', [GeneralSettings::class, 'add_settings'])->name('add-settings');
                Route::match(['get', 'post'], '/add-date-settings', [GeneralSettings::class, 'add_date_settings'])->name('add-date-settings');
                Route::match(['get', 'post'], '/date-settings-list', [GeneralSettings::class, 'date_settings_list'])->name('date-settings-list');
                Route::get('/get-classes/{academic_year}', [GeneralSettings::class, 'getClasses'])->name('get-classes');
                Route::match(['get', 'post'], '/internal-criteria-list', [GeneralSettings::class, 'internal_criteria_list'])->name('internal-criteria-list');
                Route::match(['get', 'post'], '/add-internal-criteria', [GeneralSettings::class, 'add_internal_marks_criteria'])->name('add-internal-criteria');
                Route::match(['get', 'post'], '/add-news', [GeneralSettings::class, 'add_news'])->name('add-news');
                Route::match(['get', 'post'], '/news-list', [GeneralSettings::class, 'news_list'])->name('news-list');
                Route::match(['get', 'post'], '/add-events', [GeneralSettings::class, 'add_events'])->name('add-events');
                Route::match(['get', 'post'], '/events-list', [GeneralSettings::class, 'events_list'])->name('events-list');
                Route::match(['get', 'post'], '/add-forane-promoter', [GeneralSettings::class, 'add_forane_promoter'])->name('add-forane-promoter');
                Route::match(['get', 'post'], '/forane-promoter-list', [GeneralSettings::class, 'forane_promoter_list'])->name('forane-promoter-list');
                Route::match(['get', 'post'], '/forane-promoter-report', [GeneralSettings::class, 'forane_promoter_report'])->name('forane-promoter-report');
                Route::match(['get', 'post'], '/forane-management', [GeneralSettings::class, 'forane_management'])->name('forane-management');
                Route::match(['get', 'post'], '/forane-management/$id', [GeneralSettings::class, 'forane_management'])->name('forane-management.edit');
                Route::match(['get', 'post'], '/add-unit', [GeneralSettings::class, 'add_unit'])->name('add-unit');
                Route::match(['get', 'post'], '/unit-list', [GeneralSettings::class, 'unit_list'])->name('unit-list');
                Route::match(['get', 'post'], '/unit-address-report', [GeneralSettings::class, 'unit_address_report'])->name('unit-address-report');
                Route::match(['get', 'post'], '/unit-report', [GeneralSettings::class, 'unit_report'])->name('unit-report');
                Route::get('/get-units/{forane}', [GeneralSettings::class, 'getUnits'])->name('get-units');
                Route::match(['get', 'post'], '/unit-summary-report', [GeneralSettings::class, 'unit_summary_report'])->name('unit-summary-report');
                Route::match(['get', 'post'], '/add-user', [GeneralSettings::class, 'add_user'])->name('add-user');
                Route::match(['get', 'post'], '/user-list', [GeneralSettings::class, 'user_list'])->name('user-list');
                Route::match(['get', 'post'], '/attendance-edit-reason', [GeneralSettings::class, 'attendance_edit_reasons'])->name('attendance-edit-reason');
                Route::match(['get', 'post'], '/family-unit', [GeneralSettings::class, 'family_unit'])->name('family-unit');
                Route::match(['get', 'post'], '/designation-management', [GeneralSettings::class, 'designation_management'])->name('designation-management');
                Route::match(['get', 'post'], '/job-categories', [GeneralSettings::class, 'job_categories'])->name('job-categories');
                Route::match(['get', 'post'], '/job-titles', [GeneralSettings::class, 'job_titles'])->name('job-titles');
                Route::match(['get', 'post'], '/qualification-management', [GeneralSettings::class, 'qualification_management'])->name('qualification-management');
                Route::match(['get', 'post'], '/name-titles', [GeneralSettings::class, 'name_titles'])->name('name-titles');
                Route::match(['get', 'post'], '/pious-associations', [GeneralSettings::class, 'pious_associations'])->name('pious-associations');
                Route::match(['get', 'post'], '/add-authority', [GeneralSettings::class, 'add_authority'])->name('add-authority');
                Route::match(['get', 'post'], '/authority-list', [GeneralSettings::class, 'authority_list'])->name('authority-list');
                Route::match(['get', 'post'], '/authority-report', [GeneralSettings::class, 'authority_report'])->name('authority-report');
                Route::get('/get-designations/{authority}', [GeneralSettings::class, 'getDesignations'])->name('get-designations');
                Route::match(['get', 'post'], '/add-urgent-notifications', [GeneralSettings::class, 'add_urgent_notifications'])->name('add-urgent-notifications');
                Route::get('/get-parishes/{forane}', [GeneralSettings::class, 'getParishes'])->name('get-parishes');

                Route::match(['get', 'post'], '/excellence-criteria-list', [StudentsController::class, 'excellence_criteria_list'])->name('excellence-criteria-list');
                Route::match(['get', 'post'], '/add-excellence-criteria', [StudentsController::class, 'add_excellence_criteria'])->name('add-excellence-criteria');
                Route::match(['get', 'post'], '/add-excellence-students', [StudentsController::class, 'add_excellence_students'])->name('add-excellence-students');
                Route::match(['get', 'post'], '/excellence-students-list', [StudentsController::class, 'excellence_students_list'])->name('excellence-students-list');
                Route::get('/get-divisions/{classes}', [GeneralSettings::class, 'getDivisions'])->name('get-divisions');

                Route::match(['get', 'post'], '/student-list', [StudentsController::class, 'student_list'])->name('student-list');
                Route::match(['get', 'post'], '/student-strength', [StudentsController::class, 'student_strength'])->name('student-strength');
                Route::match(['get', 'post'], '/student-register', [StudentsController::class, 'student_register'])->name('student-register');
                Route::match(['get', 'post'], '/add-attendance', [StudentsController::class, 'add_attendance'])->name('add-attendance');
                Route::match(['get', 'post'], '/delete-attendance', [StudentsController::class, 'delete_attendance'])->name('delete-attendance');
                Route::match(['get', 'post'], '/emigrants', [StudentsController::class, 'emigrants'])->name('emigrants');
                Route::match(['get', 'post'], '/immigrants', [StudentsController::class, 'immigrants'])->name('immigrants');
                Route::match(['get', 'post'], '/extra-attendance', [StudentsController::class, 'extra_attendance'])->name('extra-attendance');
                Route::match(['get', 'post'], '/attendance-list', [StudentsController::class, 'attendance_list'])->name('attendance-list');
                Route::match(['get', 'post'], '/extra-attendance-list', [StudentsController::class, 'extra_attendance_list'])->name('extra-attendance-list');
                Route::match(['get', 'post'], '/student-search-report', [StudentsController::class, 'student_search_report'])->name('student-search-report');
                Route::match(['get', 'post'], '/student-list-report', [StudentsController::class, 'student_list_report'])->name('student-list-report');
                Route::match(['get', 'post'], '/student-list-without-header', [StudentsController::class, 'student_list_without_header'])->name('student-list-without-header');
                Route::match(['get', 'post'], '/transfer-certificate', [StudentsController::class, 'transfer_certificate'])->name('transfer-certificate');
                Route::match(['get', 'post'], '/cancel-tc', [StudentsController::class, 'cancel_tc'])->name('cancel-tc');
                Route::get('/cancel-student-Tc/{transfer_id}', [StudentsController::class, 'cancel_student_TC'])->name('cancel-student-TC');
                Route::match(['get', 'post'], '/birthday-list', [StudentsController::class, 'birthday_list'])->name('birthday-list');
                Route::match(['get', 'post'], '/student-address-report', [StudentsController::class, 'student_address_report'])->name('student-address-report');
                Route::match(['get', 'post'], '/student-summary-report', [StudentsController::class, 'student_summary_report'])->name('student-summary-report');
                Route::match(['get', 'post'], '/full-attendance', [StudentsController::class, 'full_attendance'])->name('full-attendance');
                Route::match(['get', 'post'], '/not-attending', [StudentsController::class, 'not_attending'])->name('not-attending');
                Route::match(['get', 'post'], '/annual-exam-eligibility-list', [StudentsController::class, 'annual_exam_eligibility_list'])->name('annual-exam-eligibility-list');
                Route::match(['get', 'post'], '/annual-exam-ineligibility-list', [StudentsController::class, 'annual_exam_ineligibility_list'])->name('annual-exam-ineligibility-list');
                Route::match(['get', 'post'], '/transfer-student-list', [StudentsController::class, 'transfer_student_list'])->name('transfer-student-list');

                //STAFF MANAGEMENT
                Route::match(['get', 'post'], '/staff-list', [StaffsController::class, 'staff_list'])->name('staff-list');
                Route::match(['get', 'post'], '/staff-list-report', [StaffsController::class, 'staff_list_report'])->name('staff-list-report');
                Route::match(['get', 'post'], '/staff-summary-report', [StaffsController::class, 'staff_summary_report'])->name('staff-summary-report');
                Route::match(['get', 'post'], '/cancel-tc-list', [StaffsController::class, 'cancel_tc_list'])->name('cancel-tc-list');
                Route::get('/cancel-tc/{transfer_id}', [StaffsController::class, 'cancelTC'])->name('cancelTC');
                Route::match(['get', 'post'], '/staff-transfer-list', [StaffsController::class, 'staff_transfer_list'])->name('staff-transfer-list');
                Route::match(['get', 'post'], '/staff-list-report', [StaffsController::class, 'staff_list_report'])->name('staff-list-report');
                Route::match(['get', 'post'], '/staff-list-without-header', [StaffsController::class, 'staff_list_without_header'])->name('staff-list-without-header');
                Route::match(['get', 'post'], '/staff-transfer', [StaffsController::class, 'staff_transfer'])->name('staff-transfer');
                Route::get('/get-staffs/{forane}', [GeneralSettings::class, 'getStaffs'])->name('get-staffs');
                Route::get('/get-students/{forane}', [GeneralSettings::class, 'getstudents'])->name('get-students');
                Route::match(['get', 'post'], '/staff-register', [StaffsController::class, 'staff_register'])->name('staff-register');
                Route::match(['get', 'post'], '/attendance-management', [StaffsController::class, 'attendance_management'])->name('attendance-management');
                Route::match(['get', 'post'], '/staff-emigrants', [StaffsController::class, 'staff_emigrants'])->name('staff-emigrants');
                Route::match(['get', 'post'], '/staff-immigrants', [StaffsController::class, 'staff_immigrants'])->name('staff-immigrants');
                Route::match(['get', 'post'], '/staff-birthday-report', [StaffsController::class, 'staff_birthday_report'])->name('staff-birthday-report');
                Route::match(['get', 'post'], '/staff-address-report', [StaffsController::class, 'staff_address_report'])->name('staff-address-report');
                Route::match(['get', 'post'], '/staff-count', [StaffsController::class, 'staff_count'])->name('staff-count');

                //CONTACT CLASS MANAGEMENT
                Route::match(['get', 'post'], '/contact-class-settings', [ContactClassController::class, 'contact_class_settings'])->name('contact-class-settings');
                Route::match(['get', 'post'], '/contact-class-attendance-list', [ContactClassController::class, 'contact_class_attendance_list'])->name('contact-class-attendance-list');
                Route::match(['get', 'post'], '/add-contact-attendance', [ContactClassController::class, 'add_contact_attendance'])->name('add-contact-attendance');
                Route::match(['get', 'post'], '/non-public-mark-entry', [ContactClassController::class, 'non_public_mark_entry'])->name('non-public-mark-entry');
                Route::match(['get', 'post'], '/non-public-mark-list', [ContactClassController::class, 'non_public_mark_list'])->name('non-public-mark-list');
                Route::match(['get', 'post'], '/register-no-generation', [ContactClassController::class, 'register_no_generation'])->name('register-no-generation');
                Route::match(['get', 'post'], '/register-no-report', [ContactClassController::class, 'register_no_report'])->name('register-no-report');
                Route::match(['get', 'post'], '/public-exam-mark-entry', [ContactClassController::class, 'public_exam_mark_entry'])->name('public-exam-mark-entry');
                Route::match(['get', 'post'], '/public-exam-mark-list', [ContactClassController::class, 'public_exam_mark_list'])->name('public-exam-mark-list');

                //ACTIVITY MANAGEMENT
                Route::match(['get', 'post'], '/activity-list', [ActivityController::class, 'activity_list'])->name('activity-list');
                Route::match(['get', 'post'], '/activity-creation', [ActivityController::class, 'activity_creation'])->name('activity-creation');

                //UNIT VISIT MANAGEMENT
                Route::match(['get', 'post'], '/select-unit-visit-inspector', [UnitVisitController::class, 'select_unit_visit_inspector'])->name('select-unit-visit-inspector');
                Route::match(['get', 'post'], '/reset-form-permission', [UnitVisitController::class, 'reset_form_permission'])->name('reset-form-permission');
                Route::match(['get', 'post'], '/form-a', [UnitVisitController::class, 'form_a_creation'])->name('form-a');
                Route::match(['get', 'post'], '/form-b', [UnitVisitController::class, 'form_b_creation'])->name('form-b');
                Route::match(['get', 'post'], '/form-c', [UnitVisitController::class, 'form_c_creation'])->name('form-c');
                Route::match(['get', 'post'], '/dairy-form-a', [UnitVisitController::class, 'dairy_form_a_creation'])->name('dairy-form-a');
                Route::match(['get', 'post'], '/dairy-form-b', [UnitVisitController::class, 'dairy_form_b_creation'])->name('dairy-form-b');
                Route::match(['get', 'post'], '/dairy-form-c', [UnitVisitController::class, 'dairy_form_c_creation'])->name('dairy-form-c');
                Route::match(['get', 'post'], '/unit-visit-report', [UnitVisitController::class, 'unit_visit_report'])->name('unit-visit-report');

                //VALUATION MANAGEMENT
                Route::match(['get', 'post'], '/grouped-forane-list', [ValuationController::class, 'grouped_forane_list'])->name('grouped-forane-list');
                //Route::match(['get', 'post'], '/activity-creation', [UnitVisitController::class, 'activity_creation'])->name('activity-creation');
        
                //EXAM MANAGEMENT
                Route::match(['get', 'post'], '/annual-mark-list', [ExamController::class, 'annual_mark_list'])->name('annual-mark-list');
                //Route::match(['get', 'post'], '/activity-creation', [UnitVisitController::class, 'activity_creation'])->name('activity-creation');
        
                //PUBLIC EXAM SETTINGS
                Route::match(['get', 'post'], '/public-exam-settings', [publlicClassController::class, 'public_exam_settings'])->name('public-exam-settings');
                Route::match(['get', 'post'], '/previous-year-mark-entry', [publlicClassController::class, 'previous_year_mark_entry'])->name('previous-year-mark-entry');
                Route::match(['get', 'post'], '/previous-year-mark-entry', [publlicClassController::class, 'XII_previous_year_mark_entry'])->name('XII-previous-year-mark-entry');

                // User Interface 
// Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
// Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
// Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
// Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
// Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
// Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
// Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
// Route::get('/ui/footer', [Footer::class, 'index'])->name('ui-footer');
// Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
// Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
// Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
// Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
// Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
// Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
// Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
// Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
// Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
// Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
// Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');
        
                // // extended ui
// Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
// Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');
        
                // // icons
// Route::get('/icons/icons-mdi', [MdiIcons::class, 'index'])->name('icons-mdi');
        
                // // form elements
// Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
// Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');
        
                // // form layouts
// Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
// Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');
        
                // // tables
// Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');
        
        });