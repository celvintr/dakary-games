<?php

use App\Http\Controllers\AssignedCardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Livewire\AssignedCards\Index as AssignedCardsIndex;
use App\Http\Livewire\AssignedCards\Form as AssignedCardsForm;
use App\Http\Livewire\AssignedCards\Close as AssignedCardsClose;
use App\Http\Livewire\AssignedCardDetails\Index as AssignedCardDetailsIndex;
use App\Http\Livewire\Cards\Index as CardsIndex;
use App\Http\Livewire\Cards\Form as CardsForm;
use App\Http\Livewire\Dealers\Index as DealersIndex;
use App\Http\Livewire\Dealers\Form as DealersForm;
use App\Http\Livewire\Users\Index as UsersIndex;
use App\Http\Livewire\Users\Form as UsersForm;
use Illuminate\Support\Facades\Artisan;
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

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('home');

Route::middleware(['auth'])->group(function () {
    #Asignar tarjetas
    Route::prefix('contratos')->name('assigned-cards.')->group(function () {
        Route::get('/', AssignedCardsIndex::class)->name('index');
        Route::get('/create', AssignedCardsForm::class)->name('create');
        Route::get('/{id}', AssignedCardsForm::class)->name('edit');
        Route::get('/{id}/detail', AssignedCardsClose::class)->name('detail');
        Route::get('/{id}/close', AssignedCardsClose::class)->name('close');
        Route::get('/{id}/pdf', [AssignedCardController::class, 'pdf'])->name('pdf');
        Route::get('/{id}/pdf/cierre', [AssignedCardController::class, 'pdf_closed'])->name('pdf-closed');
    });

    #activar tarjetas
    Route::prefix('activacion')->name('assigned-card-details.')->group(function () {
        Route::get('/', AssignedCardDetailsIndex::class)->name('index');
    });

    #Clientes
    Route::prefix('clientes')->name('dealers.')->group(function () {
        Route::get('/', DealersIndex::class)->name('index');
        Route::get('/create', DealersForm::class)->name('create');
        Route::get('/{id}', DealersForm::class)->name('edit');
    });

    #Tipos de tarjeta
    Route::prefix('productos')->name('cards.')->group(function () {
        Route::get('/', CardsIndex::class)->name('index');
        Route::get('/crear', CardsForm::class)->name('create');
        Route::get('/{id}', CardsForm::class)->name('edit');
    });

    #Usuarios
    Route::prefix('usuarios')->name('users.')->group(function () {
        Route::get('/', UsersIndex::class)->name('index');
        Route::get('/create', UsersForm::class)->name('create');
        Route::get('/{id}', UsersForm::class)->name('edit');
    });
});

Route::middleware(['auth'])->group(function () {
    #Reportes
    Route::prefix('reportes')->name('reports.')->group(function () {
        #Ventas
        Route::prefix('ventas')->name('sales.')->group(function () {
            #Por fecha
            Route::prefix('fechas')->name('dates.')->group(function () {
                Route::get('/', [ReportController::class, 'sales_dates'])->name('index');
                Route::post('/', [ReportController::class, 'sales_dates_export'])->name('export');
            });

            #Por fecha
            Route::prefix('clientes')->name('dealers.')->group(function () {
                Route::get('/', [ReportController::class, 'sales_dealers'])->name('index');
                Route::post('/', [ReportController::class, 'sales_dealers_export'])->name('export');
            });

            #Por producto
            Route::prefix('productos')->name('cards.')->group(function () {
                Route::get('/', [ReportController::class, 'sales_cards'])->name('index');
                Route::post('/', [ReportController::class, 'sales_cards_export'])->name('export');
            });
        });
    });
});

Route::get('storage-link', function() {
    Artisan::call('storage:link');
});

Route::get('migrate', function() {
    // Artisan::call('migrate:fresh --seed');
    Artisan::call('migrate');
});

Route::get('optimize', function() {
    Artisan::call('optimize:clear');
});

require __DIR__.'/auth.php';
