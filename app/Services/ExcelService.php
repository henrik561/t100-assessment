<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CompensationReportExport;

class ExcelService
{
    /**
     * Generate an Excel or CSV file.
     *
     * @param Collection $data
     * @param string $fileName
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function generateExcel(Collection $data, string $fileName = 'compensation_report.xlsx')
    {
        return Excel::download(new CompensationReportExport($data), $fileName);
    }
}
