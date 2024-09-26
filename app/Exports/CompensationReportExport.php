<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompensationReportExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return $this->data;
    }

    /**
     * Set the headings for the Excel sheet.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Ambtenaar',
            'Transport',
            'Afgelegde Afstand',
            'Vergoeding',
            'Betaaldatum',
        ];
    }
}
