<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ExpenseManagementController;
use App\Http\Controllers\FetchBanksDocumentsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MailingController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\PermissionDataController;
use App\Http\Controllers\PipelineController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleTypeController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SourceAnalysisController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UploadDocumentController;
use App\Http\Controllers\UserController;
use App\Models\Pipeline;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/dashboard/opportunities', [OpportunityController::class, 'index'])->name('UI.dashboard.opportunities');
Route::get('/app/bar/search', [SearchController::class, 'search'])->name('UI.app.bar.search');
Route::get('/closed/deals', [OpportunityController::class, 'closedDeals'])->name('UI.dashboard.closed.deals');
Route::get('/cold/deals', [OpportunityController::class, 'coldDeals'])->name('UI.dashboard.cold.deals');
Route::get('/other/sourcing/channels', [SourceAnalysisController::class, 'sourceAnalysisChannel'])->name('UI.sourcing.channels');
Route::get('/internal/referrals', [OpportunityController::class, 'internalReferrals'])->name('UI.internal.referrals');
Route::get('/expense/management', [ExpenseManagementController::class, 'index'])->name('UI.expense.management');
Route::post('/new/UI/expense', [ExpenseManagementController::class, 'store'])->name('UI.new.expense');
Route::post('/approve/UI/expense', [ExpenseManagementController::class, 'update'])->name('UI.update.expense');
Route::post('/auth/UI/login', [AuthController::class, 'login'])->name('auth.UI.login');
Route::post('/auth/UI/add/user', [AuthController::class, 'addUser'])->name('auth.UI.save');
Route::post('/save/UI/opportunity', [OpportunityController::class, 'store'])->name('save.UI.opportunity');
Route::post('/opportunities/UI/update/{id}', [OpportunityController::class, 'update'])->name('update.UI.opportunity');
Route::post('/opportunities/UI/update/cold/{id}', [OpportunityController::class, 'updateCold'])->name('update.cold.UI.opportunity');

//Reports
Route::get('/reports/targets/performance', [ReportController::class, 'TargetPerformance'])->name('UI.targets.performance');
Route::get('/reports/tasks/activities', [ReportController::class, 'TaskActivities'])->name('UI.task.activities');
Route::get('/reports/customer/feedback', [ReportController::class, 'CustomerFeedback'])->name('UI.customer.feedback');

//Company
Route::get('/company/detail/{id}', [CompanyController::class, 'show'])->name('UI.company.details');
Route::get('/bank/documents/detail', [FetchBanksDocumentsController::class, 'getDocuments'])->name('bank.documents.details');
Route::get('/details/UI/bank/documents', [FetchBanksDocumentsController::class, 'getBankDocuments'])->name('details.bank.documents');

Route::post('/store/UI/pipeline/data', [PipelineController::class, 'store'])->name('store.UI.pipeline.data');
Route::post('/update/UI/pipeline/data/{id}', [PipelineController::class, 'updatePipeline'])->name('update.UI.pipeline.data.id');
Route::post('/store/UI/pipeline/lead/data/{id}', [PipelineController::class, 'update'])->name('store.UI.pipeline.lead.data');
Route::post('/store/UI/pipeline/opportunity/data/{id}', [PipelineController::class, 'update'])->name('store.UI.pipeline.opportunity.data');
Route::get('/get/UI/pipeline/data', [PipelineController::class, 'index'])->name('get.UI.pipeline.data');
Route::post('/post/UI/new/contact', [PipelineController::class, 'addNewContact'])->name('get.UI.pipeline.addNewContact');
Route::get('/get/UI/pipeline/{id}', [PipelineController::class, 'getIDPipeline'])->name('get.UI.pipeline.getIDPipeline');
Route::get('/get/UI/pipeline/widget/data', [PipelineController::class, 'getWidgetData'])->name('get.UI.pipeline.getWidgetData');
Route::get('/get/UI/reports/widget/data', [PipelineController::class, 'getWidgetReportData'])->name('get.UI.pipeline.getWidgetData');
Route::get('/get/UI/reports/pipeline/count', [PipelineController::class, 'getPipelineCount'])->name('get.UI.pipeline.getPipelineCount');
Route::get('/get/UI/reports/conversion/analysis', [PipelineController::class, 'getCountPipelineWithinAPeriod'])->name('get.UI.pipeline.getCountPipelineWithinAPeriod');
Route::get('/get/UI/pipelines/contacts', [PipelineController::class, 'contactDetails'])->name('get.UI.pipeline.contactDetails');
Route::get('/get/UI/association/contacts', [PipelineController::class, 'getAssociationContacts'])->name('get.UI.pipeline.contactDetails');
Route::get('/get/UI/associated/contacts', [PipelineController::class, 'getAssociatedContacts'])->name('get.UI.pipeline.getAssociatedContacts');
Route::post('/post/UI/association/contacts', [PipelineController::class, 'postAssociationContacts'])->name('get.UI.pipeline.contactDetails');
Route::get('/get/UI/products/reports', [PipelineController::class, 'productReport'])->name('get.UI.pipeline.productReports');
Route::get('/get/UI/report/products/counts', [PipelineController::class, 'getProductCounts'])->name('get.UI.pipeline.getProductCounts');
Route::get('/get/UI/closed/deals/reports', [PipelineController::class, 'getClosedDealsReports'])->name('get.UI.pipeline.getClosedDealsReports');
Route::get('/get/UI/pipelines/leads', [PipelineController::class, 'leadDetails'])->name('get.UI.pipeline.leadDetails');
Route::get('/get/UI/pipelines/opportunity', [PipelineController::class, 'opportunityDetails'])->name('get.UI.pipeline.leadDetails');
Route::get('/get/UI/recent/pipeline/count', [PipelineController::class, 'countPipelineCreatedEachMonth'])->name('count.pipeline.createdd.each.month');
Route::get('/get/UI/active/dashboard/pipeline', [PipelineController::class, 'activePipeline'])->name('count.active.pipeline');
Route::get('/get/UI/count/each/stage', [PipelineController::class, 'countEachStageYearly'])->name('count.each.stage.yearly');
Route::get('/get/UI/recent/prospects/dashboard', [PipelineController::class, 'recentDashboardProspect'])->name('get.UI.pipeline.recent.prospect.dashboard');
Route::get('/get/UI/pipelines/closed', [PipelineController::class, 'closedDetails'])->name('get.UI.pipeline.leadDetails');
Route::get('/get/UI/dashboard/lead/opportunity', [PipelineController::class, 'getLeadsOpportunityCount'])->name('get.UI.pipeline.lead.opportunity');
Route::get('/get/UI/pipeline/cold', [PipelineController::class, 'coldDetails'])->name('get.UI.pipeline.coldDetails');
Route::get('/get/UI/top/product', [PipelineController::class, 'getTopProduct'])->name('get.top.products');
Route::get('/get/UI/leads/reports', [PipelineController::class, 'getLeadsReport'])->name('get.leads.reports.ui');
Route::post('/check/email', [PipelineController::class, 'checkEmail'])->name('get.UI.check.email.exists');
Route::get('/get/lead/names', function () {
    return response()->json(Pipeline::select('id', 'name')->get());

})->name('get.lead.names');

Route::get('/get/specific/pipeline/{id}', function ($id) {
    return response()->json(Pipeline::whereId($id)->get());

})->name('get.lead.names');
Route::post('/mark/UI/pipeline/hot/{id}', function ($id) {
    return Pipeline::whereId($id)->update(['status' => 'hot']);
});
Route::get('/get/UI/source/analysis', [SourceAnalysisController::class, 'sourceAnalysis'])->name('get.UI.pipeline.sourceAnalysis');
Route::get('/get/UI/dashboard/source/analysis', [SourceAnalysisController::class, 'sourceAnalysisDashboardChannel'])->name('get.UI.pipeline.sourceAnalysis');
Route::get('/test/email/service', [MailingController::class, 'test'])->name('sending.mail.org');
Route::post('/generate/documents/link', [MailingController::class, 'generateLink'])->name('generate.document.link.org');
Route::get('/get/uuid/document/{uuid}', [UploadDocumentController::class, 'getDocument'])->name('get.uuid.document');
Route::post('/post/uuid/document', [UploadDocumentController::class, 'postDocument'])->name('post.uuid.document');
Route::get('/compliance/uuid/documents/{email}', [UploadDocumentController::class, 'getCompliance'])->name('get.uuid.compliance.document');
Route::get('/invoice/UI/request', [InvoiceController::class, 'index'])->name('UI.dashboard.invoices.request');
Route::get('/all/UI/program', [ProgramController::class, 'index'])->name('UI.dashboard.programs');
Route::get('/all/UI/transactions', [TransactionController::class, 'index'])->name('UI.dashboard.transactions');

//Schedules
Route::get('/get/UI/invited/guest', [ScheduleController::class, 'getGuestList'])->name('UI.gets.invited');
Route::get('/get/UI/meeting/daily/hours', [ScheduleController::class, 'getWeeklyCollectionMeeting'])->name('UI.gets.getWeeklyCollectionMeeting');
Route::post('/post/UI/event', [ScheduleController::class, 'store'])->name('UI.gets.invited');
Route::get('/all/UI/data/followups', [ScheduleController::class, 'index'])->name('UI.gets.followups.data.invited');
Route::get('/recent/activity/dashboard', [ScheduleController::class, 'getRecentActivityDashboard'])->name('recent.activity.dashboard');
Route::get('/schedule/six/monthly', [ScheduleController::class, 'getSixMonthSchedule'])->name('recent.six.month.dashboard');
Route::get('/schedule/count/all', [ScheduleController::class, 'getScheduleCount'])->name('get.schedule.count');
Route::get('/get/latest/schedule', function () {
    return response()->json(Schedule::orderBy('id', 'desc')->first());

})->name('get.latest.schedule');

//Users
Route::get('/users/UI/list', [UserController::class, 'index'])->name('users.UI.list');
Route::post('/add/UI/user', [UserController::class, 'store'])->name('add.UI.user');

//Companies
Route::get('/all/UI/companies', [CompanyController::class, 'index'])->name('UI.dashboard.companies');

// Route::get('/get/UI/companies', [CompanyController::class, 'index'])->name('get.UI.companies');

//Bank

Route::get('/UI/get/banks', [BankController::class, 'index'])->name('UI.get.banks');
Route::get('/UI/get/bank/documents/{id}', [BankController::class, 'bankDocuments'])->name('UI.get.bank.documents');
Route::post('/UI/new/bank', [BankController::class, 'store'])->name('UI.new.bank');
Route::post('/UI/bank/email/check', [BankController::class, 'checkEmail'])->name('UI.bank.email.check');

//Roles

Route::get('/UI/roles/permissions', [RoleTypeController::class, 'index'])->name('UI.roles.permissions');
Route::post('/UI/roles/permissions/data', [RoleTypeController::class, 'store'])->name('UI.roles.permissions.data');

/// Roles
Route::get('/UI/all/roles/data', [PermissionDataController::class, 'index'])->name('UI.all.permission.data');
