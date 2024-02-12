<?php

use App\Http\Livewire\Pages\CheckIn;
use App\Http\Livewire\References\EmployeeList;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ReportTable\ReportList;
use App\Http\Livewire\CheckInTable\CheckInTableList;
use App\Http\Livewire\CheckInTable\ViewCheckInTableList;
use App\Http\Livewire\CheckInTable\ViewPrintList;
use App\Http\Livewire\AddPatient\AddPatientTable;
use App\Http\Livewire\AddOperationDone\AddOperationDonePage;
use App\Http\Livewire\ViewPatient\ViewPatientPage;
use App\Http\Livewire\PatientList\PatientListPage;
use App\Http\Livewire\Summary\SummaryPage;

use App\Http\Controllers\ExportPdf;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/doctors_transfers', CheckIn::class)->name('doctors_transfers');
    Route::get('/operations_incidents_events', ReportList::class)->name('operations_incidents_events');
    Route::get('/addpatient', AddPatientTable::class)->name('addpatient');
    Route::get('/shoreports', CheckInTableList::class)->name('shoreports');
    Route::get('/shoreports/view/{id}', ViewCheckInTableList::class)->name('viewshoreports');
    Route::get('/addoperationdone/{id}', AddOperationDonePage::class)->name('addOperationDone');
    Route::get('/viewopatientlist/{id}', ViewPatientPage::class)->name('viewPatient');
    Route::get('/patientlist', PatientListPage::class)->name('patientlist');
    Route::get('/summary', SummaryPage::class)->name('summary');
    Route::get('/view_print/{id}', ViewPrintList::class)->name('view_print');

    Route::get('/printtwo/{id}', [ExportPdf::class, 'printTwoPage'])->name('printtwo');

    Route::name('ref.')->prefix('/references')->group(function () {
        Route::get('/employee-list', EmployeeList::class)->name('emp');
    });
});
