<?php


use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeKpiController;
use App\Http\Controllers\JoinTableController;
use App\Http\Controllers\KpisController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use \App\Http\Controllers\TeamsProjectsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('addemployee', [EmployeeController::class,'addEmployee']);
Route::get('employees', [EmployeeController::class,'index']);
Route::delete('delete-employee/{id}', [EmployeeController::class,'delete']);
Route::get('employee/{id}', [EmployeeController::class,'getEmployee']);
Route::put('update_employee/{id}', [EmployeeController::class,'updateEmployee']);
Route::put('updateOneEmployee/{id}', [EmployeeController::class,'updateOneEmployee']);
Route::get('search-employee/{key}', [EmployeeController::class,'search']);
Route::put('updaterole/{id}', [EmployeeController::class,'updateRole']);
Route::get('rating/overall/{id}', [EmployeeController::class,'ratingOverall']);
Route::put('removefromteam/{id}', [EmployeeController::class,'removeTeam']);
Route::get('/filter',[EmployeeController::class, 'employeesUnassigned']);

Route::get('teamsprojects', [TeamsProjectsController::class,'index']);
Route::post('teamsprojects', [TeamsProjectsController::class,'store']);


Route::get('roles', [RoleController::class,'index']);
Route::post('roles', [RoleController::class,'store']);
Route::delete('/delete-roles/{id}', [RoleController::class,'destroy']);
Route::put('roles-update/{id}', [RoleController::class,'updateRole']);
Route::get('roles/{id}', [RoleController::class,'getRole']);




Route::post('addteam', [TeamController::class,'addteam']);
Route::get('list-team', [TeamController::class,'index']);
Route::delete('delete-team/{id}', [TeamController::class,'delete']);
Route::get('team/{id}', [TeamController::class,'getTeam']);
Route::put('update_team/{id}', [TeamController::class,'updateTeam']);
Route::get('search-team/{key}', [TeamController::class,'search']);
Route::get('teamfilter/{id}', [TeamController::class,'teamsUnassigned']);



Route::post('addproject', [ProjectController::class,'addProject']);
Route::get('list-project', [ProjectController::class,'list']);
Route::delete('delete-project/{id}', [ProjectController::class,'delete']);
Route::get('project/{id}', [ProjectController::class,'getProject']);
Route::put('update_project/{id}', [ProjectController::class,'updateProject']);
Route::get('search-project/{key}', [ProjectController::class,'search']);


Route::post('/kpi', [KpisController::class,'store']);
Route::get('/kpi', [KpisController::class,'index']);
Route::get('kpi/{id}', [KpisController::class,'getLatestKpi']);

Route::post('/employeekpi',[EmployeeKpiController::class, 'store']);
Route::get('/employeekpi',[EmployeeKpiController::class, 'index']);
Route::get('/employeekpi/{id}',[EmployeeKpiController::class, 'latestRatings']);
Route::get('/lastfivekpi/{id}/{kpi_id}',[EmployeeKpiController::class, 'getLastFive']);
Route::get('/lasttenkpi/{id}/{kpi_id}',[EmployeeKpiController::class, 'getLastTen']);


Route::get('/join', [JoinTableController::class,'index']);

Route::post('/register', ['App\Http\Controllers\AuthController', 'register']);
        Route::get('/list', ['App\Http\Controllers\AuthController', 'list']);
        Route::get('admins/{id}', ['App\Http\Controllers\AuthController','getadmin']);
        Route::put('/update/{id}', ['App\Http\Controllers\AuthController', 'update']);
        Route::delete('/admins/{id}', ['App\Http\Controllers\AuthController','destroy']);
        Route::post('/login', ['App\Http\Controllers\AuthController', 'login']);
        Route::post('/logout', ['App\Http\Controllers\AuthController', 'logout']);
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('/tasks', ['TaskController', 'index']);
});

