<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ExpenseManagementController;
use App\Http\Controllers\FetchBanksDocumentsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MailingController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\PipelineController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SourceAnalysisController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UploadDocumentController;
use App\Http\Controllers\UserController;
use App\Models\Pipeline;
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
Route::post('/store/UI/pipeline/lead/data/{id}', [PipelineController::class, 'update'])->name('store.UI.pipeline.lead.data');
Route::post('/store/UI/pipeline/opportunity/data/{id}', [PipelineController::class, 'update'])->name('store.UI.pipeline.opportunity.data');
Route::get('/get/UI/pipeline/data', [PipelineController::class, 'index'])->name('get.UI.pipeline.data');
Route::get('/get/UI/pipeline/{id}', [PipelineController::class, 'getIDPipeline'])->name('get.UI.pipeline.getIDPipeline');
Route::get('/get/UI/pipeline/widget/data', [PipelineController::class, 'getWidgetData'])->name('get.UI.pipeline.getWidgetData');
Route::get('/get/UI/pipelines/contacts', [PipelineController::class, 'contactDetails'])->name('get.UI.pipeline.contactDetails');
Route::get('/get/UI/pipelines/leads', [PipelineController::class, 'leadDetails'])->name('get.UI.pipeline.leadDetails');
Route::get('/get/UI/pipelines/opportunity', [PipelineController::class, 'opportunityDetails'])->name('get.UI.pipeline.leadDetails');
Route::get('/get/UI/pipelines/closed', [PipelineController::class, 'closedDetails'])->name('get.UI.pipeline.leadDetails');
Route::get('/get/UI/pipeline/cold', [PipelineController::class, 'coldDetails'])->name('get.UI.pipeline.coldDetails');
Route::post('/check/email', [PipelineController::class, 'checkEmail'])->name('get.UI.check.email.exists');
Route::post('/mark/UI/pipeline/hot/{id}', function ($id) {
    return Pipeline::whereId($id)->update(['status' => 'hot']);
});
Route::get('/get/UI/source/analysis', [SourceAnalysisController::class, 'sourceAnalysis'])->name('get.UI.pipeline.sourceAnalysis');
Route::get('/test/email/service', [MailingController::class, 'test'])->name('sending.mail.org');
Route::post('/generate/documents/link', [MailingController::class, 'generateLink'])->name('generate.document.link.org');
Route::get('/get/uuid/document/{uuid}', [UploadDocumentController::class, 'getDocument'])->name('get.uuid.document');
Route::post('/post/uuid/document', [UploadDocumentController::class, 'postDocument'])->name('post.uuid.document');
Route::get('/compliance/uuid/documents/{email}', [UploadDocumentController::class, 'getCompliance'])->name('get.uuid.compliance.document');
Route::get('/invoice/UI/request', [InvoiceController::class, 'index'])->name('UI.dashboard.invoices.request');
Route::get('/all/UI/program', [ProgramController::class, 'index'])->name('UI.dashboard.programs');
Route::get('/all/UI/transactions', [TransactionController::class, 'index'])->name('UI.dashboard.transactions');
Route::get('/all/UI/companies', [CompanyController::class, 'index'])->name('UI.dashboard.companies');

//Schedules
Route::get('/get/UI/invited/guest', [ScheduleController::class, 'getGuestList'])->name('UI.gets.invited');
Route::post('/post/UI/event', [ScheduleController::class, 'store'])->name('UI.gets.invited');
Route::get('/all/UI/data/followups', [ScheduleController::class, 'index'])->name('UI.gets.followups.data.invited');

//Users
Route::get('/users/UI/list', [UserController::class, 'index'])->name('users.UI.list');
Route::post('/add/UI/user', [UserController::class, 'store'])->name('add.UI.user');
