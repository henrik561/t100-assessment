<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompensationReportController;

Route::get('/', [CompensationReportController::class, 'generateReport']);
