<?php

use App\Models\Post;
use App\Models\PastExample;
use App\Http\Controllers\Calendar;
use App\Http\Controllers\Calculation;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HrController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CSVController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\BossController;
use App\Http\Controllers\CorpController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Form2Controller;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\CommentController;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\KintaiHRController;
use App\Http\Controllers\NameCardController;
use App\Http\Controllers\WorkCardController;
use App\Http\Controllers\TableShowController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\WebSocketController;
use App\Http\Controllers\AccountantController;
use App\Http\Controllers\Calendar12Controller;
use App\Http\Controllers\PDFCompanyController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TimeRecordController;
use App\Http\Controllers\UserDetailController;
use App\Http\Controllers\UserFilterController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CalculationController;
use App\Http\Controllers\PastExampleController;
use App\Http\Controllers\Application2Controller;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RoomScheduleController;
use App\Http\Controllers\TesseractOcrController;
use Spatie\Permission\Middleware\RoleMiddleware;
use App\Http\Controllers\ArrivalRecordController;
use App\Http\Controllers\SuggestionBoxController;
use App\Http\Controllers\ActionScheduleController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\FilterDownloadController;
use App\Http\Controllers\TestEnrollmentController;
use App\Http\Controllers\CompanyScheduleController;
use App\Http\Controllers\DepartureRecordController;
use App\Http\Controllers\TestNotificationController;
use App\Http\Controllers\AttendanceTypeRecordController;
use App\Http\Controllers\CSVShowController;
use App\Http\Controllers\PastExamplesCategoryController;
use App\Http\Controllers\TimeOffRequestRecordController;

//Admin Group Route
Route::group(['middleware' => ['auth','role:super-admin|admin']], function () {
















        // Route::get('/test-car-insurance-notification',
        // [App\Http\Controllers\CarInsuranceTestController::class, 'testNotification']);





    // Calculation Crud
    Route::get('/admin/calculations', [CalculationController::class, 'index'])
        ->name('admin.calculations.index');

    Route::get('/admin/calculations/create', [CalculationController::class, 'create'])
        ->name('admin.calculations.create');

    Route::post('/admin/calculations', [CalculationController::class, 'store'])
        ->name('admin.calculations.store');

    Route::get('/admin/calculations/{calculation}', [CalculationController::class, 'show'])
        ->name('admin.calculations.show');

    Route::get('/admin/calculations/{calculation}/edit', [CalculationController::class, 'edit'])
        ->name('admin.calculations.edit');

    Route::put('/admin/calculations/{calculation}', [CalculationController::class, 'update'])
        ->name('admin.calculations.update');

    Route::delete('/admin/calculations/{calculation}', [CalculationController::class, 'destroy'])
        ->name('admin.calculations.destroy');
    // Route::get('admin/calculations/{corp}', [CalculationController::class, 'show'])->name('admin.calculations.show');


    Route::get('/calculations/{id}', [CalculationController::class, 'show'])->name('admin.calculations.show');






    //Holiday Route
    Route::put('/admin/calendar/edit-holiday/{holidayId}', [CalendarController::class, 'editHoliday'])
        ->name('admin.calendar.editHoliday');

    Route::delete('/admin/calendar/delete-holiday/{holidayId}/{officeId}/{corpId}', [CalendarController::class, 'deleteHoliday'])
        ->name('admin.calendar.deleteHoliday');

    Route::post('/admin/calendar/add-holiday', [CalendarController::class, 'addHoliday'])
        ->name('admin.calendar.addHoliday');

    Route::get('/admin/calendar/holiday/{holidayId}', [CalendarController::class, 'getHolidayData'])
        ->name('admin.calendar.getHolidayData');

    //Calendar 12

    Route::get(
        '/admin/calendar12',
        [Calendar12Controller::class, 'index']
    )->name('admin.calendar12.index');

    Route::post('/admin/calendar12', [Calendar12Controller::class, 'show'])
        ->name('admin.calendar12.show');

    Route::get(
        '/admin/calendar/show',
        [CalendarController::class, 'index']
    )->name('admin.calendar.index');

    Route::post(
        '/admin/calendar/upload',
        [CalendarController::class, 'store']
    )->name('admin.calendar.store');

    //CSV controller 1 saraar tatah route
    Route::post('/admin/download1-csv', [CSVController::class, 'download'])
        ->name('admin.download1.csv');
    //CSV front blade
    Route::get('/admin/download-csv-calculated', [CSVController::class, 'show'])
        ->name('admin.calculated');

    Route::get('/admin/download/csv', [FilterDownloadController::class, 'downloadCSV'])
        ->name('admin.download.csv');

    //Post CRUD route

    Route::get('/posts/create', [PostController::class, 'create'])
        ->name('posts.create');

    Route::post('/posts', [PostController::class, 'store'])
        ->name('posts.store');

    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])
        ->name('posts.edit');

    Route::put('/posts/{post}', [PostController::class, 'update'])
        ->name('posts.update');

    Route::delete('/posts/{post}', [PostController::class, 'destroy'])
        ->name('posts.destroy');

    //Tag CRUD route

    Route::get('/tags', [TagController::class, 'index'])
        ->name('tags.index');

    Route::get('/tags/create', [TagController::class, 'create'])
        ->name('tags.create');

    Route::post('/tags', [TagController::class, 'store'])
        ->name('tags.store');

    Route::get('/tags/{tag}/edit', [TagController::class, 'edit'])
        ->name('tags.edit');

    Route::put('/tags/{tag}', [TagController::class, 'update'])
        ->name('tags.update');

    Route::delete('/tags/{tag}', [TagController::class, 'destroy'])
        ->name('tags.destroy');

    //Category CRUD route

    Route::get('/categories', [CategoryController::class, 'index'])
        ->name('categories.index');

    Route::get('/categories/create', [CategoryController::class, 'create'])
        ->name('categories.create');

    Route::post('/categories', [CategoryController::class, 'store'])
        ->name('categories.store');

    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])
        ->name('categories.edit');

    Route::put('/categories/{category}', [CategoryController::class, 'update'])
        ->name('categories.update');

    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
        ->name('categories.destroy');

    //Filter / User Routes

    Route::get(
        '/admin/dashboard/show',
        [FilterController::class, 'show']
    )->name('admin.show');

    Route::post(
        '/admin/filter',
        [FilterController::class, 'filter']
    )->name('admin.filter');

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'dashboard'])
        ->name('admin.dashboard');

    Route::post('/admin/logout', [AdminDashboardController::class, 'logout'])
        ->name('admin.logout');



    Route::get('/admin/index', [AdminDashboardController::class, 'Index'])
        ->name('admin.index');


    //Attendance Route CRUD
    Route::get('/admin/attendance-type-records', [AttendanceTypeRecordController::class, 'index'])
        ->name('admin.attendance-type-records.index');

    Route::get('/admin/attendance-type-records/create', [AttendanceTypeRecordController::class, 'create'])
        ->name('admin.attendance-type-records.create');

    Route::post('/admin/attendance-type-records', [AttendanceTypeRecordController::class, 'store'])
        ->name('admin.attendance-type-records.store');

    Route::get('/admin/attendance-type-records/{attendanceTypeRecord}', [AttendanceTypeRecordController::class, 'show'])
        ->name('admin.attendance-type-records.show');

    Route::get('/admin/attendance-type-records/{attendanceTypeRecord}/edit', [AttendanceTypeRecordController::class, 'edit'])
        ->name('admin.attendance-type-records.edit');

    Route::put('/admin/attendance-type-records/{attendanceTypeRecord}', [AttendanceTypeRecordController::class, 'update'])
        ->name('admin.attendance-type-records.update');

    Route::delete('/admin/attendance-type-records/{attendanceTypeRecord}', [AttendanceTypeRecordController::class, 'destroy'])
        ->name('admin.attendance-type-records.destroy');




    //CORPS

    Route::get('/admin/corp-office/corps', [CorpController::class, 'index'])
        ->name('admin.corp-office.corps.index');

    Route::get('/admin/corp-office/corps/create', [CorpController::class, 'create'])
        ->name('admin.corp-office.corps.create');

    Route::post('/admin/corp-office/corps', [CorpController::class, 'store'])
        ->name('admin.corp-office.corps.store');

    Route::get('/admin/corp-office/corps/{corp}', [CorpController::class, 'show'])
        ->name('admin.corp-office.corps.show');

    Route::get('/admin/corp-office/corps/{corp}/edit', [CorpController::class, 'edit'])
        ->name('admin.corp-office.corps.edit');

    Route::put('/admin/corp-office/corps/{corp}', [CorpController::class, 'update'])
        ->name('admin.corp-office.corps.update');

    Route::delete('/admin/corp-office/corps/{corp}', [CorpController::class, 'destroy'])
        ->name('admin.corp-office.corps.destroy');

    //Office CRUD Route

    Route::get('/admin/corp-office/offices', [OfficeController::class, 'index'])
        ->name('admin.corp-office.offices.index');

    Route::get('/admin/corp-office/offices/create', [OfficeController::class, 'create'])
        ->name('admin.corp-office.offices.create');

    Route::post('/admin/corp-office/offices', [OfficeController::class, 'store'])
        ->name('admin.corp-office.offices.store');

    Route::get('/admin/corp-office/offices/{officeId}', [OfficeController::class, 'show'])
        ->name('admin.corp-office.offices.show');

    Route::get('/admin/corp-office/offices/{officeId}/edit', [OfficeController::class, 'edit'])
        ->name('admin.corp-office.offices.edit');

    Route::put('/admin/corp-office/offices/{officeId}', [OfficeController::class, 'update'])
        ->name('admin.corp-office.offices.update');

    Route::delete('/admin/corp-office/offices/{officeId}', [OfficeController::class, 'destroy'])
        ->name('admin.corp-office.offices.destroy');

    //User Crud Route



    Route::get('/admin/role-permission/users', [UserController::class, 'index'])
        ->name('admin.role-permission.user.index');

    Route::get('/admin/role-permission/users/create', [UserController::class, 'create'])
        ->name('admin.role-permission.user.create');

    Route::post('/admin/role-permission/users', [UserController::class, 'store'])
        ->name('admin.role-permission.user.store');

    Route::get('/admin/role-permission/users/{userId}', [UserController::class, 'show'])
        ->name('admin.role-permission.user.show');

    Route::get('/admin/role-permission/users/{id}/edit', [UserController::class, 'edit'])
        ->name('admin.role-permission.user.edit');

    Route::put('/admin/role-permission/users/{userId}', [UserController::class, 'update'])
        ->name('admin.role-permission.user.update');

    Route::get('/admin/role-permission/users/{userId}/delete', [UserController::class, 'destroy'])
        ->name('admin.role-permission.user.destroy');

    Route::get('/admin/role-permission/users/restore', [UserController::class, 'restoreIndex'])
        ->name('admin.role-permission.user.restore.index');

    Route::get('/admin/role-permission/users/{id}/restore', [UserController::class, 'restore'])
        ->name('admin.role-permission.user.restore');

    Route::get('/admin/get-employer-id/{corpId}', [UserController::class, 'generateEmployerId']);

    Route::get('/get-offices-for-corp/{corpId}', [UserController::class, 'getOfficesForCorp']);
    Route::get('/get-divisions-for-office/{officeId}', [UserController::class, 'getDivisionsForOffice']);


    //UserDetail Route


    // Route::get('/admin/role-permission/users/{id}/user-detail', [UserController::class, 'detail'])
    //     ->name('admin.role-permission.user-detail');

    // Route::get('/users/{id}/details', [UserDetailController::class, 'show'])->name('admin.user-details.show');
    // Route::post('/users/{id}/details', [UserDetailController::class, 'store'])->name('admin.user-details.store');
    // Route::put('/users/{id}/details', [UserDetailController::class, 'update'])->name('admin.user-details.update');
    Route::match(['get', 'post'], '/users/{id}/details', [UserDetailController::class, 'showAndUpdate'])
    ->name('admin.user-details.show-update');


    Route::match(['get', 'post'],'users/{id}bank', [UserDetailController::class, 'bankShowAndUpdate'])
    ->name('admin.user-details.bank-show-update');

    Route::match(['get', 'post'],'users/{id}family', [UserDetailController::class, 'familyShowAndUpdate'])
    ->name('admin.user-details.family-show-update');

    //family Crud Routes

    Route::get('/users/{id}/index',[UserDetailController::class,'index'])
        ->name('admin.user-details.family-index');
    Route::get('/users/{id}/create',[UserDetailController::class,'create'])
        ->name('admin.user-details.family-create');

    Route::post('/family/{id}', [UserDetailController::class, 'familyStore'])
    ->name('admin.user-details.family-store');

    Route::get('/admin/user-details/{userId}/family/{familyId}/edit', [UserDetailController::class, 'edit'])
    ->name('admin.user-details.family-edit');

    Route::put('/admin/user-details/{userId}/family/{familyId}', [UserDetailController::class, 'update'])
        ->name('admin.user-details.family-update');

    Route::delete('/admin/user-details/{userId}/family/{familyId}', [UserDetailController::class, 'destroy'])
    ->name('admin.user-details.family-destroy');



    // Route::get('users/{id}bank', [UserDetailController::class, 'bankShowAndUpdate'])
    // ->name('admin.user-details.bank-show-update');


    // Role Crud Route

    Route::get('/admin/role-permission/roles', [RoleController::class, 'index'])
        ->name('admin.role-permission.role.index');

    Route::get('/admin/role-permission/roles/create', [RoleController::class, 'create'])
        ->name('admin.role-permission.role.create');

    Route::post('/admin/role-permission/roles', [RoleController::class, 'store'])
        ->name('admin.role-permission.role.store');

    Route::get('/admin/role-permission/roles/{role}', [RoleController::class, 'show'])
        ->name('admin.role-permission.role.show');

    Route::get('/admin/role-permission/roles/{role}/edit', [RoleController::class, 'edit'])
        ->name('admin.role-permission.role.edit');

    Route::put('/admin/role-permission/roles/{role}', [RoleController::class, 'update'])
        ->name('admin.role-permission.role.update');

    Route::delete('/admin/role-permission/roles/{id}/delete', [RoleController::class, 'destroy'])
        ->name('roles.destroy');

    //Permission Crud Route

    Route::get('/admin/role-permission/permissions', [PermissionController::class, 'index'])
        ->name('admin.role-permission.permission.index');

    Route::get('/admin/role-permission/permissions/create', [PermissionController::class, 'create'])
        ->name('admin.role-permission.permission.create');

    Route::post('/admin/role-permission/permissions', [PermissionController::class, 'store'])
        ->name('admin.role-permission.permission.store');

    Route::get('/admin/role-permission/permissions/{permission}', [PermissionController::class, 'show'])
        ->name('admin.role-permission.permission.show');

    Route::get('/admin/role-permission/permissions/{permission}/edit', [PermissionController::class, 'edit'])
        ->name('admin.role-permission.permission.edit');

    Route::put('/admin/role-permission/permissions/{permission}', [PermissionController::class, 'update'])
        ->name('admin.role-permission.permission.update');

    Route::delete('/admin/role-permission/permissions/{id}/delete', [PermissionController::class, 'destroy'])
        ->name('permissions.destroy');

    //Add Role Permission
    Route::get('/admin/role-permission/roles/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole']);
    Route::put('/admin/role-permission/roles/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole']);

    //Assign corp/office
    Route::get('/admin/users/{user}/assign-corporation', [AdminDashboardController::class, 'showAssignCorporationForm'])
        ->name('admin.assign-corporation');

    Route::post('/admin/users/{user}/assign-corporation', [AdminDashboardController::class, 'assignCorporation'])
        ->name('admin.assign-corporation.store');

    Route::get('/admin/users/{user}/assign-office', [AdminDashboardController::class, 'showAssignOfficeForm'])
        ->name('admin.assign-office');

    Route::post('/admin/users/{user}/assign-office', [AdminDashboardController::class, 'assignOffice'])
        ->name('admin.assign-office.store');

    //Division Crud route

    Route::get('/admin/division', [DivisionController::class, 'index'])
        ->name('admin.division.index');

    Route::get('/admin/division/create', [DivisionController::class, 'create'])
        ->name('admin.division.create');

    Route::post('/admin/division', [DivisionController::class, 'store'])
        ->name('admin.division.store');

    Route::get('/admin/division/{division}', [DivisionController::class, 'show'])
        ->name('admin.division.show');

    Route::get('/admin/division/{division}/edit', [DivisionController::class, 'edit'])
        ->name('admin.division.edit');

    Route::put('/admin/division/{division}', [DivisionController::class, 'update'])
        ->name('admin.division.update');

    Route::delete('/admin/division/{division}', [DivisionController::class, 'destroy'])
        ->name('admin.division.destroy');


    Route::get('/admin/csv', [CSVShowController::class, 'show'])
    ->name('admin.csv.show');


    Route::match(['get','post'],'/admin/csv/filter', [CSVShowController::class, 'filter'])
    ->name('admin.csv.filter');

    Route::post('/admin/csv/save-checkbox-data', [CSVShowController::class, 'saveCheckboxData'])
    ->name('checkbox.save');
    Route::post('/admin/csv/uncheck-checkbox-data', [CSVShowController::class, 'uncheckData'])
    ->name('checkbox.uncheck');





}); //Admin Group route END




//Front end All Route


//endees doosh hiitsen

    Route::get('/', function () {
        return view('auth.login');
    });
    // Route::middleware('auth')->group(function () {
    //     Route::get('/profile', [ProfileController::class, 'edit'])
    //         ->name('profile.edit');
    //     Route::patch('/profile', [ProfileController::class, 'update'])
    //         ->name('profile.update');
    //     Route::delete('/profile', [ProfileController::class, 'destroy'])
    //         ->name('profile.destroy');
    // });

    require __DIR__ . '/auth.php';


Route::middleware(['auth', 'verified'])->group(function () {





    Route::get('/other', [UserFilterController::class, 'index'])

        ->name('other');

    Route::post('/filter', [UserFilterController::class, 'filter'])

        ->name('filter');

    //test match gedeg rootiig sudlah

    Route::match(['get', 'post'], '/filter', [UserFilterController::class, 'filter'])

        ->name('filter');

    //Post Routes

    Route::get('/po', [PostController::class, 'index'])

        ->name('posts.index');

    Route::get('/posts/{post}', [PostController::class, 'show'])

        ->name('posts.show');

    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])

        ->name('comments.store');

    Route::get('/categories/{category}/posts', [PostController::class, 'showByCategory'])

        ->name('categories.posts');

    Route::get('/posts/tag/{tag}', [PostController::class, 'showByTag'])

        ->name('posts.tag');

    Route::get('/download/{id}', [PostController::class, 'download'])

        ->name('download.attachment');

    Route::get('/preview/{id}', [PostController::class, 'preview'])

        ->name('preview.attachment');

    Route::delete('/attachments/{id}', [PostController::class, 'destroy2'])

        ->name('attachments.destroy');



    //Arrival and Departure and Dashboard Routes

    Route::post('/arrivals', [ArrivalRecordController::class, 'store'])
        ->name('arrival.store');

    Route::post('/departures', [DepartureRecordController::class, 'store'])
        ->name('departure.store');

    Route::post('/dashboard', [TimeRecordController::class, 'record'])
        ->name('time.record');

    //delete Route

    Route::delete('/timerecord/{id}', [TimeRecordController::class , 'destroy'])
        ->name('timerecord.destroy');

    // Route::put('/dashboard', [TimeRecordController::class, 'record_manual'])
    //     ->name('time.record.manual');

    //break route
    // Route::post('/start-break', [TimeRecordController::class, 'startBreak'])
    //     ->name('time.start.break');

    // Route::post('/end-break', [TimeRecordController::class, 'endBreak'])
    //     ->name('time.end.break');

    // Route::put('/dashboard', [TimeRecordController::class, 'record_manual'])
    // ->middleware(['auth', 'verified'])
    // ->name('time.record.manual');

    // //break route
    // Route::post('/start-break', [TimeRecordController::class, 'startBreak'])
    // ->name('time.start.break');

    // Route::post('/end-break', [TimeRecordController::class, 'endBreak'])
    // ->name('time.end.break');

    Route::post('/time/record/manual', [TimeRecordController::class, 'record_manual'])->name('time.record.manual');
Route::post('/time/start-break', [TimeRecordController::class, 'startBreak'])->name('time.start.break');
Route::post('/time/end-break', [TimeRecordController::class, 'endBreak'])->name('time.end.break');

    // Route::get('/break-status', [TableShowController::class, 'getBreakStatus'])
    // ->name('break.status');

    Route::get('/check-break-count', [TimeRecordController::class, 'checkBreakCount'])->name('check.break.count');
    Route::get('/check-break-status', [TimeRecordController::class, 'checkBreakStatus'])->name('check.break.status');




    // Route::get('/check-arrival-record', [TimeRecordController::class, 'checkArrivalRecord'])->name('check.arrival.record');
    Route::get('/check-record/{recordType}', [TimeRecordController::class, 'checkRecord'])
    ->name('check.record');

    // Route::post('/time/calculate-total', [TimeRecordController::class, 'calculateTotalWorkTime'])
    // ->name('time.calculate.total');


    Route::get('/dashboard', [TableShowController::class, 'index'])
        ->name('dashboard');

    Route::get('/dashboard/omnoh/{year}/{month}', [TableShowController::class, 'omnoh'])
        ->name('dashboard.omnoh');

    Route::get('/dashboard/previous-month', [TableShowController::class, 'showPreviousMonth'])
        ->name('dashboard.previous-month');

    Route::get('/dashboard/next-month', [TableShowController::class, 'showNextMonth'])
        ->name('dashboard.next-month');





    //Form and application routes

    Route::get('/forms', [FormController::class, 'index'])
    ->name('forms.index');

    Route::get('/forms/{type}', [FormController::class, 'show'])
    ->name('forms.show');

    Route::post('/forms/store/{type}', [FormController::class, 'store'])
    ->name('forms.store');

    Route::match(['post', 'put'], '/forms/{type}/{id?}', [FormController::class, 'update'])
    ->name('forms.update');




    Route::get('/applications', [ApplicationController::class, 'index'])
    ->name('applications.index');

    Route::get('/applications/boss', [ApplicationController::class, 'bossIndex'])
        ->name('applications.boss_index')
        ->middleware(['auth', 'is_boss']);

    Route::put('/applications/{id}/update-type-c', [ApplicationController::class, 'updateTypeC'])
    ->name('applications.update-type-c');

    Route::get('/applications/{id}', [ApplicationController::class, 'show'])
    ->name('applications.show');

    Route::post('/applications/{id}/update-status', [ApplicationController::class, 'updateStatus'])
    ->name('applications.updateStatus');




    Route::get('/applications/search', [ApplicationController::class, 'search'])
    ->name('applications.search');

    // HR
    Route::get('/hr', [HrController::class, 'index'])
        ->name('hr.hr.dashboard')
        ->middleware(['auth', 'taisei']);

    Route::get('/hr', [HrController::class, 'index'])
        ->name('hr.hr.dashboard')
        ->middleware(['auth', 'taisei']);

    Route::post('/applications/{application}/check', [ApplicationController::class, 'checkApplication'])
    ->name('applications.check');

    // Acountant
    Route::get('/ac', [AccountantController::class, 'index'])
        ->name('ac.ac_dashboard')
        ->middleware(['auth', 'taisei']);
    Route::post('/applications/{application}/check', [ApplicationController::class, 'checkApplication'])->name('applications.check');


    //Room schedule

    Route::get('/room-schedule/{officeId}/{date}', [RoomScheduleController::class, 'showSchedule'])
    ->name('room.schedule');

    Route::get('/room', [RoomScheduleController::class, 'index'])
        ->name('room.index');


    Route::get('/room/create', [RoomScheduleController::class, 'create'])
        ->name('room.create');
    Route::post('/room', [RoomScheduleController::class, 'store'])
        ->name('room.store');

    Route::get('/rooms/{room}/edit', [RoomScheduleController::class, 'edit'])
        ->name('room.edit');
    Route::put('/rooms/{room}', [RoomScheduleController::class, 'update'])
        ->name('room.update');
    Route::delete('/rooms/{room}', [RoomScheduleController::class, 'destroy'])
        ->name('room.destroy');

    //Reservation route

    Route::post('/reservations', [RoomScheduleController::class, 'createReservation'])
        ->name('reservations.create');
    //json route for reservations
    Route::get('/reservations/{reservation}/edit', [RoomScheduleController::class, 'editReservation'])
        ->name('reservations.edit');
    Route::put('/reservations/{reservation}', [RoomScheduleController::class, 'updateReservation'])
        ->name('reservations.update');
    Route::delete('/reservations/{reservation}', [RoomScheduleController::class, 'deleteReservation'])
        ->name('reservation.delete');

    //New Route for Home
    Route::get('/home', [TableShowController::class, 'home'])
        ->name('home');
    //Suggestion Box Route
    Route::get('/suggestion', [SuggestionBoxController::class, 'index'])
        ->name('suggestion.index');




    // PDF Company Route
    Route::get('/pdfCompany', [PDFCompanyController::class, 'index'])
        ->name('pdfCompany.index');

    Route::get('/pdfCompany/create', [PDFCompanyController::class, 'create'])
        ->name('pdfCompany.create');

    Route::post('/pdfCompany', [PDFCompanyController::class, 'store'])
        ->name('pdfCompany.store');

    Route::get('/pdfCompany/{pdfCompany}', [PDFCompanyController::class, 'show'])
        ->name('pdfCompany.show');


    Route::get('/pdfCompany/{pdfCompany}/edit', [PDFCompanyController::class, 'edit'])
        ->name('pdfCompany.edit');

    Route::put('/pdfCompany/{pdfCompany}', [PDFCompanyController::class, 'update'])
        ->name('pdfCompany.update');

    Route::delete('/pdfCompany/{pdfCompany}', [PDFCompanyController::class, 'destroy'])
        ->name('pdfCompany.destroy');

    // PDFController Route
    Route::post('/pdfCompany/{pdfCompany}/import', [PDFController::class, 'import'])
        ->name('pdf.import');


    Route::get('/pdf/{pdf}/view', [PDFController::class, 'view'])
        ->name('pdf.view');
    Route::delete('pdf/{pdf}', [PDFController::class, 'destroy'])
        ->name('pdf.destroy');

    Route::get('pdf/{pdf}/download', [PDFController::class, 'download'])
        ->name('pdf.download');

    //Notification Route


    Route::get('/notifications', [NotificationController::class, 'index'])
    ->name('notifications.index');

    Route::get('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])
    ->name('notifications.markAsRead');

    // ... other routes ...



    //UserView PDF


    //ActionSchedule

    Route::get('/actionSchedule', [ActionScheduleController::class, 'index'])
        ->name('actionSchedule.index');

    Route::get('/actionSchedule/create', [ActionScheduleController::class, 'create'])
        ->name('actionSchedule.create');

    Route::post('/actionSchedule', [ActionScheduleController::class, 'store'])
        ->name('actionSchedule.store');

    Route::get('/action-schedule/{corp}', [ActionScheduleController::class, 'show'])
        ->name('actionSchedule.show');

    Route::get('/actionSchedule/list/{office_id}', [ActionScheduleController::class, 'list'])
        ->name('actionSchedule.list');


    Route::get('/actionSchedule/{id}/edit', [ActionScheduleController::class, 'edit'])
        ->name('actionSchedule.edit');

    Route::put('/actionSchedule/{id}', [ActionScheduleController::class, 'update'])
        ->name('actionSchedule.update');

    Route::delete('/actionSchedule/{id}', [ActionScheduleController::class, 'destroy'])
        ->name('actionSchedule.destroy');



    //appointment routes

    Route::post('/appointments', [ActionScheduleController::class, 'storeAppointment'])
        ->name('appointments.store');

    Route::get('/appointments/{appointment}/edit', [ActionScheduleController::class, 'editAppointment'])
        ->name('appointments.edit');

    Route::put('/appointments/{appointment}', [ActionScheduleController::class, 'updateAppointment'])
        ->name('appointments.update');

    Route::delete('/appointments/{appointment}', [ActionScheduleController::class, 'destroyAppointment'])
        ->name('appointments.destroy');

    //warehouse routes
    Route::get('/warehouse', [WarehouseController::class, 'index'])
        ->name('warehouse.index');

    Route::get('warehouse/index2', [WarehouseController::class, 'index2'])->name('warehouse.index2');

    Route::get('/warehouse/create', [WarehouseController::class, 'create'])
        ->name('warehouse.create');

    Route::post('/warehouse', [WarehouseController::class, 'store'])
        ->name('warehouse.store');




    Route::get('/warehouse/{warehouse}/edit', [WarehouseController::class, 'edit'])
        ->name('warehouse.edit');

    Route::put('/warehouse/{warehouse}', [WarehouseController::class, 'update'])
        ->name('warehouse.update');

    Route::delete('/warehouse/{warehouse}', [WarehouseController::class, 'destroy'])
        ->name('warehouse.destroy');



    //CompanyScheduleController


    Route::get('/companySchedule', [CompanyScheduleController::class, 'index'])
        ->name('companySchedule.index');

    Route::post('/company-schedule', [CompanyScheduleController::class, 'store'])
        ->name('companySchedule.store');

    Route::get('/company-schedule/get', [CompanyScheduleController::class, 'getSchedules'])
        ->name('companySchedule.getSchedules');


    Route::get('/company-schedule/{id}/edit', [CompanyScheduleController::class, 'edit'])
        ->name('companySchedule.edit');

    Route::put('/company-schedule/{id}', [CompanyScheduleController::class, 'update'])
        ->name('companySchedule.update');

    Route::delete('/company-schedule/{id}', [CompanyScheduleController::class, 'destroy'])
        ->name('companySchedule.destroy');

    //boss time off
    Route::get('/time_off_boss', [TimeOffRequestRecordController::class, 'index2'])
        ->name('time_off_boss.index');

    Route::post('/time-off-boss/{id}/update-status', [TimeOffRequestRecordController::class, 'updateStatus'])
        ->name('time_off_boss.updateStatus');


    //Time Off Crud Route
    //Admin route -ees awch irsen

    Route::get('/admin/time_off', [TimeOffRequestRecordController::class, 'index'])
        ->name('admin.time_off.index');

    Route::get('/admin/time_off/create', [TimeOffRequestRecordController::class, 'create'])
        ->name('admin.time_off.create');

    Route::post('/admin/time-off', [TimeOffRequestRecordController::class, 'store'])
        ->name('admin.time_off.store');

    Route::get('/admin/time_off/{attendanceTypeRecord}', [TimeOffRequestRecordController::class, 'show'])
        ->name('admin.time_off.show');

    Route::get('/admin/time_off/{attendanceTypeRecord}/edit', [TimeOffRequestRecordController::class, 'edit'])
        ->name('admin.time_off.edit');





//route for holiday work

Route::post('/admin/time-off/holiday', [TimeOffRequestRecordController::class, 'store2'])
    ->name('admin.time_off.store2');






    // Route::put('/admin/time_off/{attendanceTypeRecord}', [TimeOffRequestRecordController::class, 'update'])
    // ->name('admin.time_off.update');

    Route::delete('/admin/time_off/{timeOffRequestRecord}', [TimeOffRequestRecordController::class, 'destroy'])
        ->name('admin.time_off.destroy');

    Route::put('/admin/time_off/{timeOffRequestRecord}', [TimeOffRequestRecordController::class, 'update'])
        ->name('admin.time_off.update');
    //

    Route::get('/Kintaihr', [KintaiHRController::class, 'index'])
        ->name('Kintaihr')
        ->middleware(['auth', 'taisei']);

    Route::post('/records/{timeOffRequestRecord}/check', [TimeOffRequestRecordController::class, 'checkApplication'])
        ->name('records.check');
    // Route::post('/applications/{application}/check', [ApplicationController::class, 'checkApplication'])->name('applications.check');


    //myPage Route

    Route::get('/myPage', [MyPageController::class, 'index'])
        ->name('myPage.index');

        //new route for profile update
    Route::match(['get', 'put'], '/profile', [MyPageController::class, 'profile'])

    ->name('myPage.profile');

        //end

        Route::match(['get', 'post'], '/myPage/update', [MyPageController::class, 'showAndUpdate'])
        ->name('myPage.show-update');

        Route::match(['get', 'post'], '/myPage/bank', [MyPageController::class,'showAndUpdateBank'])
        ->name('myPage.bank-show-update');


        Route::get('/myPage/family', [MyPageController::class, 'family'])
        ->name('myPage.family');

        Route::get('/myPage/family-create', [MyPageController::class, 'create'])
        ->name('myPage.family-create');

        Route::post('/myPage/family-store', [MyPageController::class, 'familyStore'])
        ->name('myPage.family-store');

        Route::get('/myPage/family/{id}/edit', [MyPageController::class, 'edit'])
         ->name('myPage.family-edit');

        Route::put('/myPage/family/{id}', [MyPageController::class, 'update'])
            ->name('myPage.family-update');

        Route::delete('/myPage/family/{id}', [MyPageController::class, 'destroy'])
            ->name('myPage.family-destroy');


            //New Routes



    //Form and application routes

    Route::get('/ComputerForm', [Form2Controller::class, 'index2'])
    ->name('ComputerForm.index');


    Route::get('/ComputerForm/{type}', [Form2Controller::class, 'show2'])
    ->name('ComputerForm');



    Route::get('/forms2', [Form2Controller::class, 'index'])
    ->name('forms2.index');

    Route::get('/forms2/{type}', [Form2Controller::class, 'show'])
    ->name('forms2.show');

    Route::post('/forms2/store/{type}', [Form2Controller::class, 'store'])
    ->name('forms2.store');

    Route::post('/ComputerForm/{type}', [Form2Controller::class, 'store2'])
    ->name('forms2');

    // Route::match(['post', 'put'], '/forms/{type}/{id?}', [FormController::class, 'update'])
    // ->name('forms.update');




    Route::get('/applications2/index', [Application2Controller::class, 'index'])
    ->name('applications2.index');




    Route::get('/applications2/{id}', [Application2Controller::class, 'show'])
    ->name('applications2.show');

    Route::post('/applications2/{application2}/check', [Application2Controller::class, 'check'])->name('applications2.check');

    Route::post('/applications2/{application2}/update-comment', [Application2Controller::class, 'updateComment']);

    //Computer Q and A route

    Route::get('/applications2', [Application2Controller::class, 'computer'])
    ->name('applications2.computer');


                //python name card


                Route::resource('namecards', NameCardController::class);
                Route::get('/namecards', [NameCardController::class, 'index'])->name('namecards.index');


                Route::get('/namecards/{namecard}', [NameCardController::class, 'show'])->name('namecards.show');




                Route::get('/ocr-test', [NameCardController::class, 'testOCR']);

                Route::get('/ocr-diagnostics', [NameCardController::class, 'diagnostics']);

                // Route::post('/namecards/store', [NameCardController::class, 'store'])->name('namecards.store');


                Route::post('/namecards/process', [NameCardController::class, 'process'])->name('namecards.process');

            // Route for saving the confirmed data
            Route::post('/namecards/storeConfirmedData', [NameCardController::class, 'storeConfirmedData'])->name('namecards.storeConfirmedData');





            //Holdingsing middleware endees ajilah esoti
                // CAR Crud
                Route::get('/car', [CarController::class, 'index'])
                ->name('car.index');

                Route::get('/car/create', [CarController::class, 'create'])
                ->name('car.create');

                Route::post('/car', [CarController::class, 'store'])
                ->name('car.store');

                Route::get('/car/{car}', [CarController::class, 'show'])
                ->name('car.show');

                Route::get('/car/{car}/edit', [CarController::class, 'edit'])
                ->name('car.edit');

                Route::put('/car/{car}', [CarController::class, 'update'])
                ->name('car.update');

                Route::delete('/car/{car}', [CarController::class, 'destroy'])
                ->name('car.destroy');


                  // Past Examples
                Route::get('/past-examples', [PastExampleController::class, 'index'])
                ->name('past-examples.index');

            Route::get('/past-examples/create', [PastExampleController::class, 'create'])
                ->name('past-examples.create');

            Route::post('/past-examples', [PastExampleController::class, 'store'])
                ->name('past-examples.store');

                Route::get('/past-examples/{pastExample}', [PastExampleController::class, 'show'])
                ->name('past-examples.show');



            Route::get('/past-examples/{pastExample}/edit', [PastExampleController::class, 'edit'])
                ->name('past-examples.edit');

                Route::put('/past-examples/{pastExample}', [PastExampleController::class, 'update'])
                ->name('past-examples.update');

            Route::delete('/past-examples/{pastExample}', [PastExampleController::class, 'destroy'])
                ->name('past-examples.destroy');
                Route::post('/past-examples/upload-image', [PastExampleController::class, 'uploadImage'])
                ->name('past-examples.upload-image');


                //past Examples Category


                  // Past Examples
                  Route::get('/past-examples-category', [PastExamplesCategoryController::class, 'index'])
                  ->name('past-examples-category.index');

              Route::get('/past-examples-category/create', [PastExamplesCategoryController::class, 'create'])
                  ->name('past-examples-category.create');

              Route::post('/past-examples-category', [PastExamplesCategoryController::class, 'store'])
                  ->name('past-examples-category.store');

                //   Route::get('/past-examples/{pastExample}', [PastExamplesCategoryController::class, 'show'])
                //   ->name('past-examples.show');



            Route::put('/past-examples-category/{pastExamplesCategory}', [PastExamplesCategoryController::class, 'update'])
             ->name('past-examples-category.update');
            Route::get('/past-examples-category/{pastExamplesCategory}/edit', [PastExamplesCategoryController::class, 'edit'])
                ->name('past-examples-category.edit');

              Route::delete('/past-examples-category/{pastExamplesCategory}', [PastExamplesCategoryController::class, 'destroy'])
                  ->name('past-examples-category.destroy');



                  //Product Route

                  Route::get('/products', [ProductController::class, 'index'])
                  ->name('products.index');

              Route::get('/products/create', [ProductController::class, 'create'])
                  ->name('products.create');

              Route::post('/products', [ProductController::class, 'store'])
                  ->name('products.store');

                  Route::get('/products/{product}', [ProductController::class, 'show'])
                  ->name('products.show');



              Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
                  ->name('products.edit');

                  Route::put('/products/{product}', [ProductController::class, 'update'])
                  ->name('products.update');

              Route::delete('/products/{product}', [ProductController::class, 'destroy'])
                  ->name('products.destroy');

                  Route::post('products/import', [ProductController::class, 'importData'])->name('products.import');

                  Route::post('/products/auto-import', [ProductController::class, 'autoImport'])
                ->name('products.auto-import');

                Route::post('/products/export', [ProductController::class, 'export'])->name('products.export');



























});
        //Auth protection ends here
