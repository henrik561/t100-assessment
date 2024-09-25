<?php

use App\Services\CompensationReportService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $compensationReportService = new CompensationReportService();
    return $compensationReportService->generateReport();
});
