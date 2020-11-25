<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

//Auth::routes();

Route::get('refresh-csrf', function(){
    return csrf_token();
});

//------HOME AND LOGIN MODULE----------
Route::get('/', 'HomeController@signin')->name('login');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@index')->name('dashboard')->middleware('auth');
Route::any('/login', 'Auth\LoginController@login')->name('login_user');
Route::any('/logout', 'Auth\LoginController@signout')->name('logout');

Route::get('/external', 'Auth\TempUserLoginController@signin')->name('temp_user_login');
Route::get('/temp_user_dashboard', 'Auth\TempUserHomeController@index')->name('temp_user_dashboard')->middleware('auth:temp_user');
Route::any('/login_temp_user', 'Auth\TempUserLoginController@login')->name('login_temp_user');
Route::any('/temp_user_logout', 'Auth\TempUserHomeController@signout')->name('temp_user_logout');

// -------------DEPARTMENT MODULE-----------
Route::any('/department', 'DepartmentController@index')->name('department')->middleware('auth.admin');
Route::post('/create_dept', 'DepartmentController@create')->name('create_dept');
Route::post('/edit_dept_form', 'DepartmentController@editForm')->name('edit_dept_form');
Route::post('/edit_dept', 'DepartmentController@edit')->name('edit_dept');
Route::post('/delete_dept', 'DepartmentController@destroy')->name('delete_dept');

// -------------POSITION MODULE-----------
Route::any('/position', 'PositionController@index')->name('position')->middleware('auth.admin');
Route::post('/create_position', 'PositionController@create')->name('create_position');
Route::post('/edit_position_form', 'PositionController@editForm')->name('edit_position_form');
Route::post('/edit_position', 'PositionController@edit')->name('edit_position');
Route::post('/delete_position', 'PositionController@destroy')->name('delete_position');

// -------------SALARY COMPONENT MODULE-----------
Route::any('/salary_component', 'SalaryComponentController@index')->name('salary_component')->middleware('auth.admin');
Route::post('/create_component', 'SalaryComponentController@create')->name('create_component');
Route::post('/edit_component_form', 'SalaryComponentController@editForm')->name('edit_component_form');
Route::post('/edit_component', 'SalaryComponentController@edit')->name('edit_component');
Route::post('/delete_component', 'SalaryComponentController@destroy')->name('delete_component');

// -------------SALARY STRUCTURE MODULE-----------
Route::any('/salary_structure', 'SalaryStructureController@index')->name('salary_structure')->middleware('auth.admin');
Route::post('/create_structure', 'SalaryStructureController@create')->name('create_structure');
Route::post('/edit_structure_form', 'SalaryStructureController@editForm')->name('edit_structure_form');
Route::post('/edit_structure', 'SalaryStructureController@edit')->name('edit_structure');
Route::any('/fetch_tax_data', 'SalaryStructureController@fetchTaxData')->name('fetch_tax_data');
Route::post('/delete_structure', 'SalaryStructureController@destroy')->name('delete_structure');

// -------------APPROVAL SYSTEM MODULE-----------
Route::any('/approval_system', 'ApprovalSysController@index')->name('approval_system')->middleware('auth.admin');
Route::post('/create_approval', 'ApprovalSysController@create')->name('create_approval');
Route::post('/edit_approval_form', 'ApprovalSysController@editForm')->name('edit_approval_form');
Route::post('/edit_approval', 'ApprovalSysController@edit')->name('edit_approval');
Route::post('/delete_approval', 'ApprovalSysController@destroy')->name('delete_approval');

// -------------DEPARTMENTAL APPROVAL MODULE-----------
Route::any('/approval_dept', 'ApprovalDeptController@index')->name('approval_dept')->middleware('auth.admin');
Route::post('/create_approval_dept', 'ApprovalDeptController@create')->name('create_approval_dept');
Route::post('/edit_approval_dept_form', 'ApprovalDeptController@editForm')->name('edit_approval_dept_form');
Route::post('/edit_approval_dept', 'ApprovalDeptController@edit')->name('edit_approval_dept');
Route::post('/delete_approval_dept', 'ApprovalDeptController@destroy')->name('delete_approval_dept');

// -------------TAX MODULE-----------
Route::any('/tax_system', 'TaxController@index')->name('tax_system')->middleware('auth.admin');
Route::post('/create_tax', 'TaxController@create')->name('create_tax');
Route::post('/edit_tax_form', 'TaxController@editForm')->name('edit_tax_form');
Route::post('/edit_tax', 'TaxController@edit')->name('edit_tax');
Route::post('/delete_tax', 'TaxController@destroy')->name('delete_tax');

// -------------USER MODULE-----------
Route::any('/user', 'UsersController@index')->name('user')->middleware('auth');
Route::post('/create_user', 'UsersController@create')->name('create_user');
Route::post('/edit_user_form', 'UsersController@editForm')->name('edit_user_form');
Route::post('/edit_user', 'UsersController@edit')->name('edit_user');
Route::get('/user_profile/{uid}', 'UsersController@userProfile')->name('profile')->middleware('auth');
Route::any('/search_user', 'UsersController@searchUser')->name('user_search');
Route::post('/delete_user', 'UsersController@destroy')->name('delete_user');
Route::post('/change_user_status', 'UsersController@changeStatus')->name('change_user_status');

// -------------USER API MODULE-----------
Route::any('/user_api', 'UsersApiController@index')->name('user_api');
Route::any('/get_user_count_api', 'UsersApiController@getUserCount')->name('get_user_count_api');
Route::any('/change_user_dormant_status_api', 'UsersController@changeUserDormantStatus')->name('change_user_dormant_status_api');
Route::any('/activate_user_portal_api', 'UsersController@activateUserPortal')->name('activate_user_portal_api');

// -------------CURRENCY UNIT ROUTES FOR FUNCTIONS-----------
Route::any('/currencies', 'CurrencyController@index')->name('currencies')->middleware('auth');
Route::any('/currency_status', 'CurrencyController@currencyStatus')->name('currency_status');
Route::any('/default_currency', 'CurrencyController@defaultCurrency')->name('default_currency');
Route::any('/edit_currency_form', 'CurrencyController@editForm')->name('edit_currency_form');

// -------------GENERAL UNIT ROUTES FOR FUNCTIONS-----------
Route::any('/add_more', 'GeneralController@addMore')->name('add_more');
Route::any('/default_select', 'GeneralController@selectOptions')->name('select_options');
Route::any('/get_currency', 'GeneralController@get_currency')->name('get_currency');
Route::any('/exchange_rate', 'GeneralController@exchangeRate')->name('exchange_rate');
Route::any('/vendor_customer_currency', 'GeneralController@vendorCustomerCurrency')->name('vendor_customer_currency');
Route::any('/inventory_details', 'GeneralController@inventoryDetails')->name('inventory_details');
Route::any('/amount_to_default_curr', 'GeneralController@convertToDefault')->name('amount_to_default_curr');
Route::any('/get_rate', 'GeneralController@getRate')->name('get_rate');
Route::any('/update_sum', 'GeneralController@updateSum')->name('update_sum');

// -------------COMPANY INFO MODULE-----------
Route::any('/company', 'CompanyController@index')->name('company')->middleware('auth.admin');
Route::post('/create_company', 'CompanyController@create')->name('create_company');
Route::post('/edit_company_form', 'CompanyController@editForm')->name('edit_company_form');
Route::post('/edit_company', 'CompanyController@edit')->name('edit_company');
Route::post('/delete_company', 'CompanyController@destroy')->name('delete_company');
Route::post('/change_company_status', 'CompanyController@changeStatus')->name('change_company_status');

// -------------DEPARTMENTAL HEAD MODULE-----------
Route::any('/dept_approval', 'ApprovalDeptController@index')->name('dept_approval')->middleware('auth.admin');
Route::post('/create_dept_approval', 'ApprovalDeptController@create')->name('create_dept_approval');
Route::post('/edit_dept_approval_form', 'ApprovalDeptController@editForm')->name('edit_dept_approval_form');
Route::post('/edit_dept_approval', 'ApprovalDeptController@edit')->name('edit_dept_approval');
Route::post('/delete_dept_approval', 'ApprovalDeptController@destroy')->name('delete_dept_approval');

// -------------REQUISITION MODULE-----------
Route::any('/requisition', 'RequisitionController@index')->name('requisition')->middleware('auth');
Route::any('/my_requests', 'RequisitionController@myRequests')->name('my_request')->middleware('auth');
Route::any('/salary_advance_requests', 'RequisitionController@salaryAdvanceRequests')->name('salary_advance_requests')->middleware('auth');
Route::any('/finance_requests', 'RequisitionController@financeRequests')->name('finance_requests')->middleware('auth');
Route::any('/approved_requests', 'RequisitionController@approvedRequests')->name('approved_requests')->middleware('auth');
Route::any('/chart_approved_requests', 'RequisitionController@chartApprovedRequests')->name('chart_approved_requests')->middleware('auth');
Route::any('/table_request_report', 'RequisitionController@tableRequestReport')->name('table_request_report')->middleware('auth');
Route::any('/print_request', 'RequisitionController@searchRequests')->name('print_request')->middleware('auth');
Route::any('/loan_requests', 'RequisitionController@loanRequests')->name('loan_requests')->middleware('auth');
Route::post('/request_print_preview', 'RequisitionController@printPreview')->name('request_print_preview');
Route::post('/create_requisition', 'RequisitionController@create')->name('create_requisition');
Route::post('/approve_requisition', 'RequisitionController@approval')->name('approve_requisition');
Route::post('/approve_finance_requests', 'RequisitionController@approveFinanceRequests')->name('approve_finance_requests');
Route::post('/edit_requisition_form', 'RequisitionController@editForm')->name('edit_requisition_form');
Route::post('/edit_attachment_form', 'RequisitionController@attachmentForm')->name('edit_attachment_form');
Route::post('/edit_requisition', 'RequisitionController@edit')->name('edit_requisition');
Route::post('/edit_attachment', 'RequisitionController@editAttachment')->name('edit_attachment');
Route::post('/remove_attachment', 'RequisitionController@removeAttachment')->name('remove_attachment');
Route::any('/download_attachment', 'RequisitionController@downloadAttachment')->name('download_attachment');
Route::post('/delete_requisition', 'RequisitionController@destroy')->name('delete_requisition');

// -------------PROJECT MODULE-----------
Route::any('/project', 'ProjectController@index')->name('project')->middleware('auth');
Route::any('/project_report', 'ProjectController@project_report')->name('project_report')->middleware('auth');
Route::any('/project_item/{id}', 'ProjectController@projectItem')->name('project_item')->middleware('auth');

Route::any('/project/temp', 'ProjectController@indexTemp')->name('project_temp')->middleware('auth:temp_user');
Route::any('/project_item/{id}/temp', 'ProjectController@projectItemTemp')->name('project_item_temp')->middleware('auth:temp_user');


Route::post('/create_project', 'ProjectController@create')->name('create_project');
Route::post('/edit_project_form', 'ProjectController@editForm')->name('edit_project_form');
Route::post('/edit_project', 'ProjectController@edit')->name('edit_project');
Route::post('/delete_project', 'ProjectController@destroy')->name('delete_project');

// ------------PROJECT MILESTONE MODULE---------------
Route::any('/project/{id}/milestone', 'MilestoneController@index')->name('milestone')->middleware('auth');
Route::any('/project/{id}/milestone/temp', 'MilestoneController@indexTemp')->name('milestone_temp')->middleware('auth:temp_user');
Route::post('/create_milestone', 'MilestoneController@create')->name('create_milestone');
Route::post('/edit_milestone_form', 'MilestoneController@editForm')->name('edit_milestone_form');
Route::any('/milestone_item', 'MilestoneController@milestoneTaskListItem')->name('milestone_item');
Route::any('/milestone_task_list_form', 'MilestoneController@milestoneTaskList')->name('milestone_form');
Route::any('/milestone_task_form', 'MilestoneController@milestoneTask')->name('milestone_form');
Route::post('/edit_milestone', 'MilestoneController@edit')->name('edit_milestone');
Route::post('/delete_milestone', 'MilestoneController@destroy')->name('delete_milestone');
Route::post('/delete_milestone_task', 'MilestoneController@destroyMilestoneTask')->name('delete_milestone_task');
Route::post('/delete_milestone_list', 'MilestoneController@destroyMilestoneList')->name('delete_milestone_list');


// ------------PROJECT TASK LIST MODULE---------------
Route::any('/project/{id}/task_list', 'TaskListController@index')->name('task_list')->middleware('auth');
Route::any('/project/{id}/task_list/temp', 'TaskListController@indexTemp')->name('task_list_temp')->middleware('auth:temp_user');
Route::post('/create_task_list', 'TaskListController@create')->name('create_task_list');
Route::post('/edit_task_list_form', 'TaskListController@editForm')->name('edit_task_list_form');
Route::any('/task_form', 'TaskListController@taskForm')->name('task_form');
Route::post('/edit_task_list', 'TaskListController@edit')->name('edit_task_list');
Route::any('/delete_task_list_item', 'TaskListController@destroyListItem')->name('delete_task_list_item');
Route::post('/delete_task_list', 'TaskListController@destroy')->name('delete_task_list');

// ------------PROJECT TASK MODULE---------------
Route::any('/project/{id}/task', 'TaskController@index')->name('task')->middleware('auth');
Route::any('/project/{id}/task/temp', 'TaskController@indexTemp')->name('task_temp')->middleware('auth:temp_user');

Route::post('/create_task', 'TaskController@create')->name('create_task');
Route::post('/edit_task_form', 'TaskController@editForm')->name('edit_task_form');
Route::post('/edit_task', 'TaskController@edit')->name('edit_task');
Route::post('/delete_task', 'TaskController@destroy')->name('delete_task');

// ------------PROJECT TEAM MODULE---------------
Route::any('/project/{id}/project_team', 'ProjectTeamController@index')->name('project_team')->middleware('auth');
Route::any('/project/{id}/project_team/temp', 'ProjectTeamController@indexTemp')->name('project_team_temp')->middleware('auth:temp_user');

Route::post('/create_project_team', 'ProjectTeamController@create')->name('create_project_team');
Route::post('/edit_project_team_form', 'ProjectTeamController@editForm')->name('edit_project_team_form');
Route::post('/edit_project_team', 'ProjectTeamController@edit')->name('edit_project_team');
Route::post('/delete_project_team', 'ProjectTeamController@destroy')->name('delete_project_team');

// ------------PROJECT TIMESHEET MODULE---------------
Route::any('/project/{id}/timesheet', 'TimesheetController@index')->name('timesheet')->middleware('auth');
Route::any('/project/{id}/timesheet_approval', 'TimesheetController@approval')->name('timesheet_approval')->middleware('auth');
Route::any('/project/{id}/timesheet/temp', 'TimesheetController@indexTemp')->name('timesheet_temp')->middleware('auth:temp_user');
Route::post('/create_timesheet', 'TimesheetController@create')->name('create_timesheet');
Route::any('/search_timesheet_approval', 'TimesheetController@searchTimesheet')->name('search_timesheet_approval');
Route::any('/approve_timesheet', 'TimesheetController@approveTimesheet')->name('approve_timesheet');
Route::post('/edit_timesheet_form', 'TimesheetController@editForm')->name('edit_timesheet_form');
Route::post('/edit_timesheet', 'TimesheetController@edit')->name('edit_timesheet');
Route::post('/delete_timesheet', 'TimesheetController@destroy')->name('delete_timesheet');
Route::any('/download_timesheet_attachment', 'TimesheetController@downloadAttachment')->name('download_timesheet_attachment');
Route::any('/edit_timesheet_attachment_form', 'TimesheetController@attachmentForm')->name('edit_timesheet_attachment_form');
Route::any('/edit_timesheet_attachment', 'TimesheetController@editAttachment')->name('edit_timesheet_attachment');
Route::any('/remove_timesheet_attachment', 'TimesheetController@removeAttachment')->name('remove_timesheet_attachment');

// ------------PROJECT MEMBER REQUEST MODULE---------------
Route::any('/project/{id}/project_request', 'ProjectMemberRequestController@index')->name('project_request')->middleware('auth');
Route::any('/project/{id}/all_request', 'ProjectMemberRequestController@allRequests')->name('all_request')->middleware('auth');
Route::any('/project/{id}/project_request/temp', 'ProjectMemberRequestController@indexTemp')->name('project_request_temp')->middleware('auth:temp_user');
Route::any('/project_request_response_form', 'ProjectMemberRequestController@requestResponseForm')->name('project_request_response_form');
Route::any('/project_request_response', 'ProjectMemberRequestController@requestResponse')->name('project_request_response');
Route::post('/create_project_request', 'ProjectMemberRequestController@create')->name('create_project_request');
Route::post('/edit_project_request_form', 'ProjectMemberRequestController@editForm')->name('edit_project_request_form');
Route::post('/edit_project_request', 'ProjectMemberRequestController@edit')->name('edit_project_request');
Route::post('/delete_project_request', 'ProjectMemberRequestController@destroy')->name('delete_project_request');

// ------------PROJECT CHANGE LOG MODULE---------------
Route::any('/project/{id}/change_log', 'ChangeLogController@index')->name('change_log')->middleware('auth');
Route::any('/project/{id}/change_log/temp', 'ChangeLogController@indexTemp')->name('change_log_temp')->middleware('auth:temp_user');

Route::any('/project/{id}/change_log/{log_id}', 'ChangeLogController@changeView')->name('change_view')->middleware('auth');
Route::any('/project/{id}/change_log/{log_id}/temp', 'ChangeLogController@changeViewTemp')->name('change_view_temp')->middleware('auth:temp_user');


Route::post('/create_change_log', 'ChangeLogController@create')->name('create_change_log');
Route::any('/comment_change_log', 'ChangeLogController@comment')->name('comment_change_log');
Route::post('/edit_change_log_form', 'ChangeLogController@editForm')->name('edit_change_log_form');
Route::post('/edit_change_log', 'ChangeLogController@edit')->name('edit_change_log');
Route::post('/delete_change_log', 'ChangeLogController@destroy')->name('delete_change_log');

// ------------PROJECT ASSUMPTION/CONSTRAINT MODULE---------------
Route::any('/project/{id}/assump_constraint', 'AssumpConstraintsController@index')->name('assump_constraint')->middleware('auth');
Route::any('/project/{id}/assump_constraint/temp', 'AssumpConstraintsController@indexTemp')->name('assump_constraint_temp')->middleware('auth:temp_user');

Route::any('/project/{id}/assump_constraint/{log_id}', 'AssumpConstraintsController@assumpView')->name('assump_view')->middleware('auth');
Route::any('/project/{id}/assump_constraint/{log_id}/temp', 'AssumpConstraintsController@assumpViewTemp')->name('assump_view_temp')->middleware('auth:temp_user');


Route::post('/create_assump_constraint', 'AssumpConstraintsController@create')->name('create_assump_constraint');
Route::any('/comment_assump_constraint', 'AssumpConstraintsController@comment')->name('comment_assump_constraint');
Route::post('/edit_assump_constraint_form', 'AssumpConstraintsController@editForm')->name('edit_assump_constraint_form');
Route::post('/edit_assump_constraint', 'AssumpConstraintsController@edit')->name('edit_assump_constraint');
Route::post('/delete_assump_constraint', 'AssumpConstraintsController@destroy')->name('delete_assump_constraint');

// ------------PROJECT DECISION MODULE---------------
Route::any('/project/{id}/decision', 'DecisionController@index')->name('decision')->middleware('auth');
Route::any('/project/{id}/decision/temp', 'DecisionController@indexTemp')->name('decision_temp')->middleware('auth:temp_user');

Route::any('/project/{id}/decision/{log_id}', 'DecisionController@decisionView')->name('decision_view')->middleware('auth');
Route::any('/project/{id}/decision/{log_id}/temp', 'DecisionController@decisionViewTemp')->name('decision_view_temp')->middleware('auth:temp_user');


Route::post('/create_decision', 'DecisionController@create')->name('create_decision');
Route::any('/comment_decision', 'DecisionController@comment')->name('comment_decision');
Route::post('/edit_decision_form', 'DecisionController@editForm')->name('edit_decision_form');
Route::post('/edit_decision', 'DecisionController@edit')->name('edit_decision');
Route::post('/delete_decision', 'DecisionController@destroy')->name('delete_decision');

// ------------PROJECT DELIVERABLE MODULE---------------
Route::any('/project/{id}/deliverable', 'deliverableController@index')->name('deliverable')->middleware('auth');
Route::any('/project/{id}/deliverable/temp', 'deliverableController@indexTemp')->name('deliverable_temp')->middleware('auth:temp_user');

Route::any('/project/{id}/deliverable/{log_id}', 'deliverableController@deliverableView')->name('deliverable_view')->middleware('auth');
Route::any('/project/{id}/deliverable/{log_id}/temp', 'deliverableController@deliverableViewTemp')->name('deliverable_view_temp')->middleware('auth:temp_user');


Route::post('/create_deliverable', 'deliverableController@create')->name('create_deliverable');
Route::any('/comment_deliverable', 'deliverableController@comment')->name('comment_deliverable');
Route::post('/edit_deliverable_form', 'deliverableController@editForm')->name('edit_deliverable_form');
Route::post('/edit_deliverable', 'deliverableController@edit')->name('edit_deliverable');
Route::post('/delete_deliverable', 'deliverableController@destroy')->name('delete_deliverable');

// ------------PROJECT ISSUES MODULE---------------
Route::any('/project/{id}/issues', 'IssuesController@index')->name('issues')->middleware('auth');
Route::any('/project/{id}/issues/temp', 'IssuesController@indexTemp')->name('issues_temp')->middleware('auth:temp_user');

Route::post('/create_issues', 'IssuesController@create')->name('create_issues');
Route::post('/edit_issues_form', 'IssuesController@editForm')->name('edit_issues_form');
Route::post('/edit_issues', 'IssuesController@edit')->name('edit_issues');
Route::post('/delete_issues', 'IssuesController@destroy')->name('delete_issues');

// ------------PROJECT LESSON LEARNT MODULE---------------
Route::any('/project/{id}/lesson_learnt', 'LessonLearntController@index')->name('lesson_learnt')->middleware('auth');
Route::any('/project/{id}/lesson_learnt/temp', 'LessonLearntController@indexTemp')->name('issues_temp')->middleware('auth:temp_user');

Route::post('/create_lesson_learnt', 'LessonLearntController@create')->name('create_lesson_learnt');
Route::post('/edit_lesson_learnt_form', 'LessonLearntController@editForm')->name('edit_lesson_learnt_form');
Route::post('/edit_lesson_learnt', 'LessonLearntController@edit')->name('edit_lesson_learnt');
Route::post('/delete_lesson_learnt', 'LessonLearntController@destroy')->name('delete_lesson_learnt');

// ------------PROJECT RISK MODULE---------------
Route::any('/project/{id}/risk', 'RiskController@index')->name('risk')->middleware('auth');
Route::any('/project/{id}/risk/temp', 'RiskController@indexTemp')->name('risk_temp')->middleware('auth:temp_user');

Route::post('/create_risk', 'RiskController@create')->name('create_risk');
Route::post('/edit_risk_form', 'RiskController@editForm')->name('edit_risk_form');
Route::post('/edit_risk', 'RiskController@edit')->name('edit_risk');
Route::post('/delete_risk', 'RiskController@destroy')->name('delete_risk');

// ------------PROJECT DOCS MODULE---------------
Route::any('/project/{id}/project_docs', 'ProjectDocsController@index')->name('project_docs')->middleware('auth');
Route::any('/project/{id}/project_docs/temp', 'ProjectDocsController@indexTemp')->name('project_docs_temp')->middleware('auth:temp_user');

Route::post('/create_project_docs', 'ProjectDocsController@create')->name('create_project_docs');
Route::post('/edit_project_docs_form', 'ProjectDocsController@editForm')->name('edit_project_docs_form');
Route::post('/edit_project_docs_attachment_form', 'ProjectDocsController@attachmentForm')->name('edit_project_docs_attachment_form');
Route::post('/edit_project_docs', 'ProjectDocsController@edit')->name('edit_project_docs');
Route::post('/edit_project_docs_attachment', 'ProjectDocsController@editAttachment')->name('edit_project_docs_attachment');
Route::post('/delete_project_docs', 'ProjectDocsController@destroy')->name('delete_project_docs');
Route::any('/download_project_docs_attachment', 'ProjectDocsController@downloadAttachment')->name('download_project_docs_attachment');
Route::post('/remove_project_docs_attachment', 'ProjectDocsController@removeAttachment')->name('remove_project_docs_attachment');

// ------------PROJECT STATUS MODULE---------------
Route::any('/project/{id}/project_status', 'ProjectStatusController@index')->name('project_status')->middleware('auth');
Route::any('/project/{id}/project_status/temp', 'ProjectStatusController@indexTemp')->name('project_status_temp')->middleware('auth:temp_user');
Route::any('/project_status', 'ProjectStatusController@projectStatus')->name('project_general_status')->middleware('auth');

// ------------PROJECT REPORT SINGLE MODULE---------------
Route::any('/project/{id}/project_report', 'ProjectReportController@index2')->name('project_report_single')->middleware('auth');
Route::any('/project/{id}/project_report/temp', 'ProjectReportController@indexTemp')->name('project_report_single_temp')->middleware('auth:temp_user');

Route::any('/project_report', 'ProjectReportController@index')->name('project_report')->middleware('auth');
Route::any('/search_project_report', 'ProjectReportController@searchReport')->name('search_report')->middleware('auth');


// -------------REQUEST CATEGORY MODULE FOR REQUISITION-----------
Route::any('/request_category', 'RequestCategoryController@index')->name('request_category')->middleware('auth');
Route::post('/create_request_cat', 'RequestCategoryController@create')->name('create_request_cat');
Route::post('/edit_request_cat_form', 'RequestCategoryController@editForm')->name('edit_request_cat_form');
Route::post('/edit_request_cat', 'RequestCategoryController@edit')->name('edit_request_cat');
Route::post('/delete_request_cat', 'RequestCategoryController@destroy')->name('delete_request_cat');

// -------------COMPETENCY CATEGORY MODULE-----------
Route::any('/competency_category', 'SkillCompCatController@index')->name('competency_category')->middleware('auth');
Route::post('/create_comp_cat', 'SkillCompCatController@create')->name('create_comp_cat');
Route::post('/edit_comp_cat_form', 'SkillCompCatController@editForm')->name('edit_comp_cat_form');
Route::post('/edit_comp_cat', 'SkillCompCatController@edit')->name('edit_comp_cat');
Route::post('/delete_comp_cat', 'SkillCompCatController@destroy')->name('delete_comp_cat');

// -------------COMPETENCY FRAMEWORK MODULE-----------
Route::any('/competency_framework', 'CompetencyFrameworkController@index')->name('competency_framework')->middleware('auth');
Route::post('/create_comp_frame', 'CompetencyFrameworkController@create')->name('create_comp_frame');
Route::post('/edit_comp_frame_form', 'CompetencyFrameworkController@editForm')->name('edit_comp_frame_form');
Route::any('/search_frame', 'CompetencyFrameworkController@searchFrame')->name('search_frame');
Route::post('/edit_comp_frame', 'CompetencyFrameworkController@edit')->name('edit_comp_frame');
Route::post('/delete_comp_frame', 'CompetencyFrameworkController@destroy')->name('delete_comp_frame');

// -------------COMPETENCY MAP MODULE-----------
Route::any('/competency_map', 'CompetencyMapController@index')->name('competency_map')->middleware('auth');
Route::post('/create_comp_map', 'CompetencyMapController@create')->name('create_comp_map');
Route::post('/edit_comp_map_form', 'CompetencyMapController@editForm')->name('edit_comp_map_form');
Route::any('/search_map', 'CompetencyMapController@searchFrame')->name('search_map');
Route::post('/edit_comp_map', 'CompetencyMapController@edit')->name('edit_comp_map');
Route::post('/delete_comp_map', 'CompetencyMapController@destroy')->name('delete_comp_map');


// -------------APPRAISAL SUPERVISION MODULE-----------
Route::any('/appraisal_supervision', 'AppraisalSupervisionController@index')->name('appraisal_supervision')->middleware('auth.admin');
Route::post('/create_appraisal_sup', 'AppraisalSupervisionController@create')->name('create_appraisal_sup');
Route::post('/edit_appraisal_sup_form', 'AppraisalSupervisionController@editForm')->name('edit_appraisal_sup_form');
Route::post('/edit_appraisal_sup', 'AppraisalSupervisionController@edit')->name('edit_appraisal_sup');
Route::post('/delete_appraisal_sup', 'AppraisalSupervisionController@destroy')->name('delete_appraisal_sup');

// -------------UNIT GOAL SET MODULE-----------
Route::any('/appraisal_goal_set', 'UnitGoalSeriesController@index')->name('appraisal_goal_set')->middleware('auth');
Route::post('/create_ug_series', 'UnitGoalSeriesController@create')->name('create_ug_series');
Route::post('/edit_ug_series_form', 'UnitGoalSeriesController@editForm')->name('edit_ug_series_form');
Route::post('/edit_ug_series', 'UnitGoalSeriesController@edit')->name('edit_ug_series');
Route::post('/delete_ug_series', 'UnitGoalSeriesController@destroy')->name('delete_ug_series');

// -------------UNIT GOAL MODULE-----------
Route::any('/unit_goal', 'UnitGoalController@index')->name('unit_goal')->middleware('auth');
Route::post('/create_unit_goal', 'UnitGoalController@create')->name('create_unit_goal');
Route::post('/edit_unit_goal_form', 'UnitGoalController@editForm')->name('edit_unit_goal_form');
Route::post('/edit_unit_goal', 'UnitGoalController@edit')->name('edit_unit_goal');
Route::post('/search_unit_goal', 'UnitGoalController@searchUnitGoal')->name('search_unit_goal');
Route::post('/delete_unit_goal', 'UnitGoalController@destroy')->name('delete_unit_goal');
Route::post('/status_indi_goal', 'UnitGoalController@statusChange')->name('status_indi_goal');

// -------------INDIVIDUAL GOAL MODULE-----------
Route::any('/individual_goal', 'IndiGoalController@index')->name('individual_goal')->middleware('auth');
Route::any('/mark_indi_goal', 'IndiGoalController@markIndiGoal')->name('mark_indi_goal')->middleware('auth');
Route::any('/view_unit_head_comments', 'IndiGoalController@viewUnitHeadComments')->name('view_unit_head_comments')->middleware('auth');
Route::any('/review_unit_head_comments', 'IndiGoalController@reviewUnitHeadComments')->name('review_unit_head_comments')->middleware('auth');
Route::post('/create_indi_goal', 'IndiGoalController@create')->name('create_indi_goal');
Route::post('/edit_indi_goal_form', 'IndiGoalController@editForm')->name('edit_indi_goal_form');
Route::post('/edit_indi_goal', 'IndiGoalController@edit')->name('edit_indi_goal');
Route::post('/search_indi_goal', 'IndiGoalController@searchIndiGoal')->name('search_indi_goal');
Route::post('/delete_indi_goal', 'IndiGoalController@destroy')->name('delete_indi_goal');
Route::post('/status_indi_goal', 'IndiGoalController@statusChange')->name('status_indi_goal');

// -------------REQUEST ACCESS MODULE-----------
Route::any('/request_access', 'RequestAccessController@index')->name('request_access')->middleware('auth.admin');
Route::post('/create_request_access', 'RequestAccessController@create')->name('create_request_access');
Route::post('/edit_request_access_form', 'RequestAccessController@editForm')->name('edit_request_access_form');
Route::post('/edit_request_access', 'RequestAccessController@edit')->name('edit_request_access');
Route::post('/delete_request_access', 'RequestAccessController@destroy')->name('delete_request_access');

// -------------DEPARTMENTAL LEAVE MODULE-----------
Route::any('/leave_approval', 'LeaveApprovalController@index')->name('leave_approval')->middleware('auth.admin');
Route::post('/create_leave_approval', 'LeaveApprovalController@create')->name('create_leave_approval');
Route::post('/edit_leave_approval_form', 'LeaveApprovalController@editForm')->name('edit_leave_approval_form');
Route::post('/edit_leave_approval', 'LeaveApprovalController@edit')->name('edit_leave_approval');
Route::post('/delete_leave_approval', 'LeaveApprovalController@destroy')->name('delete_leave_approval');

// -------------HRIS APPROVAL SYSTEM MODULE-----------
Route::any('/leave_approval_system', 'HrisApprovalSysController@index')->name('leave_approval_system')->middleware('auth.admin');
Route::post('/create_hris_approval', 'HrisApprovalSysController@create')->name('create_hris_approval');
Route::post('/edit_hris_approval_form', 'HrisApprovalSysController@editForm')->name('edit_hris_approval_form');
Route::post('/edit_hris_approval', 'HrisApprovalSysController@edit')->name('edit_hris_approval');
Route::post('/delete_hris_approval', 'HrisApprovalSysController@destroy')->name('delete_hris_approval');

// -------------LEAVE TYPE MODULE-----------
Route::any('/leave_type', 'LeaveTypeController@index')->name('leave_type')->middleware('auth');
Route::post('/create_leave_type', 'LeaveTypeController@create')->name('create_leave_type');
Route::post('/edit_leave_type_form', 'LeaveTypeController@editForm')->name('edit_leave_type_form');
Route::post('/edit_leave_type', 'LeaveTypeController@edit')->name('edit_leave_type');
Route::post('/delete_leave_type', 'LeaveTypeController@destroy')->name('delete_leave_type');

// -------------LEAVE REQUEST MODULE-----------
Route::any('/leave_log', 'LeaveLogController@index')->name('leave_log')->middleware('auth');
Route::any('/leave_history', 'LeaveLogController@leaveHistory')->name('leave_history')->middleware('auth');
Route::any('/my_leave_requests', 'LeaveLogController@myRequests')->name('my_leave_request')->middleware('auth');
Route::any('/my_leave_status', 'LeaveLogController@myLeaveStatus')->name('my_leave_status')->middleware('auth');
Route::post('/create_leave', 'LeaveLogController@create')->name('create_leave');
Route::post('/approve_leave', 'LeaveLogController@approval')->name('approve_leave');
Route::post('/edit_leave_form', 'LeaveLogController@editForm')->name('edit_leave_form');
Route::post('/edit_user_leave_form', 'LeaveLogController@editUserLeaveForm')->name('edit_user_leave_form');
Route::post('/edit_leave_attachment_form', 'LeaveLogController@attachmentForm')->name('edit_leave_attachment_form');
Route::post('/edit_leave', 'LeaveLogController@edit')->name('edit_leave');
Route::post('/edit_user_leave', 'LeaveLogController@editUserLeave')->name('edit_user_leave');
Route::post('/edit_leave_attachment', 'LeaveLogController@editAttachment')->name('edit_leave_attachment');
Route::post('/remove_leave_attachment', 'LeaveLogController@removeAttachment')->name('remove_leave_attachment');
Route::any('/download_leave_attachment', 'LeaveLogController@downloadAttachment')->name('download_leave_attachment');
Route::post('/delete_leave', 'LeaveLogController@destroy')->name('delete_leave');

// -------------LOAN INTEREST RATE MODULE-----------
Route::any('/loan_interest_rate', 'LoanRatesController@index')->name('loan_interest_rate')->middleware('auth.admin');
Route::post('/create_loan_rate', 'LoanRatesController@create')->name('create_loan_rate');
Route::post('/edit_loan_rate_form', 'LoanRatesController@editForm')->name('edit_loan_rate_form');
Route::post('/edit_loan_rate', 'LoanRatesController@edit')->name('edit_loan_rate');
Route::post('/loan_status', 'LoanRatesController@changeLoanStatus')->name('loan_status');
Route::post('/delete_loan_rate', 'LoanRatesController@destroy')->name('delete_loan_rate');

// -------------PAYROLL MODULE-----------
Route::any('/payroll', 'PayrollController@index')->name('payroll')->middleware('auth');
Route::any('/payroll_report', 'PayrollController@payrollReport')->name('payroll_report')->middleware('auth');
Route::any('/process_payroll', 'PayrollController@process')->name('process_payroll');
Route::any('/update_payroll', 'PayrollController@updateSalaryProcess')->name('update_payroll');
Route::get('/payslip', 'PayrollController@payslip')->name('payslip')->middleware('auth');
Route::any('/payslip_item', 'PayrollController@payslipItem')->name('payslip_item');
Route::post('/approve_payroll', 'PayrollController@approve')->name('approve_payroll');
Route::any('/search_payroll_user', 'PayrollController@searchUser')->name('search_payroll_user');
Route::any('/search_payroll_user_strict', 'PayrollController@searchUserStrict')->name('search_payroll_user_strict');
Route::any('/search_payroll_lite', 'PayrollController@searchPayrollLite')->name('search_payroll_lite');
Route::any('/search_payroll', 'PayrollController@searchPayroll')->name('search_payroll')->middleware('auth');
Route::post('/delete_payroll', 'PayrollController@destroy')->name('delete_payroll');

// -------------EXTERNAL PAYROLL MODULE-----------
Route::any('/external_payroll', 'ExternalPayrollController@index')->name('external_payroll')->middleware('auth');
Route::any('/external_payroll_report', 'ExternalPayrollController@payrollReport')->name('external_payroll_report')->middleware('auth');
Route::any('/process_external_payroll', 'ExternalPayrollController@process')->name('process_external_payroll');
Route::any('/update_external_payroll', 'ExternalPayrollController@updateSalaryProcess')->name('update_external_payroll');
Route::get('/external_payslip', 'ExternalPayrollController@payslip')->name('external_payslip')->middleware('auth');
Route::any('/external_payslip_item', 'ExternalPayrollController@payslipItem')->name('external_payslip_item');
Route::post('/approve_external_payroll', 'ExternalPayrollController@approve')->name('approve_external_payroll');
Route::any('/search_external_payroll_user', 'ExternalPayrollController@searchUser')->name('search_external_payroll_user');
Route::any('/search_external_payroll_user_strict', 'ExternalPayrollController@searchUserStrict')->name('search_external_payroll_user_strict');
Route::any('/search_external_payroll_lite', 'ExternalPayrollController@searchPayrollLite')->name('search_external_payroll_lite');
Route::any('/search_external_payroll', 'ExternalPayrollController@searchPayroll')->name('search_external_payroll')->middleware('auth');
Route::post('/delete_external_payroll', 'ExternalPayrollController@destroy')->name('delete_external_payroll');

// -------------INDIVIDUAL DEVELOPMENT PLAN MODULE-----------
Route::any('/idp', 'IdpController@index')->name('idp')->middleware('auth');
Route::post('/create_idp', 'IdpController@create')->name('create_idp');
Route::post('/edit_idp_form', 'IdpController@editForm')->name('edit_idp_form');
Route::post('/edit_idp', 'IdpController@edit')->name('edit_idp');
Route::post('/search_idp', 'IdpController@searchIndiGoal')->name('search_idp');
Route::post('/delete_idp', 'IdpController@destroy')->name('delete_idp');
Route::post('/status_idp', 'IdpController@statusChange')->name('status_idp');

// -------------Training Schedule MODULE-----------
Route::any('/training', 'TrainingController@index')->name('training')->middleware('auth');
Route::post('/create_training', 'TrainingController@create')->name('create_training');
Route::post('/edit_training_form', 'TrainingController@editForm')->name('edit_training_form');
Route::post('/edit_training', 'TrainingController@edit')->name('edit_training');
Route::post('/delete_training', 'TrainingController@destroy')->name('delete_training');


// -------------BIN TYPE MODULE-----------
Route::any('/bin_type', 'BinTypeController@index')->name('bin_type')->middleware('auth');
Route::post('/create_bin_type', 'BinTypeController@create')->name('create_bin_type');
Route::post('/edit_bin_type_form', 'BinTypeController@editForm')->name('edit_bin_type_form');
Route::post('/edit_bin_type', 'BinTypeController@edit')->name('edit_bin_type');
Route::post('/delete_bin_type', 'BinTypeController@destroy')->name('delete_bin_type');

// -------------BIN MODULE-----------
Route::any('/bin', 'BinController@index')->name('bin')->middleware('auth');
Route::post('/create_bin', 'BinController@create')->name('create_bin');
Route::post('/edit_bin_form', 'BinController@editForm')->name('edit_bin_form');
Route::post('/edit_bin', 'BinController@edit')->name('edit_bin');
Route::post('/delete_bin', 'BinController@destroy')->name('delete_bin');

// -------------ZONE MODULE-----------
Route::any('/zone', 'ZoneController@index')->name('zone')->middleware('auth');
Route::post('/create_zone', 'ZoneController@create')->name('create_zone');
Route::post('/edit_zone_form', 'ZoneController@editForm')->name('edit_zone_form');
Route::post('/edit_zone', 'ZoneController@edit')->name('edit_zone');
Route::post('/delete_zone', 'ZoneController@destroy')->name('delete_zone');

// -------------WAREHOUSE MODULE-----------
Route::any('/warehouse', 'WarehouseController@index')->name('warehouse')->middleware('auth');
Route::post('/create_warehouse', 'WarehouseController@create')->name('create_warehouse');
Route::post('/edit_warehouse_form', 'WarehouseController@editForm')->name('edit_warehouse_form');
Route::post('/edit_warehouse', 'WarehouseController@edit')->name('edit_warehouse');
Route::post('/delete_warehouse', 'WarehouseController@destroy')->name('delete_warehouse');

// -------------WAREHOUSE BIN MODULE-----------
Route::any('/warehouse_bin', 'ZoneBinController@Index')->name('warehouse')->middleware('auth');
Route::post('/create_warehouse_bin', 'ZoneBinController@Create')->name('create_warehouse');
Route::post('/add_warehouse_bin_form', 'ZoneBinController@addForm')->name('add_warehouse_bin_form');
Route::post('/delete_warehouse_bin', 'ZoneBinController@Destroy')->name('delete_warehouse_bin');

// -------------WAREHOUSE ZONE MODULE-----------
Route::any('/warehouse_zone', 'WarehouseZoneController@Index')->name('warehouse')->middleware('auth');
Route::post('/create_warehouse_zone', 'WarehouseZoneController@Create')->name('create_warehouse');
Route::post('/add_warehouse_zone_form', 'WarehouseZoneController@addForm')->name('add_warehouse_zone_form');
Route::post('/delete_warehouse_zone', 'WarehouseZoneController@Destroy')->name('delete_warehouse_zone');

// -------------PUT-AWAY TEMPLATE MODULE-----------
Route::any('/put_away_template', 'PutAwayTemplateController@index')->name('bin_type')->middleware('auth');
Route::post('/create_put_away_template', 'PutAwayTemplateController@create')->name('create_put_away_template');
Route::post('/edit_put_away_template_form', 'PutAwayTemplateController@editForm')->name('edit_put_away_template_form');
Route::post('/edit_put_away_template', 'PutAwayTemplateController@edit')->name('edit_put_away_template');
Route::post('/delete_put_away_template', 'PutAwayTemplateController@destroy')->name('delete_put_away_template');

// -------------PHYSICAL INVENTORY COUNT MODULE-----------
Route::any('/physical_inv_count', 'PhysicalInvCountController@index')->name('physical_inv_count')->middleware('auth');
Route::post('/create_physical_inv_count', 'PhysicalInvCountController@create')->name('create_physical_inv_count');
Route::post('/edit_physical_inv_count_form', 'PhysicalInvCountController@editForm')->name('edit_physical_inv_count_form');
Route::post('/edit_physical_inv_count', 'PhysicalInvCountController@edit')->name('edit_physical_inv_count');
Route::post('/delete_physical_inv_count', 'PhysicalInvCountController@destroy')->name('delete_physical_inv_count');

// -------------Unit of Measure-----------
Route::any('/unit_measure', 'UnitMeasureController@index')->name('unit_measure')->middleware('auth');
Route::post('/create_unit_measure', 'UnitMeasureController@create')->name('create_unit_measure');
Route::post('/edit_unit_measure_form', 'UnitMeasureController@editForm')->name('edit_unit_measure_form');
Route::post('/edit_unit_measure', 'UnitMeasureController@edit')->name('edit_unit_measure');
Route::post('/delete_unit_measure', 'UnitMeasureController@destroy')->name('delete_unit_measure');

// -------------VENDOR/CUSTOMER MODULE-----------
Route::any('/vendor', 'VendorCustomerController@indexVendor')->name('vendor_customer')->middleware('auth');
Route::any('/customer', 'VendorCustomerController@indexCustomer')->name('vendor_customer')->middleware('auth');
Route::post('/create_vendor_customer', 'VendorCustomerController@create')->name('create_vendor_customer');
Route::post('/edit_vendor_customer_form', 'VendorCustomerController@editForm')->name('edit_vendor_customer_form');
Route::post('/edit_vendor_customer', 'VendorCustomerController@edit')->name('edit_vendor_customer');
Route::any('/search_vendor', 'VendorCustomerController@searchVendor')->name('vendor_search');
Route::any('/search_customer', 'VendorCustomerController@searchCustomer')->name('customer_search');
Route::post('/delete_vendor_customer', 'VendorCustomerController@destroy')->name('delete_vendor_customer');
Route::post('/change_vendor_customer_status', 'VendorCustomerController@changeStatus')->name('change_vendor_customer_status');

// -------------INVENTORY CATEGORY MODULE-----------
Route::any('/inventory_category', 'InventoryCategoryController@index')->name('inventory_category')->middleware('auth');
Route::post('/create_inventory_cat', 'InventoryCategoryController@create')->name('create_inventory_cat');
Route::post('/edit_inventory_cat_form', 'InventoryCategoryController@editForm')->name('edit_inventory_cat_form');
Route::post('/edit_inventory_cat', 'InventoryCategoryController@edit')->name('edit_inventory_cat');
Route::post('/delete_inventory_cat', 'InventoryCategoryController@destroy')->name('delete_inventory_cat');

// -------------INVENOTRY MODULE-----------
Route::any('/inventory', 'InventoryController@index')->name('inventory')->middleware('auth');
Route::any('/ext_amount', 'InventoryController@extendedAmount')->name('ext_amount');
Route::post('/edit_inventory_form', 'InventoryController@editForm')->name('edit_inventory_form');
Route::any('/warehouse_item_inventory', 'InventoryController@warehouseInventory')->name('warehouse_inventory');
Route::any('/stock_inventory', 'InventoryController@stockInventory')->name('stock_inventory');
Route::post('/create_inventory', 'InventoryController@create')->name('create_inventory');
Route::post('/edit_inventory', 'InventoryController@edit')->name('edit_inventory');
Route::any('/search_inventory', 'InventoryController@searchInventory')->name('search_inventory');
Route::post('/delete_inventory', 'InventoryController@destroy')->name('delete_inventory');
Route::any('/delete_bom_item', 'InventoryController@permDelete')->name('delete_bom_item');
Route::post('/change_inventory_status', 'InventoryController@changeStatus')->name('change_inventory_status');

// -------------INVENTORY CONTRACT MODULE-----------
Route::any('/inventory_contract', 'InventoryContractController@index')->name('inventory_contract')->middleware('auth');
Route::any('/inventory_contract_ext_amount', 'InventoryContractController@extendedAmount')->name('ext_amount');
Route::post('/edit_inventory_contract_form', 'InventoryContractController@editForm')->name('edit_inventory_contract_form');
Route::post('/create_inventory_contract', 'InventoryContractController@create')->name('create_inventory_contract');
Route::post('/edit_inventory_contract', 'InventoryContractController@edit')->name('edit_inventory_contract');
Route::any('/search_inventory_contract', 'InventoryContractController@searchInventory')->name('search_inventory_contract');
Route::post('/delete_inventory_contract', 'InventoryContractController@destroy')->name('delete_inventory_contract');
Route::any('/delete_inventory_contract_item', 'InventoryContractController@permDelete')->name('delete_inventory_contract_item');
Route::post('/edit_inventory_contract_attachment', 'InventoryContractController@editAttachment')->name('edit_inventory_contract_attachment');
Route::post('/remove_inventory_contract_attachment', 'InventoryContractController@removeAttachment')->name('remove_inventory_contract_attachment');
Route::any('/download_inventory_contract_attachment', 'InventoryContractController@downloadAttachment')->name('download_inventory_contract_attachment');
Route::post('/edit_inventory_contract_attachment_form', 'InventoryContractController@attachmentForm')->name('edit_inventory_contract_attachment_form');
Route::post('/change_inventory_contract_status', 'InventoryContractController@changeStatus')->name('change_inventory_contract_status');


// -------------INVENTORY CONTRACT TYPE MODULE-----------
Route::any('/inventory_contract_type', 'InventoryContractTypeController@index')->name('inventory_contract_type')->middleware('auth');
Route::post('/create_inventory_contract_type', 'InventoryContractTypeController@create')->name('create_inventory_contract_type');
Route::post('/edit_inventory_contract_type_form', 'InventoryContractTypeController@editForm')->name('edit_inventory_contract_type_form');
Route::post('/edit_inventory_contract_type', 'InventoryContractTypeController@edit')->name('edit_inventory_contract_type');
Route::post('/delete_inventory_contract_type', 'InventoryContractTypeController@destroy')->name('delete_inventory_contract_type');

// -------------INVENTORY CONTRACT STATUS MODULE-----------
Route::any('/inventory_contract_status', 'InventoryContractStatusController@index')->name('inventory_contract_status')->middleware('auth');
Route::post('/create_inventory_contract_status', 'InventoryContractStatusController@create')->name('create_inventory_contract_status');
Route::post('/edit_inventory_contract_status_form', 'InventoryContractStatusController@editForm')->name('edit_inventory_contract_status_form');
Route::post('/edit_inventory_contract_status', 'InventoryContractStatusController@edit')->name('edit_inventory_contract_status');
Route::post('/delete_inventory_contract_status', 'InventoryContractStatusController@destroy')->name('delete_inventory_contract_status');


// -------------INVENTORY ACCESS MODULE-----------
Route::any('/inventory_access', 'InventoryAccessController@index')->name('inventory_access')->middleware('auth.admin');
Route::post('/create_inventory_access', 'InventoryAccessController@create')->name('create_inventory_access');
Route::post('/edit_inventory_access_form', 'InventoryAccessController@editForm')->name('edit_inventory_access_form');
Route::post('/edit_inventory_access', 'InventoryAccessController@edit')->name('edit_inventory_access');
Route::post('/delete_inventory_access', 'InventoryAccessController@destroy')->name('delete_inventory_access');

// -------------INVENTORY ASSIGN MODULE-----------
Route::any('/inventory_assign', 'InventoryAssignController@index')->name('inventory_assign')->middleware('auth');
Route::post('/create_inv_assign', 'InventoryAssignController@create')->name('create_inv_assign');
Route::post('/edit_inv_assign_form', 'InventoryAssignController@editForm')->name('edit_inv_assign_form');
Route::post('/edit_inv_assign', 'InventoryAssignController@edit')->name('edit_inv_assign');
Route::post('/delete_inv_assign', 'InventoryAssignController@destroy')->name('delete_inv_assign');

// -------------INVENTORY RECORD MODULE-----------
Route::any('/inventory_record', 'InventoryRecordController@index')->name('inventory_record')->middleware('auth');
Route::post('/create_inv_record', 'InventoryRecordController@create')->name('create_inv_record');
Route::post('/edit_inv_record_form', 'InventoryRecordController@editForm')->name('edit_inv_record_form');
Route::post('/edit_inv_record', 'InventoryRecordController@edit')->name('edit_inv_record');
Route::any('/search_inventory_record', 'InventoryRecordController@searchInventoryRecord')->name('search_inventory_record');
Route::post('/delete_inv_record', 'InventoryRecordController@destroy')->name('delete_inv_record');


// -------------FINANCIAL YEAR MODULE-----------
Route::any('/financial_year', 'FinancialYearController@index')->name('financial_year')->middleware('auth');
Route::post('/create_financial_year', 'FinancialYearController@create')->name('create_financial_year');
Route::post('/edit_financial_year_form', 'FinancialYearController@editForm')->name('edit_financial_year_form');
Route::post('/edit_financial_year', 'FinancialYearController@edit')->name('edit_financial_year');
Route::post('/financial_year_status', 'FinancialYearController@finYearStatus')->name('financial_year_status');
Route::post('/delete_financial_year', 'FinancialYearController@destroy')->name('delete_financial_year');

// -------------CLOSING BOOK MODULE-----------
Route::any('/closing_books', 'ClosingBooksController@index')->name('closing_books')->middleware('auth');
Route::post('/create_closing_books', 'ClosingBooksController@create')->name('create_closing_books');
Route::post('/edit_closing_books_form', 'ClosingBooksController@editForm')->name('edit_closing_books_form');
Route::post('/edit_closing_books', 'ClosingBooksController@edit')->name('edit_closing_books');
Route::post('/closing_books_status', 'ClosingBooksController@finYearStatus')->name('closing_books_status');
Route::post('/delete_closing_books', 'ClosingBooksController@destroy')->name('delete_closing_books');

// -------------TRANS LOCATION MODULE-----------
Route::any('/trans_location', 'TransLocationController@index')->name('trans_location')->middleware('auth');
Route::post('/create_trans_location', 'TransLocationController@create')->name('create_trans_location');
Route::post('/edit_trans_location_form', 'TransLocationController@editForm')->name('edit_trans_location_form');
Route::post('/edit_trans_location', 'TransLocationController@edit')->name('edit_trans_location');
Route::post('/delete_trans_location', 'TransLocationController@destroy')->name('delete_trans_location');

// -------------TRANS CLASS MODULE-----------
Route::any('/trans_class', 'TransClassController@index')->name('trans_class')->middleware('auth');
Route::post('/create_trans_class', 'TransClassController@create')->name('create_trans_class');
Route::post('/edit_trans_class_form', 'TransClassController@editForm')->name('edit_trans_class_form');
Route::post('/edit_trans_class', 'TransClassController@edit')->name('edit_trans_class');
Route::post('/delete_trans_class', 'TransClassController@destroy')->name('delete_trans_class');

// -------------CHART OF ACCOUNTS MODULE-----------
Route::any('/account_chart', 'AccountChartController@index')->name('account_chart')->middleware('auth');
Route::any('/account_register/{id}', 'AccountChartController@accountRegister')->name('account_register')->middleware('auth');
Route::post('/create_account_chart', 'AccountChartController@create')->name('create_account_chart');
Route::post('/edit_account_chart_form', 'AccountChartController@editForm')->name('edit_account_chart_form');
Route::post('/edit_account_chart', 'AccountChartController@edit')->name('edit_account_chart');
Route::any('/search_account_chart', 'AccountChartController@searchAccount')->name('search_account_chart');
Route::post('/delete_account_chart', 'AccountChartController@destroy')->name('delete_account_chart');
Route::post('/change_account_chart_status', 'AccountChartController@changeStatus')->name('change_account_chart_status');

// -------------PURCHASE ORDER MODULE-----------
Route::any('/purchase_order', 'PurchaseOrderController@index')->name('purchase_order')->middleware('auth');
Route::post('/edit_po_form', 'PurchaseOrderController@editForm')->name('edit_po_form');
Route::post('/create_po', 'PurchaseOrderController@create')->name('create_po');
Route::post('/post_create_receipt', 'PurchaseOrderController@postCreateReceipt')->name('post_create_receipt');
Route::post('/edit_po', 'PurchaseOrderController@edit')->name('edit_po');
Route::post('/po_print_preview', 'PurchaseOrderController@printPreview')->name('po_print_preview');
Route::post('/convert_quote_form', 'PurchaseOrderController@convertQuoteForm')->name('convert_quote_form');
Route::post('/convert_rfq_form', 'PurchaseOrderController@convertRfqForm')->name('convert_rfq_form');
Route::post('/convert_rfq', 'PurchaseOrderController@convertRfq')->name('convert_rfq');
Route::post('/convert_quote', 'PurchaseOrderController@convertQuote')->name('convert_quote');
Route::any('/search_po', 'PurchaseOrderController@searchPo')->name('search_po');
Route::post('/delete_po', 'PurchaseOrderController@destroy')->name('delete_po');
Route::any('/delete_po_item', 'PurchaseOrderController@permDelete')->name('delete_po_item');
Route::any('/delete_po_item_convert', 'PurchaseOrderController@permDeleteConvert')->name('delete_po_item_convert');
Route::post('/change_po_status', 'PurchaseOrderController@changeStatus')->name('change_po_status');
Route::any('/po_remove_attachment', 'PurchaseOrderController@removeAttachment')->name('po_remove_attachment');
Route::any('/po_download_attachment', 'PurchaseOrderController@downloadAttachment')->name('po_download_attachment');

// -------------WAREHOUSE EMPLOYEE MODULE-----------
Route::any('/warehouse_employee', 'WarehouseEmployeeController@index')->name('warehouse_employee')->middleware('auth');
Route::post('/create_warehouse_employee', 'WarehouseEmployeeController@create')->name('create_warehouse_employee');
Route::post('/edit_warehouse_employee_form', 'WarehouseEmployeeController@editForm')->name('edit_warehouse_employee_form');
Route::post('/edit_warehouse_employee', 'WarehouseEmployeeController@edit')->name('edit_warehouse_employee');
Route::post('/delete_warehouse_employee', 'WarehouseEmployeeController@destroy')->name('delete_warehouse_employee');

// -------------WAREHOUSE RECEIPT  MODULE-----------
Route::any('/warehouse_receipt', 'WarehouseReceiptController@index')->name('warehouse_receipt')->middleware('auth');
Route::any('/post_warehouse_receipt', 'WarehouseReceiptController@postCreateReceipt')->name('post_warehouse_receipt');
Route::any('/post_receipt', 'WarehouseReceiptController@postReceipt')->name('post_receipt');
Route::post('/edit_warehouse_receipt_form', 'WarehouseReceiptController@editForm')->name('edit_warehouse_receipt_form');
Route::post('/edit_warehouse_receipt', 'WarehouseReceiptController@edit')->name('edit_warehouse_receipt');
Route::any('/search_warehouse_receipt', 'WarehouseReceiptController@searchWarehouseReceipt')->name('search_warehouse_receipt');
Route::post('/delete_warehouse_receipt', 'WarehouseReceiptController@destroy')->name('delete_warehouse_receipt');

// -------------WAREHOUSE PUT AWAY  MODULE-----------
Route::any('/put_away', 'WhsePutAwayController@index')->name('put_away')->middleware('auth');
Route::any('/register_put_away', 'WhsePutAwayController@Pick')->name('post_put_away');
Route::post('/edit_put_away_form', 'WhsePutAwayController@editForm')->name('edit_put_away_form');
Route::post('/edit_put_away', 'WhsePutAwayController@edit')->name('edit_put_away');
Route::any('/search_put_away', 'WhsePutAwayController@searchWhsePutAway')->name('search_put_away');
Route::post('/delete_put_away', 'WhsePutAwayController@destroy')->name('delete_put_away');

// -------------REQUEST FOR QUOTE (RFQ) MODULE-----------
Route::any('/rfq', 'RFQController@index')->name('rfq')->middleware('auth');
Route::post('/edit_rfq_form', 'RFQController@editForm')->name('edit_rfq_form');
Route::post('/rfq_print_preview', 'RFQController@printPreview')->name('rfq_print_preview');
Route::post('/create_rfq', 'RFQController@create')->name('create_rfq');
Route::post('/edit_rfq', 'RFQController@edit')->name('edit_rfq');
Route::any('/search_rfq', 'RFQController@searchRfq')->name('search_rfq');
Route::post('/delete_rfq', 'RFQController@destroy')->name('delete_rfq');
Route::any('/delete_rfq_item', 'RFQController@permDelete')->name('delete_rfq_item');
Route::post('/change_rfq_status', 'RFQController@changeStatus')->name('change_rfq_status');
Route::any('/rfq_remove_attachment', 'RFQController@removeAttachment')->name('rfq_remove_attachment');
Route::any('/rfq_download_attachment', 'RFQController@downloadAttachment')->name('rfq_download_attachment');

// -------------QUOTE MODULE-----------
Route::any('/quote', 'QuoteController@index')->name('quote')->middleware('auth');
Route::post('/edit_quote_form', 'QuoteController@editForm')->name('edit_quote_form');
Route::post('/quote_print_preview', 'QuoteController@printPreview')->name('quote_print_preview');
Route::post('/create_quote', 'QuoteController@create')->name('create_quote');
Route::post('/edit_quote', 'QuoteController@edit')->name('edit_quote');
Route::any('/search_quote', 'QuoteController@searchQuote')->name('search_quote');
Route::post('/delete_quote', 'QuoteController@destroy')->name('delete_quote');
Route::any('/delete_quote_item', 'QuoteController@permDelete')->name('delete_quote_item');
Route::post('/change_quote_status', 'QuoteController@changeStatus')->name('change_quote_status');
Route::any('/quote_remove_attachment', 'QuoteController@removeAttachment')->name('quote_remove_attachment');
Route::any('/quote_download_attachment', 'QuoteController@downloadAttachment')->name('quote_download_attachment');

// -------------TEMP USER MODULE-----------
Route::any('/temp_user', 'TempUsersController@index')->name('user')->middleware('auth');
Route::any('/external/signup', 'TempUsersController@externalSignup')->name('external_signup');
Route::any('/external/candidate', 'TempUsersController@externalCandidate')->name('external_candidate');
Route::any('/client/survey/signup', 'TempUsersController@clientSignup')->name('client_signup');
Route::post('/create_temp_user', 'TempUsersController@create')->name('create_temp_user');
Route::post('/external_sign_up', 'TempUsersController@createExternalSignup')->name('create_external_signup');
Route::post('/edit_temp_user_form', 'TempUsersController@editForm')->name('edit_temp_user_form');
Route::post('/edit_temp_user', 'TempUsersController@edit')->name('edit_temp_user');
Route::get('/temp_user_profile/{uid}', 'TempUsersController@userProfile')->name('temp_profile')->middleware('auth');
Route::any('/search_temp_user', 'TempUsersController@searchUser')->name('temp_user_search');
Route::post('/delete_temp_user', 'TempUsersController@destroy')->name('delete_temp_user');
Route::post('/change_temp_user_status', 'TempUsersController@changeStatus')->name('change_temp_user_status');
Route::any('/temp_user_cv', 'TempUserController@downloadAttachment')->name('temp_user_cv');

// -------------SURVEY ANSWER CATEGORY MODULE FOR Survey-----------
Route::any('/survey_ans_category', 'SurveyAnsCatController@index')->name('survey_ans_category')->middleware('auth');
Route::post('/create_survey_ans_category', 'SurveyAnsCatController@create')->name('create_survey_ans_category');
Route::post('/edit_survey_ans_category_form', 'SurveyAnsCatController@editForm')->name('edit_survey_ans_category_form');
Route::post('/edit_survey_ans_category', 'SurveyAnsCatController@edit')->name('edit_survey_ans_category');
Route::post('/delete_survey_ans_category', 'SurveyAnsCatController@destroy')->name('delete_survey_ans_category');

// -------------SURVEY QUESTION CATEGORY MODULE FOR SURVEY-----------
Route::any('/survey_quest_category', 'SurveyQuestCatController@index')->name('survey_quest_category')->middleware('auth');
Route::post('/create_survey_quest_category', 'SurveyQuestCatController@create')->name('create_survey_quest_category');
Route::post('/edit_survey_quest_category_form', 'SurveyQuestCatController@editForm')->name('edit_survey_quest_category_form');
Route::post('/edit_survey_quest_category', 'SurveyQuestCatController@edit')->name('edit_survey_quest_category');
Route::post('/delete_survey_quest_category', 'SurveyQuestCatController@destroy')->name('delete_survey_quest_category');

// -------------SURVEY ACCESS MODULE-----------
Route::any('/survey_access', 'SurveyAccessController@index')->name('survey_access')->middleware('auth.admin');
Route::post('/create_survey_access', 'SurveyAccessController@create')->name('create_survey_access');
Route::post('/edit_survey_access_form', 'SurveyAccessController@editForm')->name('edit_survey_access_form');
Route::post('/edit_survey_access', 'SurveyAccessController@edit')->name('edit_survey_access');
Route::post('/delete_survey_access', 'SurveyAccessController@destroy')->name('delete_survey_access');

// -------------SURVEY MODULE-----------
Route::any('/survey', 'SurveyController@index')->name('survey')->middleware('auth');
Route::post('/create_survey', 'SurveyController@create')->name('create_survey');
Route::post('/edit_survey_form', 'SurveyController@editForm')->name('edit_survey_form');
Route::post('/edit_survey_dept_form', 'SurveyController@editDeptForm')->name('edit_survey_dept_form');
Route::post('/edit_survey', 'SurveyController@edit')->name('edit_survey');
Route::post('/modify_survey_dept', 'SurveyController@modifyDept')->name('modify_survey_dept');
Route::post('/delete_survey', 'SurveyController@destroy')->name('delete_survey');

// -------------SURVEY QUESTIONS MODULE-----------
Route::any('/survey_question', 'SurveyQuestController@index')->name('survey_question')->middleware('auth');
Route::post('/create_survey_question', 'SurveyQuestController@create')->name('create_survey_question');
Route::post('/edit_survey_question', 'SurveyQuestController@edit')->name('edit_survey');
Route::post('/search_survey_question', 'SurveyQuestController@searchSurvey')->name('search_survey_question');
Route::post('/delete_survey_question', 'SurveyQuestController@destroy')->name('delete_survey_question');


// -------------SURVEY SESSION MODULE-----------
Route::any('/survey_session', 'SurveySessionController@index')->name('survey_session')->middleware('auth');
Route::any('/survey_list', 'SurveySessionController@surveyList')->name('survey_list')->middleware('auth');
Route::any('/survey_list_temp', 'SurveySessionController@surveyListTemp')->name('survey_list_temp')->middleware('auth:temp_user');
Route::any('/survey_form/{id}/{session}', 'SurveySessionController@surveyForm')->name('survey_form')->middleware('auth');
Route::any('/survey_form/{id}/{session}/temp', 'SurveySessionController@surveyFormTemp')->name('survey_form_temp')->middleware('auth:temp_user');
Route::post('/submit_survey_form', 'SurveySessionController@submitSurveyForm')->name('submit_survey_form');
Route::post('/create_survey_session', 'SurveySessionController@create')->name('create_survey_session');
Route::post('/edit_survey_session_form', 'SurveySessionController@editForm')->name('edit_survey_session_form');
Route::post('/edit_survey_session', 'SurveySessionController@edit')->name('edit_survey_session');
Route::post('/delete_survey_session', 'SurveySessionController@destroy')->name('delete_survey_session');

// -------------SURVEY RESULT MODULE-----------
Route::any('/survey_result', 'SurveyResultController@index')->name('survey_result')->middleware('auth');
Route::any('/search_survey_result', 'SurveyResultController@searchSurvey')->name('search_survey_result');
Route::any('/survey_statements', 'SurveyResultController@surveyStatements')->name('survey_statements');
Route::any('/survey_participants', 'SurveyResultController@surveyParticipants')->name('survey_participants');

// -------------USER PIN CODE MODULE-----------
Route::any('/user_pin_code', 'UserPinCodeController@index')->name('user_pin_code')->middleware('auth');
Route::post('/create_user_pin_code', 'UserPinCodeController@create')->name('create_user_pin_code');
Route::post('/delete_user_pin_code', 'UserPinCodeController@destroy')->name('delete_user_pin_code');

// -------------TEST CATEGORY MODULE-----------
Route::any('/test_category', 'TestCategoryController@index')->name('department')->middleware('auth.admin');
Route::post('/create_test_cat', 'TestCategoryController@create')->name('create_test_cat');
Route::post('/edit_test_cat_form', 'TestCategoryController@editForm')->name('edit_test_cat');
Route::post('/edit_test_cat', 'TestCategoryController@edit')->name('edit_test_cat');
Route::post('/delete_test_cat', 'TestCategoryController@destroy')->name('delete_test_cat');

// -------------TEST MODULE-----------
Route::any('/test', 'TestController@index')->name('survey')->middleware('auth');
Route::post('/create_test', 'TestController@create')->name('create_survey');
Route::post('/edit_test_form', 'TestController@editForm')->name('edit_survey_form');
Route::post('/edit_test_dept_form', 'TestController@editDeptForm')->name('edit_test_dept_form');
Route::post('/edit_test_category_form', 'TestController@editCatForm')->name('edit_test_category_form');
Route::post('/edit_test', 'TestController@edit')->name('edit_test');
Route::post('/modify_test_dept', 'TestController@modifyDept')->name('modify_test_dept');
Route::post('/modify_test_cat', 'TestController@modifyCat')->name('modify_test_cat');
Route::post('/delete_test', 'TestController@destroy')->name('delete_test');

// -------------TEST SESSION MODULE-----------
Route::any('/test_session', 'TestSessionController@index')->name('test_session')->middleware('auth');
Route::any('/test_list', 'TestSessionController@testList')->name('test_list')->middleware('auth');
Route::any('/test_list_temp', 'TestSessionController@testListTemp')->name('test_list_temp')->middleware('auth:temp_user');
Route::any('/test_form/{id}/{session}', 'TestSessionController@testForm')->name('test_form')->middleware('auth');
Route::any('/test_form/{id}/{session}/temp', 'TestSessionController@testFormTemp')->name('test_form_temp')->middleware('auth:temp_user');
Route::post('/submit_test_form', 'TestSessionController@submitTestForm')->name('submit_test_form');
Route::post('/create_test_session', 'TestSessionController@create')->name('create_test_session');
Route::post('/edit_test_session_form', 'TestSessionController@editForm')->name('edit_test_session_form');
Route::post('/edit_test_session', 'TestSessionController@edit')->name('edit_test_session');
Route::post('/delete_test_session', 'TestSessionController@destroy')->name('delete_test_session');

// -------------TEST QUESTIONS MODULE-----------
Route::any('/test_question', 'TestQuestController@index')->name('test_question')->middleware('auth');
Route::post('/create_test_question', 'TestQuestController@create')->name('create_test_question');
Route::post('/edit_test_question', 'TestQuestController@edit')->name('edit_test');
Route::post('/search_test_question', 'TestQuestController@searchTest')->name('search_test_question');
Route::post('/delete_test_question', 'TestQuestController@destroy')->name('delete_test_question');

// -------------TEST RESULT MODULE-----------
Route::any('/test_result', 'TestResultController@index')->name('test_result')->middleware('auth');
Route::any('/search_test_result', 'TestResultController@searchTest')->name('search_test_result');
Route::any('/test_explanation', 'TestResultController@testExplanation')->name('test_explanation');

// -------------JOBS MODULE-----------
Route::any('/jobs', 'JobsController@index')->name('jobs')->middleware('auth');
Route::post('/create_jobs', 'jobsController@create')->name('create_jobs');
Route::post('/edit_jobs_form', 'jobsController@editForm')->name('edit_jobs_form');
Route::post('/edit_jobs', 'jobsController@edit')->name('edit_jobs');
Route::post('/delete_jobs', 'jobsController@destroy')->name('delete_jobs');
Route::post('/delete_applicants', 'jobsController@destroyApplicants')->name('delete_applicants');
Route::post('/apply_job', 'jobsController@applyJob')->name('apply_job');
Route::post('/change_jobs_status', 'JobsController@changeStatus')->name('change_jobs_status');
Route::any('/job_item/{id}/', 'JobsController@jobItem')->name('job_item')->middleware('auth');
Route::any('/download_cv_attachment', 'JobsController@downloadAttachment')->name('download_cv_attachment');
Route::any('/filter_job_applicants', 'JobsController@filterApplicants')->name('filter_job_applicants');
Route::any('/search_job_applicants', 'JobsController@searchApplicants')->name('search_job_applicants');
Route::any('/OByxRFDeOtxHYxnTTfJmSukkJZ7aCY/positions/2y101HS5A2C30Nex/available', 'JobsController@availablePositions')->name('available_positions');
Route::any('/OByxRFDeOtxHYxnTTfJmSukkJZ7aCY/positions/2y101HS5A2C30Nex/available/job/{id}/', 'JobsController@jobPosition')->name('job_position');

// -------------JOB CV POOL MODULE-----------
Route::any('/job_cv_pool', 'JobsController@jobCvPool')->name('job_cv_pool')->middleware('auth');
Route::post('/create_job_cv_pool', 'jobsController@createJobCvPool')->name('create_job_cv_pool');
Route::post('/edit_job_cv_pool_form', 'jobsController@EditFormjobCvPool')->name('edit_job_cv_pool_form');
Route::post('/edit_job_cv_pool', 'jobsController@editJobCvPool')->name('edit_job_cv_pool');

// -------------JOBS ACCESS MODULE-----------
Route::any('/jobs_access', 'JobsAccessController@index')->name('jobs_access')->middleware('auth.admin');
Route::post('/create_jobs_access', 'JobsAccessController@create')->name('create_jobs_access');
Route::post('/edit_jobs_access_form', 'JobsAccessController@editForm')->name('edit_jobs_access_form');
Route::post('/edit_jobs_access', 'JobsAccessController@edit')->name('edit_jobs_access');
Route::post('/delete_jobs_access', 'JobsAccessController@destroy')->name('delete_jobs_access');

// -------------BIRTHDAY MODULE-----------
Route::any('/birthday', 'UsersController@birthday')->name('birthday')->middleware('auth');
Route::any('/contract/staff/birthday', 'TempUsersController@birthday')->name('contract_birthday')->middleware('auth');

// -------------ADMIN APPROVAL SYSTEM MODULE-----------
Route::any('/admin_approval_system', 'AdminApprovalSysController@index')->name('admin_approval_system')->middleware('auth.admin');
Route::post('/create_admin_approval', 'AdminApprovalSysController@create')->name('create_admin_approval');
Route::post('/edit_admin_approval_form', 'AdminApprovalSysController@editForm')->name('edit_admin_approval_form');
Route::post('/edit_admin_approval', 'AdminApprovalSysController@edit')->name('edit_admin_approval');
Route::post('/delete_admin_approval', 'AdminApprovalSysController@destroy')->name('delete_admin_approval');

// -------------ADMIN DEPARTMENTAL APPROVAL MODULE-----------
Route::any('/admin_approval_dept', 'AdminApprovalDeptController@index')->name('admin_approval_dept')->middleware('auth.admin');
Route::post('/create_admin_approval_dept', 'AdminApprovalDeptController@create')->name('create_admin_approval_dept');
Route::post('/edit_admin_approval_dept_form', 'AdminApprovalDeptController@editForm')->name('edit_admin_approval_dept_form');
Route::post('/edit_admin_approval_dept', 'AdminApprovalDeptController@edit')->name('edit_admin_approval_dept');
Route::post('/delete_admin_approval_dept', 'AdminApprovalDeptController@destroy')->name('delete_admin_approval_dept');

// -------------ADMIN REQUEST CATEGORY MODULE FOR ADMIN REQUESTS-----------
Route::any('/admin_category', 'AdminCategoryController@index')->name('admin_category')->middleware('auth.admin');
Route::post('/create_admin_cat', 'AdminCategoryController@create')->name('create_admin_cat');
Route::post('/edit_admin_cat_form', 'AdminCategoryController@editForm')->name('edit_admin_cat_form');
Route::post('/edit_admin_cat', 'AdminCategoryController@edit')->name('edit_admin_cat');
Route::post('/delete_admin_cat', 'AdminCategoryController@destroy')->name('delete_admin_cat');

// -------------ADMIN REQUEST MODULE-----------
Route::any('/admin_requisition', 'AdminRequestController@index')->name('admin_requisition')->middleware('auth');
Route::any('/my_admin_requests', 'AdminRequestController@myRequests')->name('my_admin_request')->middleware('auth');
Route::any('/approved_admin_requests', 'AdminRequestController@approvedRequests')->name('approved_admin_requests')->middleware('auth');
Route::any('/chart_approved_admin_requests', 'AdminRequestController@chartApprovedRequests')->name('chart_approved_admin_requests')->middleware('auth');
Route::any('/table_admin_request_report', 'AdminRequestController@tableRequestReport')->name('table_admin_request_report')->middleware('auth');
Route::any('/print_admin_request', 'AdminRequestController@searchRequests')->name('print_admin_request')->middleware('auth');
Route::post('/admin_request_print_preview', 'AdminRequestController@printPreview')->name('admin_request_print_preview');
Route::post('/create_admin_requisition', 'AdminRequestController@create')->name('create_admin_requisition');
Route::post('/approve_admin_requisition', 'AdminRequestController@approval')->name('approve_admin_requisition');
Route::post('/edit_admin_requisition_form', 'AdminRequestController@editForm')->name('edit_admin_requisition_form');
Route::post('/edit_admin_attachment_form', 'AdminRequestController@attachmentForm')->name('edit_admin_attachment_form');
Route::post('/edit_admin_requisition', 'AdminRequestController@edit')->name('edit_admin_requisition');
Route::post('/edit_admin_attachment', 'AdminRequestController@editAttachment')->name('edit_admin_attachment');
Route::post('/remove_admin_attachment', 'AdminRequestController@removeAttachment')->name('remove_admin_attachment');
Route::any('/download_admin_attachment', 'AdminRequestController@downloadAttachment')->name('download_admin_attachment');
Route::any('/feedback_admin', 'AdminRequestController@createFeedback')->name('feedback_admin');
Route::post('/delete_admin_requisition', 'AdminRequestController@destroy')->name('delete_admin_requisition');

// -------------TICKET CATEGORY MODULE FOR HELP DESK-----------
Route::any('/ticket_category', 'TicketCategoryController@index')->name('ticket_category')->middleware('auth.admin');
Route::post('/create_ticket_cat', 'TicketCategoryController@create')->name('create_ticket_cat');
Route::post('/edit_ticket_cat_form', 'TicketCategoryController@editForm')->name('edit_ticket_cat_form');
Route::post('/edit_ticket_cat', 'TicketCategoryController@edit')->name('edit_ticket_cat');
Route::post('/delete_ticket_cat', 'TicketCategoryController@destroy')->name('delete_ticket_cat');

// ------------HELP DESK MODULE---------------
Route::any('/help_desk_ticket', 'HelpDeskController@index')->name('help_desk_ticket')->middleware('auth');
Route::any('/all_help_desk_ticket', 'HelpDeskController@allRequests')->name('all_help_desk_ticket')->middleware('auth');
Route::any('/help_desk_ticket_response_form', 'HelpDeskController@requestResponseForm')->name('help_desk_ticket_response_form');
Route::any('/help_desk_ticket_response', 'HelpDeskController@requestResponse')->name('help_desk_ticket_response');
Route::post('/create_help_desk_ticket', 'HelpDeskController@create')->name('create_help_desk_ticket');
Route::any('/feedback_ticket', 'HelpDeskController@createFeedback')->name('feedback_ticket');
Route::post('/edit_help_desk_ticket_form', 'HelpDeskController@editForm')->name('edit_help_desk_ticket_form');
Route::post('/edit_help_desk_ticket', 'HelpDeskController@edit')->name('edit_help_desk_ticket');
Route::post('/delete_help_desk_ticket', 'HelpDeskController@destroy')->name('delete_help_desk_ticket');
Route::any('/search_help_desk_ticket', 'HelpDeskController@searchReport')->name('search_help_desk_ticket');
Route::any('/help_desk_report', 'HelpDeskController@report')->name('help_desk_report')->middleware('auth');

// -------------NEWS MODULE-----------
Route::any('/news', 'NewsController@index')->name('news')->middleware('auth');
Route::post('/create_news', 'NewsController@create')->name('create_news');
Route::post('/edit_news_form', 'NewsController@editForm')->name('edit_news_form');
Route::post('/edit_news', 'NewsController@edit')->name('edit_news');
Route::post('/fetch_news', 'NewsController@fetchNews')->name('fetch_news');
Route::post('/delete_news', 'NewsController@destroy')->name('delete_news');

// -------------HSE SOURCE TYPE MODULE-----------
Route::any('/hse_source_type', 'HseSourceTypeController@index')->name('hse_source_type')->middleware('auth');
Route::post('/create_hse_source_type', 'HseSourceTypeController@create')->name('create_news');
Route::post('/edit_hse_source_type_form', 'HseSourceTypeController@editForm')->name('edit_hse_source_type_form');
Route::post('/edit_hse_source_type', 'HseSourceTypeController@edit')->name('edit_hse_source_type');
Route::post('/delete_hse_source_type', 'HseSourceTypeController@destroy')->name('delete_hse_source_type');

// ------------HSE REPORT MODULE---------------
Route::any('/hse_report', 'HseReportsController@index')->name('hse_report')->middleware('auth');
Route::any('/hse_report_response_form', 'HseReportsController@requestResponseForm')->name('hse_report_response_form');
Route::any('/hse_report_response', 'HseReportsController@requestResponse')->name('hse_report_response');
Route::post('/create_hse_report', 'HseReportsController@create')->name('create_hse_report');
Route::post('/edit_hse_report_form', 'HseReportsController@editForm')->name('edit_hse_report_form');
Route::post('/edit_hse_report', 'HseReportsController@edit')->name('edit_hse_report');
Route::post('/delete_hse_report', 'HseReportsController@destroy')->name('delete_hse_report');
Route::any('/search_hse_report', 'HseReportsController@searchReport')->name('search_hse_report');
Route::any('/hse_report_filter', 'HseReportsController@report')->name('hse_report_filter');
Route::post('/fetch_hse_report', 'HseReportsController@fetchHseReportItem')->name('fetch_hse_report');


// -------------HSE ACCESS MODULE-----------
Route::any('/hse_access', 'HseAccessController@index')->name('request_access')->middleware('auth.admin');
Route::post('/create_hse_access', 'HseAccessController@create')->name('create_hse_access');
Route::post('/edit_hse_access_form', 'HseAccessController@editForm')->name('edit_hse_access_form');
Route::post('/edit_hse_access', 'HseAccessController@edit')->name('edit_hse_access');
Route::post('/delete_hse_access', 'HseAccessController@destroy')->name('delete_hse_access');

// -------------DOCUMENT MODULE-----------
Route::any('/document', 'DocumentsController@index')->name('document')->middleware('auth');
Route::any('/document_archive', 'DocumentsController@documentArchive')->name('document_archive')->middleware('auth.admin');
Route::post('/create_document', 'DocumentsController@create')->name('create_document');
Route::post('/edit_document_form', 'DocumentsController@editForm')->name('edit_document_form');
Route::post('/edit_document_dept_form', 'DocumentsController@editDeptForm')->name('edit_document_dept_form');
Route::post('/edit_document', 'DocumentsController@edit')->name('edit_document');
Route::post('/edit_document_attachment_form', 'DocumentsController@attachmentForm')->name('edit_document_attachment_form');
Route::post('/edit_document_attachment', 'DocumentsController@editAttachment')->name('edit_document_attachment');
Route::post('/remove_document_attachment', 'DocumentsController@removeAttachment')->name('remove_document_attachment');
Route::any('/download_document_attachment', 'DocumentsController@downloadAttachment')->name('download_document_attachment');
Route::post('/modify_document_dept', 'DocumentsController@modifyDept')->name('modify_document_dept');
Route::post('/delete_document', 'DocumentsController@destroy')->name('delete_document');
Route::post('/delete_document_archive', 'DocumentsController@destroyArchive')->name('delete_document_archive');
Route::any('/search_document', 'DocumentsController@searchDocument')->name('search_document');
Route::any('/search_document_using_date', 'DocumentsController@searchDocumentUsingDate')->name('search_document_using_date');
Route::any('/remove_document_user', 'DocumentsController@removeAccessibleUser')->name('remove_document_user');
Route::any('/restore_document_archive', 'DocumentsController@restoreDocumentArchive')->name('restore_document_archive');

// -------------DOCUMENT CATEGORY MODULE-----------
Route::any('/document_category', 'DocumentCategoryController@index')->name('document_category')->middleware('auth');
Route::post('/create_document_cat', 'DocumentCategoryController@create')->name('create_document_cat');
Route::post('/edit_document_cat_form', 'DocumentCategoryController@editForm')->name('edit_document_cat_form');
Route::post('/edit_document_cat', 'DocumentCategoryController@edit')->name('edit_document_cat');
Route::post('/delete_document_cat', 'DocumentCategoryController@destroy')->name('delete_document_cat');

//--------------------- DOCUMENT COMMENTS   --------------------
Route::any('/document/{id}/', 'DocumentsController@viewComments')->name('discuss_comments')->middleware('auth');
Route::any('/comment_document', 'DocumentsController@comment')->name('comment_discuss');
Route::any('/fetch_fresh_document_comments', 'DocumentsController@freshComments')->name('fetch_fresh_comments');

// -------------EVENTS MODULE-----------
Route::any('/events', 'EventsController@index')->name('events')->middleware('auth');
Route::any('/my_events_calendar', 'EventsController@myCalendar')->name('my_events_calendar')->middleware('auth');
Route::any('/general_events_calendar', 'EventsController@generalCalendar')->name('general_events_calendar')->middleware('auth');
Route::post('/create_events', 'EventsController@create')->name('create_events');
Route::post('/edit_events_form', 'EventsController@editForm')->name('edit_events_form');
Route::post('/edit_events', 'EventsController@edit')->name('edit_events');
Route::post('/delete_events', 'EventsController@destroy')->name('delete_events');
Route::any('/change_calendar', 'EventsController@changeCalendar')->name('change_calendar')->middleware('auth');
Route::any('/load_my_calendar', 'EventsController@loadMyCalendar')->name('load_my_calendar');
Route::any('/load_general_calendar', 'EventsController@loadGeneralCalendar')->name('load_general_calendar');
Route::any('/load_dashboard_general_calendar', 'EventsController@loadDashboardGeneralCalendar')->name('load_dashboard_general_calendar');

// -------------CRM ACTIVITY TYPE MODULE-----------
Route::any('/crm_activity_type', 'CrmActivityTypeController@index')->name('crm_activity_type')->middleware('auth');
Route::post('/create_crm_activity_type', 'CrmActivityTypeController@create')->name('create_crm_activity_type');
Route::post('/edit_crm_activity_type_form', 'CrmActivityTypeController@editForm')->name('edit_crm_activity_type_form');
Route::post('/edit_crm_activity_type', 'CrmActivityTypeController@edit')->name('edit_crm_activity_type');
Route::post('/delete_crm_activity_type', 'CrmActivityTypeController@destroy')->name('delete_crm_activity_type');

// -------------CRM OPPORTUNITY STAGE MODULE-----------
Route::any('/crm_opportunity_stage', 'CrmStagesController@index')->name('crm_opportunity_stage')->middleware('auth');
Route::post('/create_crm_opportunity_stage', 'CrmStagesController@create')->name('create_crm_opportunity_stage');
Route::post('/edit_crm_opportunity_stage_form', 'CrmStagesController@editForm')->name('edit_crm_opportunity_stage_form');
Route::post('/edit_crm_opportunity_stage', 'CrmStagesController@edit')->name('edit_crm_opportunity_stage');
Route::post('/delete_crm_opportunity_stage', 'CrmStagesController@destroy')->name('delete_crm_opportunity_stage');

// -------------CRM SALES TEAM MODULE-----------
Route::any('/crm_sales_team', 'CrmSalesTeamController@index')->name('crm_sales_team')->middleware('auth');
Route::post('/create_crm_sales_team', 'CrmSalesTeamController@create')->name('create_crm_sales_team');
Route::post('/edit_crm_sales_team_form', 'CrmSalesTeamController@editForm')->name('edit_crm_sales_team_form');
Route::post('/edit_crm_sales_team', 'CrmSalesTeamController@edit')->name('edit_crm_sales_team');
Route::post('/delete_crm_sales_team', 'CrmSalesTeamController@destroy')->name('delete_crm_sales_team');
Route::any('/search_crm_sales_team', 'CrmSalesTeamController@searchData')->name('search_crm_sales_team');
Route::any('/remove_crm_sales_team_user', 'CrmSalesTeamController@removeUser')->name('remove_crm_sales_team_user');

// -------------CRM LEAD MODULE-----------
Route::any('/crm_lead', 'CrmLeadController@index')->name('crm_lead')->middleware('auth');
Route::post('/create_crm_lead', 'CrmLeadController@create')->name('create_crm_lead');
Route::post('/edit_crm_lead_form', 'CrmLeadController@editForm')->name('edit_crm_lead_form');
Route::post('/convert_crm_lead_form', 'CrmLeadController@convertForm')->name('convert_crm_lead_form');
Route::post('/edit_crm_lead', 'CrmLeadController@edit')->name('edit_crm_lead');
Route::any('/search_crm_lead', 'CrmLeadController@searchLead')->name('search_crm_lead');
Route::post('/delete_crm_lead', 'CrmLeadController@destroy')->name('delete_crm_lead');
Route::post('/change_crm_lead_status', 'CrmLeadController@changeStatus')->name('change_crm_lead_status');

// -------------CRM OPPORTUNITY MODULE-----------
Route::any('/crm_opportunity', 'CrmOpportunityController@index')->name('crm_opportunity')->middleware('auth');
Route::post('/create_crm_opportunity', 'CrmOpportunityController@create')->name('create_crm_opportunity');
Route::post('/edit_crm_opportunity_form', 'CrmOpportunityController@editForm')->name('edit_crm_opportunity_form');
Route::post('/edit_crm_opportunity', 'CrmOpportunityController@edit')->name('edit_crm_opportunity');
Route::any('/search_crm_opportunity', 'CrmOpportunityController@searchOpportunity')->name('search_crm_opportunity');
Route::post('/delete_crm_opportunity', 'CrmOpportunityController@destroy')->name('delete_crm_opportunity');
Route::any('/fetch_crm_possibility', 'CrmOpportunityController@fetchPossibility')->name('fetch_crm_possibility');
Route::any('/crm_opportunity/id/{id}/', 'CrmOpportunityController@opportunityItem')->name('crm_opportunity_item')->middleware('auth');
Route::post('/crm_opportunity_status', 'CrmOpportunityController@opportunityStatus')->name('opportunity_status');

// -------------CRM ACTIVITY STAGE MODULE-----------
Route::any('/crm_activity', 'CrmActivityController@index')->name('crm_activity')->middleware('auth');
Route::post('/create_crm_activity', 'CrmActivityController@create')->name('create_crm_activity');
Route::post('/edit_crm_activity_form', 'CrmActivityController@editForm')->name('edit_crm_activity_form');
Route::post('/edit_crm_activity', 'CrmActivityController@edit')->name('edit_crm_activity');
Route::post('/delete_crm_activity', 'CrmActivityController@destroy')->name('delete_crm_activity');
Route::any('/crm_activity_response_form', 'CrmActivityController@activityResponseForm')->name('crm_activity_response_form');
Route::any('/crm_activity_response', 'CrmActivityController@activityResponse')->name('crm_activity_response');


// -------------CRM NOTES STAGE MODULE-----------
Route::any('/crm_notes', 'CrmNotesController@index')->name('crm_notes')->middleware('auth');
Route::post('/create_crm_notes', 'CrmNotesController@create')->name('create_crm_notes');
Route::post('/edit_crm_notes_form', 'CrmNotesController@editForm')->name('edit_crm_notes_form');
Route::post('/edit_crm_notes', 'CrmNotesController@edit')->name('edit_crm_notes');
Route::post('/delete_crm_notes', 'CrmNotesController@destroy')->name('delete_crm_notes');

// -------------CRM SALES CYCLE MODULE-----------
Route::any('/crm_sales_cycle', 'CrmSalesCycleController@index')->name('crm_sales_cycle')->middleware('auth');
Route::post('/create_crm_sales_cycle', 'CrmSalesCycleController@create')->name('create_crm_sales_cycle');
Route::post('/edit_crm_sales_cycle_form', 'CrmSalesCycleController@editForm')->name('edit_crm_sales_cycle_form');
Route::post('/edit_crm_sales_cycle', 'CrmSalesCycleController@edit')->name('edit_crm_sales_cycle');
Route::post('/delete_crm_sales_cycle', 'CrmSalesCycleController@destroy')->name('delete_crm_sales_cycle');
Route::any('/search_crm_sales_cycle', 'CrmSalesCycleController@searchData')->name('search_crm_sales_cycle');
Route::any('/remove_crm_sales_cycle_stage', 'CrmSalesCycleController@removeStage')->name('remove_crm_sales_cycle_stage');

// -------------CRM REPORT MODULE-----------
Route::any('/crm_report', 'CrmReportController@index')->name('crm_report')->middleware('auth');
Route::post('/search_crm_report', 'CrmReportController@searchReport')->name('search_crm_report')->middleware('auth');

// -------------DISCUSS MODULE-----------
Route::any('/discuss', 'DiscussController@index')->name('discuss')->middleware('auth');
Route::any('/discuss_archive', 'DiscussController@discussArchive')->name('discuss_archive')->middleware('auth.admin');
Route::post('/create_discuss', 'DiscussController@create')->name('create_discuss');
Route::post('/edit_discuss_form', 'DiscussController@editForm')->name('edit_discuss_form');
Route::post('/edit_discuss_dept_form', 'DiscussController@editDeptForm')->name('edit_discuss_dept_form');
Route::post('/edit_discuss', 'DiscussController@edit')->name('edit_discuss');
Route::post('/edit_discuss_attachment_form', 'DiscussController@attachmentForm')->name('edit_discuss_attachment_form');
Route::post('/edit_discuss_attachment', 'DiscussController@editAttachment')->name('edit_discuss_attachment');
Route::post('/remove_discuss_attachment', 'DiscussController@removeAttachment')->name('remove_discuss_attachment');
Route::any('/download_discuss_attachment', 'DiscussController@downloadAttachment')->name('download_discuss_attachment');
Route::post('/modify_discuss_dept', 'DiscussController@modifyDept')->name('modify_discuss_dept');
Route::post('/delete_discuss', 'DiscussController@destroy')->name('delete_discuss');
Route::post('/delete_discuss_archive', 'DiscussController@destroyArchive')->name('delete_discuss_archive');
Route::any('/search_discuss', 'DiscussController@searchDiscuss')->name('search_discuss');
Route::any('/search_discuss_using_date', 'DiscussController@searchDiscussUsingDate')->name('search_discuss_using_date');
Route::any('/remove_discuss_user', 'DiscussController@removeAccessibleUser')->name('remove_discuss_user');
Route::any('/restore_discuss_archive', 'DiscussController@restoreDiscussArchive')->name('restore_discuss_archive');

Route::any('/discuss/{id}/', 'DiscussController@viewComments')->name('discuss_comments')->middleware('auth');
Route::any('/comment_discuss', 'DiscussController@comment')->name('comment_discuss');
Route::any('/fetch_fresh_comments', 'DiscussController@freshComments')->name('fetch_fresh_comments');

// -------------QUICK NOTE MODULE-----------
Route::any('/quick_note', 'QuickNoteController@index')->name('quick_note')->middleware('auth');
Route::post('/create_quick_note', 'QuickNoteController@create')->name('create_quick_note');
Route::post('/edit_quick_note_form', 'QuickNoteController@editForm')->name('edit_quick_note_form');
Route::post('/edit_quick_note', 'QuickNoteController@edit')->name('edit_quick_note');
Route::post('/delete_quick_note', 'QuickNoteController@destroy')->name('delete_quick_note');

// -------------VEHICLE CATEGORY MODULE-----------
Route::any('/vehicle_category', 'VehicleCategoryController@index')->name('vehicle_category')->middleware('auth');
Route::post('/create_vehicle_cat', 'VehicleCategoryController@create')->name('create_vehicle_cat');
Route::post('/edit_vehicle_cat_form', 'VehicleCategoryController@editForm')->name('edit_vehicle_cat_form');
Route::post('/edit_vehicle_cat', 'VehicleCategoryController@edit')->name('edit_vehicle_cat');
Route::post('/delete_vehicle_cat', 'VehicleCategoryController@destroy')->name('delete_vehicle_cat');


// -------------VEHICLE CONTRACT TYPE MODULE-----------
Route::any('/vehicle_contract_type', 'VehicleContractTypeController@index')->name('vehicle_contract_type')->middleware('auth');
Route::post('/create_vehicle_contract_type', 'VehicleContractTypeController@create')->name('create_vehicle_contract_type');
Route::post('/edit_vehicle_contract_type_form', 'VehicleContractTypeController@editForm')->name('edit_vehicle_contract_type_form');
Route::post('/edit_vehicle_contract_type', 'VehicleContractTypeController@edit')->name('edit_vehicle_contract_type');
Route::post('/delete_vehicle_contract_type', 'VehicleContractTypeController@destroy')->name('delete_vehicle_contract_type');

// -------------VEHICLE MAKE MODULE-----------
Route::any('/vehicle_make', 'VehicleMakeController@index')->name('vehicle_make')->middleware('auth');
Route::post('/create_vehicle_make', 'VehicleMakeController@create')->name('create_vehicle_make');
Route::post('/edit_vehicle_make_form', 'VehicleMakeController@editForm')->name('edit_vehicle_make_form');
Route::post('/edit_vehicle_make', 'VehicleMakeController@edit')->name('edit_vehicle_make');
Route::post('/delete_vehicle_make', 'VehicleMakeController@destroy')->name('delete_vehicle_make');

// -------------VEHICLE MODEL MODULE-----------
Route::any('/vehicle_model', 'VehicleModelController@index')->name('vehicle_model')->middleware('auth');
Route::post('/create_vehicle_model', 'VehicleModelController@create')->name('create_vehicle_model');
Route::post('/edit_vehicle_model_form', 'VehicleModelController@editForm')->name('edit_vehicle_model_form');
Route::post('/edit_vehicle_model', 'VehicleModelController@edit')->name('edit_vehicle_model');
Route::post('/delete_vehicle_model', 'VehicleModelController@destroy')->name('delete_vehicle_model');

// -------------VEHICLE FUEL STATION MODULE-----------
Route::any('/vehicle_fuel_station', 'VehicleFuelStationController@index')->name('vehicle_fuel_station')->middleware('auth');
Route::post('/create_vehicle_fuel_station', 'VehicleFuelStationController@create')->name('create_vehicle_fuel_station');
Route::post('/edit_vehicle_fuel_station_form', 'VehicleFuelStationController@editForm')->name('edit_vehicle_fuel_station_form');
Route::post('/edit_vehicle_fuel_station', 'VehicleFuelStationController@edit')->name('edit_vehicle_fuel_station');
Route::post('/delete_vehicle_fuel_station', 'VehicleFuelStationController@destroy')->name('delete_vehicle_fuel_station');

// -------------VEHICLE SERVICE TYPE MODULE-----------
Route::any('/vehicle_service_type', 'VehicleServiceTypeController@index')->name('vehicle_service_type')->middleware('auth');
Route::post('/create_vehicle_service_type', 'VehicleServiceTypeController@create')->name('create_vehicle_service_type');
Route::post('/edit_vehicle_service_type_form', 'VehicleServiceTypeController@editForm')->name('edit_vehicle_service_type_form');
Route::post('/edit_vehicle_service_type', 'VehicleServiceTypeController@edit')->name('edit_vehicle_service_type');
Route::post('/delete_vehicle_service_type', 'VehicleServiceTypeController@destroy')->name('delete_vehicle_service_type');

// -------------VEHICLE WORKSHOP MODULE-----------
Route::any('/vehicle_workshop', 'VehicleWorkshopController@index')->name('vehicle_workshop')->middleware('auth');
Route::post('/create_vehicle_workshop', 'VehicleWorkshopController@create')->name('create_vehicle_workshop');
Route::post('/edit_vehicle_workshop_form', 'VehicleWorkshopController@editForm')->name('edit_vehicle_workshop_form');
Route::post('/edit_vehicle_workshop', 'VehicleWorkshopController@edit')->name('edit_vehicle_workshop');
Route::post('/delete_vehicle_workshop', 'VehicleWorkshopController@destroy')->name('delete_vehicle_workshop');

// -------------VEHICLE ODOMETER MEASURE MODULE-----------
Route::any('/vehicle_odometer_measure', 'VehicleOdometerMeasureController@index')->name('vehicle_odometer_measure')->middleware('auth');
Route::post('/create_vehicle_odometer_measure', 'VehicleOdometerMeasureController@create')->name('create_vehicle_odometer_measure');
Route::post('/edit_vehicle_odometer_measure_form', 'VehicleOdometerMeasureController@editForm')->name('edit_vehicle_odometer_measure_form');
Route::post('/edit_vehicle_odometer_measure', 'VehicleOdometerMeasureController@edit')->name('edit_vehicle_odometer_measure');
Route::post('/vehicle_odometer_measure_status', 'VehicleOdometerMeasureController@odometerMeasureStatus')->name('vehicle_odometer_measure_status');
Route::post('/delete_vehicle_odometer_measure', 'VehicleOdometerMeasureController@destroy')->name('delete_vehicle_odometer_measure');

// -------------VEHICLE STATUS MODULE-----------
Route::any('/vehicle_status', 'VehicleStatusController@index')->name('vehicle_status')->middleware('auth');
Route::post('/create_vehicle_status', 'VehicleStatusController@create')->name('create_vehicle_status');
Route::post('/edit_vehicle_status_form', 'VehicleStatusController@editForm')->name('edit_vehicle_status_form');
Route::post('/edit_vehicle_status', 'VehicleStatusController@edit')->name('edit_vehicle_status');
Route::post('/delete_vehicle_status', 'VehicleStatusController@destroy')->name('delete_vehicle_status');


// -------------VEHICLE MODULE-----------
Route::any('/vehicle', 'VehicleController@index')->name('vehicle')->middleware('auth');
Route::post('/create_vehicle', 'VehicleController@create')->name('create_vehicle');
Route::post('/edit_vehicle_form', 'VehicleController@editForm')->name('edit_vehicle_form');
Route::post('/edit_vehicle_attachment_form', 'VehicleController@attachmentForm')->name('edit_vehicle_attachment_form');
Route::post('/edit_vehicle', 'VehicleController@edit')->name('edit_vehicle');
Route::any('/search_vehicle', 'VehicleController@searchVehicle')->name('search_vehicle');
Route::post('/edit_vehicle_attachment', 'VehicleController@editAttachment')->name('edit_vehicle_attachment');
Route::post('/remove_vehicle_attachment', 'VehicleController@removeAttachment')->name('remove_vehicle_attachment');
Route::any('/download_vehicle_attachment', 'VehicleController@downloadAttachment')->name('download_vehicle_attachment');
Route::post('/delete_vehicle', 'VehicleController@destroy')->name('delete_vehicle');

// -------------VEHICLE FUEL LOG MODULE-----------
Route::any('/vehicle_fuel_log', 'VehicleFuelLogController@index')->name('vehicle_fuel_log')->middleware('auth');
Route::post('/create_vehicle_fuel_log', 'VehicleFuelLogController@create')->name('create_vehicle_fuel_log');
Route::post('/edit_vehicle_fuel_log_form', 'VehicleFuelLogController@editForm')->name('edit_vehicle_fuel_log_form');
Route::post('/edit_vehicle_fuel_log_attachment_form', 'VehicleFuelLogController@attachmentForm')->name('edit_vehicle_fuel_log_attachment_form');
Route::post('/edit_vehicle_fuel_log', 'VehicleFuelLogController@edit')->name('edit_vehicle_fuel_log');
Route::any('/search_vehicle_fuel_log', 'VehicleFuelLogController@searchVehicle')->name('search_vehicle_fuel_log');
Route::post('/edit_vehicle_fuel_log_attachment', 'VehicleFuelLogController@editAttachment')->name('edit_vehicle_fuel_log_attachment');
Route::post('/remove_vehicle_fuel_log_attachment', 'VehicleFuelLogController@removeAttachment')->name('remove_vehicle_fuel_log_attachment');
Route::any('/download_vehicle_fuel_log_attachment', 'VehicleFuelLogController@downloadAttachment')->name('download_vehicle_fuel_log_attachment');
Route::post('/delete_vehicle_fuel_log', 'VehicleFuelLogController@destroy')->name('delete_vehicle_fuel_log');

// -------------VEHICLE FUEL LOG REPORT MODULE-----------
Route::any('/vehicle_fuel_log_report', 'VehicleFuelLogReportController@index')->name('vehicle_fuel_log_report')->middleware('auth');
Route::post('/search_vehicle_fuel_log_report', 'VehicleFuelLogReportController@searchReport')->name('search_vehicle_fuel_log_report')->middleware('auth');


// -------------VEHICLE SERVICE LOG MODULE-----------
Route::any('/vehicle_service_log', 'VehicleServiceLogController@index')->name('vehicle_service_log')->middleware('auth');
Route::post('/create_vehicle_service_log', 'VehicleServiceLogController@create')->name('create_vehicle_service_log');
Route::post('/edit_vehicle_service_log_form', 'VehicleServiceLogController@editForm')->name('edit_vehicle_service_log_form');
Route::post('/edit_vehicle_service_log_attachment_form', 'VehicleServiceLogController@attachmentForm')->name('edit_vehicle_service_log_attachment_form');
Route::post('/edit_vehicle_service_log', 'VehicleServiceLogController@edit')->name('edit_vehicle_service_log');
Route::any('/search_vehicle_service_log', 'VehicleServiceLogController@searchVehicle')->name('search_vehicle_service_log');
Route::post('/edit_vehicle_service_log_attachment', 'VehicleServiceLogController@editAttachment')->name('edit_vehicle_service_log_attachment');
Route::post('/remove_vehicle_service_log_attachment', 'VehicleServiceLogController@removeAttachment')->name('remove_vehicle_service_log_attachment');
Route::any('/download_vehicle_service_log_attachment', 'VehicleServiceLogController@downloadAttachment')->name('download_vehicle_service_log_attachment');
Route::post('/delete_vehicle_service_log', 'VehicleServiceLogController@destroy')->name('delete_vehicle_service_log');

// -------------VEHICLE SERVICE LOG REPORT MODULE-----------
Route::any('/vehicle_service_log_report', 'VehicleServiceLogReportController@index')->name('vehicle_service_log_report')->middleware('auth');
Route::post('/search_vehicle_service_log_report', 'VehicleServiceLogReportController@searchReport')->name('search_vehicle_service_log_report')->middleware('auth');

// -------------VEHICLE CONTRACT MODULE-----------
Route::any('/vehicle_contract', 'VehicleContractController@index')->name('vehicle_contract')->middleware('auth');
Route::post('/create_vehicle_contract', 'VehicleContractController@create')->name('create_vehicle_contract');
Route::post('/edit_vehicle_contract_form', 'VehicleContractController@editForm')->name('edit_vehicle_contract_form');
Route::post('/edit_vehicle_contract_attachment_form', 'VehicleContractController@attachmentForm')->name('edit_vehicle_contract_attachment_form');
Route::post('/edit_vehicle_contract', 'VehicleContractController@edit')->name('edit_vehicle_contract');
Route::any('/search_vehicle_contract', 'VehicleContractController@searchVehicle')->name('search_vehicle_contract');
Route::post('/edit_vehicle_contract_attachment', 'VehicleContractController@editAttachment')->name('edit_vehicle_contract_attachment');
Route::post('/remove_vehicle_contract_attachment', 'VehicleContractController@removeAttachment')->name('remove_vehicle_contract_attachment');
Route::any('/download_vehicle_contract_attachment', 'VehicleContractController@downloadAttachment')->name('download_vehicle_contract_attachment');
Route::post('/delete_vehicle_contract', 'VehicleContractController@destroy')->name('delete_vehicle_contract');

// -------------VEHICLE ODOMETER LOG MODULE-----------
Route::any('/vehicle_odometer_log', 'VehicleOdometerLogController@index')->name('vehicle_odometer_log')->middleware('auth');
Route::post('/create_vehicle_odometer_log', 'VehicleOdometerLogController@create')->name('create_vehicle_odometer_log');
Route::post('/edit_vehicle_odometer_log_form', 'VehicleOdometerLogController@editForm')->name('edit_vehicle_odometer_log_form');
Route::post('/edit_vehicle_odometer_log_attachment_form', 'VehicleOdometerLogController@attachmentForm')->name('edit_vehicle_odometer_log_attachment_form');
Route::post('/edit_vehicle_odometer_log', 'VehicleOdometerLogController@edit')->name('edit_vehicle_odometer_log');
Route::any('/search_vehicle_odometer_log', 'VehicleOdometerLogController@searchVehicle')->name('search_vehicle_odometer_log');
Route::post('/edit_vehicle_odometer_log_attachment', 'VehicleOdometerLogController@editAttachment')->name('edit_vehicle_odometer_log_attachment');
Route::post('/remove_vehicle_odometer_log_attachment', 'VehicleOdometerLogController@removeAttachment')->name('remove_vehicle_odometer_log_attachment');
Route::any('/download_vehicle_odometer_log_attachment', 'VehicleOdometerLogController@downloadAttachment')->name('download_vehicle_odometer_log_attachment');
Route::post('/delete_vehicle_odometer_log', 'VehicleOdometerLogController@destroy')->name('delete_vehicle_odometer_log');

// -------------VEHICLE ODOMETER LOG REPORT MODULE-----------
Route::any('/vehicle_odometer_log_report', 'VehicleOdometerLogReportController@index')->name('vehicle_odometer_log_report')->middleware('auth');
Route::post('/search_vehicle_odometer_log_report', 'VehicleOdometerLogReportController@searchReport')->name('search_vehicle_odometer_log_report')->middleware('auth');

// -------------VEHICLE ACCESS MODULE-----------
Route::any('/vehicle_fleet_access', 'VehicleFleetAccessController@index')->name('vehicle_fleet_access')->middleware('auth.admin');
Route::post('/create_vehicle_fleet_access', 'VehicleFleetAccessController@create')->name('create_vehicle_fleet_access');
Route::post('/edit_vehicle_fleet_access_form', 'VehicleFleetAccessController@editForm')->name('edit_vehicle_fleet_access_form');
Route::post('/edit_vehicle_fleet_access', 'VehicleFleetAccessController@edit')->name('edit_vehicle_fleet_access');
Route::post('/delete_vehicle_fleet_access', 'VehicleFleetAccessController@destroy')->name('delete_vehicle_fleet_access');

// -------------VEHICLE MAINTENANCE REMINDER MODULE-----------
Route::any('/vehicle_maintenance_reminder', 'VehicleMaintenanceReminderController@index')->name('vehicle_maintenance_reminder')->middleware('auth');
Route::post('/create_vehicle_maintenance_reminder', 'VehicleMaintenanceReminderController@create')->name('create_vehicle_maintenance_reminder');
Route::post('/edit_vehicle_maintenance_reminder_form', 'VehicleMaintenanceReminderController@editForm')->name('edit_vehicle_maintenance_reminder_form');
Route::post('/edit_vehicle_maintenance_reminder', 'VehicleMaintenanceReminderController@edit')->name('edit_vehicle_maintenance_reminder');
Route::post('/delete_vehicle_maintenance_reminder', 'VehicleMaintenanceReminderController@destroy')->name('delete_vehicle_maintenance_reminder');
Route::any('/search_vehicle_maintenance_reminder', 'VehicleMaintenanceReminderController@searchData')->name('search_vehicle_maintenance_reminder');
Route::any('/remove_vehicle_maintenance_reminder_service', 'VehicleMaintenanceReminderController@removeService')->name('remove_vehicle_maintenance_reminder_service');

// -------------VEHICLE MAINTENANCE SCHEDULE MODULE-----------
Route::any('/vehicle_maintenance_schedule', 'VehicleMaintenanceScheduleController@index')->name('vehicle_maintenance_schedule')->middleware('auth');
Route::post('/create_vehicle_maintenance_schedule', 'VehicleMaintenanceScheduleController@create')->name('create_vehicle_maintenance_schedule');
Route::post('/edit_vehicle_maintenance_schedule_form', 'VehicleMaintenanceScheduleController@editForm')->name('edit_vehicle_maintenance_schedule_form');
Route::post('/edit_vehicle_maintenance_schedule', 'VehicleMaintenanceScheduleController@edit')->name('edit_vehicle_maintenance_schedule');
Route::post('/delete_vehicle_maintenance_schedule', 'VehicleMaintenanceScheduleController@destroy')->name('delete_vehicle_maintenance_schedule');
Route::any('/search_vehicle_maintenance_schedule', 'VehicleMaintenanceScheduleController@searchData')->name('search_vehicle_maintenance_schedule');

// -------------BUDGET SUMMARY MODULE-----------
Route::any('/budget_summary', 'BudgetSummaryController@index')->name('budget_summary')->middleware('auth');
Route::post('/create_budget_summary', 'BudgetSummaryController@create')->name('create_budget_summary');
Route::post('/edit_budget_summary_form', 'BudgetSummaryController@editForm')->name('edit_budget_summary_form');
Route::post('/edit_budget_summary_attachment_form', 'BudgetSummaryController@attachmentForm')->name('edit_budget_summary_attachment_form');
Route::post('/edit_budget_summary', 'BudgetSummaryController@edit')->name('edit_budget_summary');
Route::any('/search_budget_summary', 'BudgetSummaryController@searchVehicle')->name('search_budget_summary');
Route::post('/edit_budget_summary_attachment', 'BudgetSummaryController@editAttachment')->name('edit_budget_summary_attachment');
Route::post('/remove_budget_summary_attachment', 'BudgetSummaryController@removeAttachment')->name('remove_budget_summary_attachment');
Route::any('/download_budget_summary_attachment', 'BudgetSummaryController@downloadAttachment')->name('download_budget_summary_attachment');
Route::post('/delete_budget_summary', 'BudgetSummaryController@destroy')->name('delete_budget_summary');
Route::post('/change_budget_status', 'BudgetSummaryController@approveBudget')->name('change_budget_status');
Route::any('/budget_approval', 'BudgetSummaryController@budgetApprovalView')->name('budget_approval');


// -------------BUDGET MODULE-----------
Route::any('/budget_item/view/{id}', 'BudgetController@budgetViewRequestCategoryDimension')->name('budget_item_view')->middleware('auth');
Route::any('/budget_item/modify/{id}', 'BudgetController@budgetRequestCategoryDimension')->name('budget_item_modify')->middleware('auth');
Route::post('/create_modify_budget_item', 'BudgetController@createModify')->name('create_modify_budget_item');
Route::post('/create_modify_budget_account', 'BudgetController@createModifyAcct')->name('create_modify_budget_account');
Route::post('/delete_budget_item', 'BudgetController@destroy')->name('delete_budget_item');

Route::any('/budget_item/account_chart_dimension/view/{id}', 'BudgetController@budgetViewAccountChartDimension')->name('budget_item_view_account_chart')->middleware('auth');
Route::any('/budget_item/account_chart_dimension/modify/{id}', 'BudgetController@budgetAccountChartDimension')->name('budget_item_modify_account_chart')->middleware('auth');
Route::post('/create_modify_budget_item_account_chart', 'BudgetController@createModifyAccountChartDimension')->name('create_modify_budget_item_account_chart');
Route::post('/delete_budget_item_account_chart', 'BudgetController@destroyAccountChartDimension')->name('delete_budget_item_account_chart');


// -------------BUDGET REPORT MODULE-----------
Route::any('/budget_archive', 'BudgetReportController@budgetArchive')->name('budget_archive')->middleware('auth.admin');
Route::post('/search_budget_archive', 'BudgetReportController@searchBudgetArchive')->name('search_budget_archive');

Route::any('/budget_request_compare', 'BudgetReportController@budgetRequisitionReport')->name('budget_request_compare')->middleware('auth');
Route::post('/search_budget_request_compare', 'BudgetReportController@searchBudgetRequestCompare')->name('search_budget_request_compare');

Route::any('/budget_budget_compare', 'BudgetReportController@budgetBudgetReport')->name('budget_request_compare')->middleware('auth');
Route::post('/search_budget_budget_compare', 'BudgetReportController@searchBudgetBudgetCompare')->name('search_budget_budget_compare');

// -------------BUDGET REQUEST TRACKING MODULE-----------
Route::any('/budget_request_tracking', 'BudgetRequestTrackingController@index')->name('budget_request_tracking')->middleware('auth.admin');
Route::post('/budget_request_status', 'BudgetRequestTrackingController@changeBudgetStatus')->name('budget_request_status');

//  ------------------DASHBOARD REPORTING MODULE---------------------
Route::any('/load_dashboard_general_calendar', 'EventsController@loadDashboardGeneralCalendar')->name('load_dashboard_general_calendar');
Route::any('/dashboard_report', 'HomeController@dashboardReport')->name('dashboard_report');


// -------------WAREHOUSE INVENTORY MODULE-----------
Route::any('/warehouse_inventory', 'WarehouseInventoryController@index')->name('warehouse_inventory')->middleware('auth');
Route::post('/create_warehouse_inventory', 'WarehouseInventoryController@create')->name('create_warehouse_inventory');
Route::post('/remove_warehouse_inventory', 'WarehouseInventoryController@removeWarehouseInventory')->name('remove_warehouse_inventory');
Route::post('/warehouse_inventory_contents', 'WarehouseInventoryController@warehouseInventoryContents')->name('warehouse_inventory_contents');

Route::any('/warehouse_inventory_bin', 'WarehouseInventoryController@warehouseZoneBin')->name('warehouse_inventory_bin')->middleware('auth');
Route::post('/warehouse_inventory_bin_content', 'WarehouseInventoryController@binContents')->name('warehouse_inventory_bin_content');

Route::any('/warehouse_inventory_zone', 'WarehouseInventoryController@warehouseZone')->name('warehouse')->middleware('auth');

Route::post('/search_warehouse_inventory_items', 'WarehouseInventoryController@searchWarehouseInventoryItems')->name('search_warehouse_inventory_items');
Route::post('/search_warehouse_inventory', 'WarehouseInventoryController@searchWarehouseInventory')->name('search_warehouse_inventory');

// -------------SALES ORDER MODULE-----------
Route::any('/sales_order', 'SalesOrderController@index')->name('sales_order')->middleware('auth');
Route::post('/edit_sales_form', 'SalesOrderController@editForm')->name('edit_sales_form');
Route::post('/create_sales', 'SalesOrderController@create')->name('create_sales');
Route::post('/post_create_shipment', 'SalesOrderController@postCreateShipment')->name('post_create_shipment');
Route::post('/edit_sales', 'SalesOrderController@edit')->name('edit_sales');
Route::post('/sales_print_preview', 'SalesOrderController@printPreview')->name('sales_print_preview');
Route::post('/convert_quote_sales_form', 'SalesOrderController@convertQuoteForm')->name('convert_quote_sales_form');
Route::post('/convert_po_sales_form', 'SalesOrderController@convertPoForm')->name('convert_po_sales_form');
Route::post('/convert_po_sales', 'SalesOrderController@convertPo')->name('convert_po');
Route::post('/convert_quote_sales', 'SalesOrderController@convertQuote')->name('convert_quote_sales');
Route::any('/search_sales', 'SalesOrderController@searchSales')->name('search_sales');
Route::post('/delete_sales', 'SalesOrderController@destroy')->name('delete_sales');
Route::any('/delete_sales_item', 'SalesOrderController@permDelete')->name('delete_sales_item');
Route::any('/delete_sales_item_convert', 'SalesOrderController@permDeleteConvert')->name('delete_sales_item_convert');
Route::post('/change_sales_status', 'SalesOrderController@changeStatus')->name('change_sales_status');
Route::any('/sales_remove_attachment', 'SalesOrderController@removeAttachment')->name('sales_remove_attachment');
Route::any('/sales_download_attachment', 'SalesOrderController@downloadAttachment')->name('sales_download_attachment');

// -------------WAREHOUSE SHIPMENT  MODULE-----------
Route::any('/warehouse_shipment', 'WarehouseShipmentController@index')->name('warehouse_shipment')->middleware('auth');
Route::any('/post_warehouse_shipment', 'WarehouseShipmentController@postCreateShipment')->name('post_warehouse_shipment');
Route::any('/post_shipment', 'WarehouseShipmentController@postShipment')->name('post_shipment');
Route::post('/edit_warehouse_shipment_form', 'WarehouseShipmentController@editForm')->name('edit_warehouse_shipment_form');
Route::post('/edit_warehouse_shipment', 'WarehouseShipmentController@edit')->name('edit_warehouse_shipment');
Route::any('/search_warehouse_shipment', 'WarehouseShipmentController@searchWarehouseShipment')->name('search_warehouse_shipment');
Route::post('/delete_warehouse_shipment', 'WarehouseShipmentController@destroy')->name('delete_warehouse_shipment');

// -------------WAREHOUSE PICK  MODULE-----------
Route::any('/picks', 'WhsePickController@index')->name('picks')->middleware('auth');
Route::any('/register_picks', 'WhsePickController@Pick')->name('post_picks');
Route::post('/edit_picks_form', 'WhsePickController@editForm')->name('edit_picks_form');
Route::post('/edit_picks', 'WhsePickController@edit')->name('edit_picks');
Route::any('/search_picks', 'WhsePickController@searchWhsePick')->name('search_picks');
Route::post('/delete_picks', 'WhsePickController@destroy')->name('delete_picks');

// -------------JOURNAL DEFAULT TRANSACTION ACCOUNTS MODULE-----------
Route::any('/journal_default_transaction_account', 'JournalDefaultTransactionAccountController@index')->name('default_transaction_account')->middleware('auth.admin');
Route::post('/create_journal_default_transaction_account', 'JournalDefaultTransactionAccountController@create')->name('create_default_transaction_account');
Route::post('/edit_journal_default_transaction_account_form', 'JournalDefaultTransactionAccountController@editForm')->name('edit_default_transaction_account_form');
Route::post('/edit_journal_default_transaction_account', 'JournalDefaultTransactionAccountController@edit')->name('edit_default_transaction_account');
Route::post('/delete_journal_default_transaction_account', 'JournalDefaultTransactionAccountController@destroy')->name('delete_default_transaction_account');
Route::post('/change_journal_default_transaction_account_status', 'JournalDefaultTransactionAccountController@changeStatus')->name('change_default_transaction_account_status');

// -------------JOURNAL TRANSACTION TERMS MODULE-----------
Route::any('/transaction_terms', 'JournalTransactionTermsController@index')->name('transaction_terms')->middleware('auth');
Route::post('/create_transaction_terms', 'JournalTransactionTermsController@create')->name('create_transaction_terms');
Route::post('/edit_transaction_terms_form', 'JournalTransactionTermsController@editForm')->name('edit_transaction_terms_form');
Route::post('/edit_transaction_terms', 'JournalTransactionTermsController@edit')->name('edit_transaction_terms');
Route::post('/delete_transaction_terms', 'JournalTransactionTermsController@destroy')->name('delete_transaction_terms');


// -------------JOURNAL TRANSACTION FORMAT/METHOD MODULE-----------
Route::any('/transaction_method', 'JournalTransactionFormatController@index')->name('transaction_method')->middleware('auth');
Route::post('/create_transaction_method', 'JournalTransactionFormatController@create')->name('create_transaction_method');
Route::post('/edit_transaction_method_form', 'JournalTransactionFormatController@editForm')->name('edit_transaction_method_form');
Route::post('/edit_transaction_method', 'JournalTransactionFormatController@edit')->name('edit_transaction_method');
Route::post('/delete_transaction_method', 'JournalTransactionFormatController@destroy')->name('delete_transaction_method');

// -------------INVOICE MODULE-----------
Route::any('/invoice', 'InvoiceController@index')->name('invoice')->middleware('auth');
Route::post('/edit_invoice_form', 'InvoiceController@editForm')->name('edit_invoice_form');
Route::post('/convert_sales_invoice_form', 'InvoiceController@convertSalesForm')->name('convert_sales_invoice_form');
Route::post('/convert_po_invoice_form', 'InvoiceController@convertPoForm')->name('convert_po_invoice_form');
Route::post('/invoice_print_preview', 'InvoiceController@printPreview')->name('invoice_print_preview');
Route::post('/create_invoice', 'InvoiceController@create')->name('create_invoice');
Route::post('/edit_invoice', 'InvoiceController@edit')->name('edit_invoice');
Route::any('/search_invoice', 'InvoiceController@searchInvoice')->name('search_invoice');
Route::post('/delete_invoice', 'InvoiceController@destroy')->name('delete_invoice');
Route::any('/delete_invoice_item', 'InvoiceController@permDelete')->name('delete_invoice_item');
Route::any('/delete_invoice_item_convert', 'InvoiceController@permDeleteConvert')->name('delete_invoice_item_convert');
Route::any('/invoice_remove_attachment', 'InvoiceController@removeAttachment')->name('invoice_remove_attachment');
Route::any('/invoice_download_attachment', 'InvoiceController@downloadAttachment')->name('invoice_download_attachment');

// -------------JOURNAL ENTRY MODULE-----------
Route::any('/journal_entry', 'JournalEntryController@index')->name('invoice')->middleware('auth');
Route::post('/edit_journal_entry_form', 'JournalEntryController@editForm')->name('edit_journal_entry_form');
Route::post('/journal_entry_print_preview', 'JournalEntryController@printPreview')->name('journal_entry_print_preview');
Route::post('/create_journal_entry', 'JournalEntryController@create')->name('create_journal_entry');
Route::post('/edit_journal_entry', 'JournalEntryController@edit')->name('edit_journal_entry');
Route::any('/search_journal_entry', 'JournalEntryController@searchjournalEntry')->name('search_journal_entry');
Route::post('/delete_journal_entry', 'JournalEntryController@destroy')->name('delete_journal_entry');
Route::any('/invoice_remove_attachment', 'JournalEntryController@removeAttachment')->name('journal_entry_remove_attachment');
Route::any('/journal_entry_download_attachment', 'JournalEntryController@downloadAttachment')->name('journal_entry_download_attachment');

// ------------- PAYMENT RECEIPT MODULE-----------
Route::any('/payment_receipt', 'PaymentReceiptController@index')->name('payment_receipt')->middleware('auth');
Route::post('/edit_payment_receipt_form', 'PaymentReceiptController@editForm')->name('edit_payment_receipt_form');
Route::post('/create_payment_receipt', 'PaymentReceiptController@create')->name('create_payment_receipt');
Route::any('/search_payment_receipt', 'PaymentReceiptController@searchOpenInvoice')->name('search_open_invoice');
Route::post('/payment_receipt_remove_attachment', 'PaymentReceiptController@removeAttachment')->name('payment_receipt_remove_attachment');
Route::any('/central_download_attachment', 'GeneralController@downloadAttachment')->name('central_download_attachment');
Route::any('/invoice_payment_receipt', 'PaymentReceiptController@invoicePaymentReceipt')->name('invoice_payment_receipt')->middleware('auth');
Route::any('/search_invoice_payment_receipt', 'PaymentReceiptController@searchInvoicePaymentReceipt')->name('search_invoice_payment_receipt');
Route::post('/receipt_print_preview', 'PaymentReceiptController@printPreview')->name('receipt_print_preview');

// ------------- BILL PAYMENT MODULE-----------
Route::any('/bill_payment', 'BillPaymentController@index')->name('payment_receipt')->middleware('auth');
Route::post('/edit_bill_payment_form', 'BillPaymentController@editForm')->name('edit_bill_payment_form');
Route::post('/create_bill_payment', 'BillPaymentController@create')->name('create_bill_payment');
Route::any('/search_bill_payment', 'BillPaymentController@searchOpenBill')->name('search_open_bill');
Route::post('/bill_payment_remove_attachment', 'BillPaymentController@removeAttachment')->name('bill_payment_remove_attachment');
Route::any('/central_download_attachment', 'GenderalController@downloadAttachment')->name('central_download_attachment');
Route::any('/bill_payments', 'BillPaymentController@billPayments')->name('bill_payments')->middleware('auth');
Route::any('/search_bill_payments', 'BillPaymentController@searchBillPayments')->name('search_bill_payments');
Route::post('/payment_print_preview', 'BillPaymentController@printPreview')->name('payment_print_preview');

// -------------CASH PAYMENT RECEIPT MODULE-----------
Route::any('/cash_receipt', 'CashPaymentReceiptController@index')->name('cash_receipt')->middleware('auth');
Route::post('/edit_cash_receipt_form', 'CashPaymentReceiptController@editForm')->name('edit_cash_receipt_form');
Route::post('/convert_sales_cash_receipt_form', 'CashPaymentReceiptController@convertSalesForm')->name('convert_sales_cash_receipt_form');
Route::post('/convert_po_cash_receipt_form', 'CashPaymentReceiptController@convertPoForm')->name('convert_po_cash_receipt_form');
Route::post('/cash_receipt_print_preview', 'CashPaymentReceiptController@printPreview')->name('cash_receipt_print_preview');
Route::post('/create_cash_receipt', 'CashPaymentReceiptController@create')->name('create_cash_receipt');
Route::post('/edit_cash_receipt', 'CashPaymentReceiptController@edit')->name('edit_cash_receipt');
Route::any('/search_cash_receipt', 'CashPaymentReceiptController@searchCashReceipt')->name('search_cash_receipt');
Route::post('/delete_cash_receipt', 'CashPaymentReceiptController@destroy')->name('delete_cash_receipt');
Route::any('/delete_cash_receipt_item', 'CashPaymentReceiptController@permDelete')->name('delete_cash_receipt_item');
Route::any('/delete_cash_receipt_item_convert', 'CashPaymentReceiptController@permDeleteConvert')->name('delete_cash_receipt_item_convert');
Route::any('/cash_receipt_remove_attachment', 'CashPaymentReceiptController@removeAttachment')->name('cash_receipt_remove_attachment');
Route::any('/central_download_attachment', 'GeneralController@downloadAttachment')->name('cash_receipt_download_attachment');

// -------------CASH REFUND RECEIPT MODULE-----------
Route::any('/refund_receipt', 'CashRefundReceiptController@index')->name('refund_receipt')->middleware('auth');
Route::post('/edit_refund_receipt_form', 'CashRefundReceiptController@editForm')->name('edit_refund_receipt_form');
Route::post('/convert_sales_refund_receipt_form', 'CashRefundReceiptController@convertSalesForm')->name('convert_sales_refund_receipt_form');
Route::post('/convert_po_refund_receipt_form', 'CashRefundReceiptController@convertPoForm')->name('convert_po_refund_receipt_form');
Route::post('/refund_receipt_print_preview', 'CashRefundReceiptController@printPreview')->name('refund_receipt_print_preview');
Route::post('/create_refund_receipt', 'CashRefundReceiptController@create')->name('create_refund_receipt');
Route::post('/edit_refund_receipt', 'CashRefundReceiptController@edit')->name('edit_refund_receipt');
Route::any('/search_refund_receipt', 'CashRefundReceiptController@searchCashReceipt')->name('search_refund_receipt');
Route::post('/delete_refund_receipt', 'CashRefundReceiptController@destroy')->name('delete_refund_receipt');
Route::any('/delete_refund_receipt_item', 'CashRefundReceiptController@permDelete')->name('delete_refund_receipt_item');
Route::any('/delete_refund_receipt_item_convert', 'CashRefundReceiptController@permDeleteConvert')->name('delete_refund_receipt_item_convert');
Route::any('/refund_receipt_remove_attachment', 'CashRefundReceiptController@removeAttachment')->name('refund_receipt_remove_attachment');
Route::any('/central_download_attachment', 'GeneralController@downloadAttachment')->name('refund_receipt_download_attachment');

// -------------CREDIT MEMO MODULE-----------
Route::any('/credit_memo', 'CreditMemoController@index')->name('credit_memo')->middleware('auth');
Route::post('/edit_credit_memo_form', 'CreditMemoController@editForm')->name('edit_credit_memo_form');
Route::post('/convert_sales_credit_memo_form', 'CreditMemoController@convertSalesForm')->name('convert_sales_credit_memo_form');
Route::post('/convert_po_credit_memo_form', 'CreditMemoController@convertPoForm')->name('convert_po_credit_memo_form');
Route::post('/credit_memo_print_preview', 'CreditMemoController@printPreview')->name('credit_memo_print_preview');
Route::post('/create_credit_memo', 'CreditMemoController@create')->name('create_credit_memo');
Route::post('/edit_credit_memo', 'CreditMemoController@edit')->name('edit_credit_memo');
Route::any('/search_credit_memo', 'CreditMemoController@searchCreditMemo')->name('search_credit_memo');
Route::post('/delete_credit_memo', 'CreditMemoController@destroy')->name('delete_invoice');
Route::any('/delete_credit_memo_item', 'CreditMemoController@permDelete')->name('delete_credit_memo_item');
Route::any('/delete_credit_memo_item_convert', 'CreditMemoController@permDeleteConvert')->name('delete_credit_memo_item_convert');
Route::any('/credit_memo_remove_attachment', 'CreditMemoController@removeAttachment')->name('credit_memo_remove_attachment');
Route::any('/credit_memo_download_attachment', 'GeneralController@downloadAttachment')->name('credit_memo_download_attachment');

// -------------BILL MODULE-----------
Route::any('/bill', 'BillController@index')->name('bill')->middleware('auth');
Route::post('/edit_bill_form', 'BillController@editForm')->name('edit_bill_form');
Route::post('/convert_sales_bill_form', 'BillController@convertSalesForm')->name('convert_sales_bill_form');
Route::post('/convert_po_bill_form', 'BillController@convertPoForm')->name('convert_po_bill_form');
Route::post('/bill_print_preview', 'BillController@printPreview')->name('bill_print_preview');
Route::post('/create_bill', 'BillController@create')->name('create_bill');
Route::post('/edit_bill', 'BillController@edit')->name('edit_bill');
Route::any('/search_bill', 'BillController@searchBill')->name('search_bill');
Route::post('/delete_bill', 'BillController@destroy')->name('delete_bill');
Route::any('/delete_bill_item', 'BillController@permDelete')->name('delete_bill_item');
Route::any('/delete_bill_item_convert', 'BillController@permDeleteConvert')->name('delete_bill_item_convert');
Route::any('/bill_remove_attachment', 'BillController@removeAttachment')->name('bill_remove_attachment');
Route::any('/bill_download_attachment', 'GeneralController@downloadAttachment')->name('bill_download_attachment');

// -------------EXPENSE MODULE-----------
Route::any('/expense', 'ExpenseController@index')->name('expense')->middleware('auth');
Route::post('/edit_expense_form', 'ExpenseController@editForm')->name('edit_expense_form');
Route::post('/convert_sales_expense_form', 'ExpenseController@convertSalesForm')->name('convert_sales_expense_form');
Route::post('/convert_po_expense_form', 'ExpenseController@convertPoForm')->name('convert_po_expense_form');
Route::post('/expense_print_preview', 'ExpenseController@printPreview')->name('expense_print_preview');
Route::post('/create_expense', 'ExpenseController@create')->name('create_expense');
Route::post('/edit_expense', 'ExpenseController@edit')->name('edit_expense');
Route::any('/search_expense', 'ExpenseController@searchExpense')->name('search_expense');
Route::post('/delete_expense', 'ExpenseController@destroy')->name('delete_expense');
Route::any('/delete_expense_item', 'ExpenseController@permDelete')->name('delete_expense_item');
Route::any('/delete_expense_item_convert', 'ExpenseController@permDeleteConvert')->name('delete_expense_item_convert');
Route::any('/expense_remove_attachment', 'ExpenseController@removeAttachment')->name('expense_remove_attachment');
Route::any('/expense_download_attachment', 'GeneralController@downloadAttachment')->name('expense_download_attachment');

// -------------VENDOR CREDIT MODULE-----------
Route::any('/vendor_credit', 'VendorCreditController@index')->name('vendor_credit')->middleware('auth');
Route::post('/edit_vendor_credit_form', 'VendorCreditController@editForm')->name('edit_vendor_credit_form');
Route::post('/convert_sales_vendor_credit_form', 'VendorCreditController@convertSalesForm')->name('convert_sales_vendor_credit_form');
Route::post('/convert_po_vendor_credit_form', 'VendorCreditController@convertPoForm')->name('convert_po_vendor_credit_form');
Route::post('/vendor_credit_print_preview', 'VendorCreditController@printPreview')->name('vendor_credit_print_preview');
Route::post('/create_vendor_credit', 'VendorCreditController@create')->name('create_vendor_credit');
Route::post('/edit_vendor_credit', 'VendorCreditController@edit')->name('edit_vendor_credit');
Route::any('/search_vendor_credit', 'VendorCreditController@searchVendorCredit')->name('search_vendor_credit');
Route::post('/delete_vendor_credit', 'VendorCreditController@destroy')->name('delete_vendor_credit');
Route::any('/delete_vendor_credit_item', 'VendorCreditController@permDelete')->name('delete_vendor_credit_item');
Route::any('/delete_vendor_credit_item_convert', 'VendorCreditController@permDeleteConvert')->name('delete_vendor_credit_item_convert');
Route::any('/vendor_credit_remove_attachment', 'VendorCreditController@removeAttachment')->name('vendor_credit_remove_attachment');
Route::any('/vendor_credit_download_attachment', 'GeneralController@downloadAttachment')->name('vendor_credit_download_attachment');

// -------------ACCOUNTANCT REPORT MODULE-----------
Route::any('/balance_sheet', 'AccountantReportController@balanceSheet')->name('balance_sheet')->middleware('auth');
Route::post('/balance_sheet_report', 'AccountantReportController@balanceSheetReport')->name('balance_sheet_report');

Route::any('/trial_balance', 'AccountantReportController@trialBalance')->name('trial_balance')->middleware('auth');
Route::post('/trial_balance_report', 'AccountantReportController@trialBalanceReport')->name('trial_balance_report');

Route::any('/income_statement', 'AccountantReportController@incomeStatement')->name('income_statement')->middleware('auth');
Route::post('/income_statement_report', 'AccountantReportController@incomeStatementReport')->name('income_statement_report');

// -------------CUSTOMER REPORT MODULE-----------
Route::any('/customer_report', 'CustomerReportController@customerReport')->name('customer_report')->middleware('auth');
Route::post('/customer_inventory_report', 'CustomerReportController@inventoryReport')->name('customer_inventory_report');
Route::post('/customer_accounts_report', 'CustomerReportController@accountsReport')->name('customer_accounts_report')->middleware('auth');
Route::post('/customer_transaction_report', 'CustomerReportController@contactTransactionReport')->name('customer_transction_report');
Route::post('/open_invoice_report', 'CustomerReportController@openInvoiceReport')->name('open_invoice_report')->middleware('auth');
Route::post('/overdue_invoice_report', 'CustomerReportController@overdueInvoiceReport')->name('overdue_invoice_report');


// -------------VENDOR REPORT MODULE-----------
Route::any('/vendor_report', 'VendorReportController@vendorReport')->name('vendor_report')->middleware('auth');
Route::post('/vendor_inventory_report', 'VendorReportController@inventoryReport')->name('vendor_inventory_report');
Route::post('/vendor_accounts_report', 'VendorReportController@accountsReport')->name('vendor_accounts_report')->middleware('auth');
Route::post('/vendor_transaction_report', 'VendorReportController@contactTransactionReport')->name('vendor_transction_report');
Route::post('/open_bill_report', 'VendorReportController@openBillReport')->name('open_bill_report')->middleware('auth');
Route::post('/overdue_bill_report', 'VendorReportController@overdueBillReport')->name('overdue_bill_report');

// -------------BANK RECONCILIATION MODULE-----------
Route::any('/bank_reconciliation', 'BankReconciliationController@index')->name('bank_reconciliation')->middleware('auth');
Route::post('/bank_reconciliation_search', 'BankReconciliationController@search')->name('bank_reconciliation_search');

Route::any('/bank_reconciliation_report/{id}', 'BankReconciliationController@singleReport')->name('bank_reconciliation_report')->middleware('auth');
Route::post('/bank_reconciliation_reconcile', 'BankReconciliationController@reconcile')->name('bank_reconciliation_reconcile');
Route::post('/bank_reconciliation_create', 'BankReconciliationController@createReconciliation')->name('bank_reconciliation_create');


Route::any('/redo_bank_reconciliation/{id}', 'BankReconciliationController@redoBankReconciliation')->name('redo_bank_reconciliation')->middleware('auth');
Route::any('/fetch_begining_balance', 'BankReconciliationController@fetchBeginingBalance')->name('fetch_begining_balance');
Route::any('/delete_bank_reconciliation', 'BankReconciliationController@destroy')->name('delete_bank_reconciliation');






