<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CompanyController;

//use App\Http\Controllers\ContactController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\PersonController;
use App\Http\Livewire\Chat\CreateChat;
use App\Http\Livewire\Chat\Main;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
})->name('main');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(
    function () {
        Route::get('/history', function () {
            return view('crm/history');
        })->name('history');

        Route::resource('companies', CompanyController::class);
        //  Route::resource('interests', InterestController::class);//todo: njprwd do likwidacji
        Route::resource('persons', PersonController::class);
        //delete (checkbox) routes
        // Route::post('/delete-persons', [PersonController::class, 'deletePersons'])->middleware(['check.apprentice','check.editor']);
        //uwaga odjesty middelware przy delete person (checkbox) z pwowodu bledu usuwania
        Route::post('/delete-persons', [PersonController::class, 'deletePersons']);
        //Route::post('/delete-companies', [CompanyController::class, 'deleteCompanies'])->middleware(['check.apprentice','check.editor']);
        Route::post('/delete-companies', [CompanyController::class, 'deleteCompanies']);

        // Calendar routes
        //e.g. http://fullcalendar-js-in-laravel.test/calendar/index
        Route::get('calendar/index', [CalendarController::class, 'index'])->name('calendar.index');
        Route::get('calendar/tasks-table', [CalendarController::class, 'tasksTable'])->name('calendar.tasks-table');
        //Route::get('/{id}/edit-task', [CalendarController::class, 'edit'])->name('calendar.edit')->middleware(['check.apprentice']);
        Route::get('/{id}/edit-task', [CalendarController::class, 'edit'])->name('calendar.edit');
        Route::post('calendar/store', [CalendarController::class, 'store'])->name('calendar.store');
        // Route::put('calendar/update/{id}', [CalendarController::class, 'update'])->name('calendar.update')->middleware(['check.apprentice']);
        Route::put('calendar/update/{id}', [CalendarController::class, 'update'])->name('calendar.update');
        // Route::post('/delete-tasks', [CalendarController::class, 'destroy'])->middleware(['check.apprentice','check.editor']);
        Route::get('/delete-tasks', [CalendarController::class, 'destroy']);
        //Route::get('calendar/destroy/{id}', [CalendarController::class, 'delete'])->name('calendar.destroy')->middleware(['check.apprentice','check.editor']);
        Route::get('calendar/destroy/{id}', [CalendarController::class, 'delete'])->name('calendar.destroy');
        Route::get('calendar/task/{id}', [CalendarController::class, 'show'])->name('calendar.task');
        Route::get('tasks/print-pdf', [CalendarController::class, 'printPDF'])->name('tasks.print.pdf');

        //temporary route - only for testing purposes
        Route::get('pdf', [CalendarController::class, 'indexpdf'])->name('pdf');

        //temporary route - only for testing purposes
        //Route::get('datapicker', [CalendarController::class, 'indexDataPicker'])->name('datapicker');

        // Chart route
        Route::get('chart', [ChartController::class, 'index'])->name('chart.chart');

        //livewire chat routes
        //livewire routes
        //Route::get('/users', CreateChat::class)->name('users');
        //key jako parametr opcjonalny
        //Route::get('/chat{key?}', Main::class)->name('chat')->middleware(['check.apprentice']);
        Route::get('/chat{key?}', Main::class)->name('chat');
        //push test

    });
