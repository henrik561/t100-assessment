<?php

namespace App\Http\Controllers;

use App\Services\CompensationReportService;
use App\Services\ExcelService;
use Illuminate\Http\Request;

class CompensationReportController extends Controller
{
    protected $compensationReportService;
    protected $excelService;

    public function __construct(CompensationReportService $compensationReportService, ExcelService $excelService)
    {
        $this->compensationReportService = $compensationReportService;
        $this->excelService = $excelService;
    }

    public function generateReport()
    {
        $report = $this->compensationReportService->generateReport();

        // Optionally handle dynamic file naming here
        $fileName = 'compensation_report_' . now()->format('Y_m_d_His') . '.csv';

        return $this->excelService->generateExcel($report, $fileName);
    }
}
