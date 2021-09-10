<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResultTemplateExport implements FromArray, WithHeadings
{
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return  $this->data;
    }

    public function headings(): array
    {
        return [
            'S/N',
            'Vendor Id',
            'Application Id',
            'Name OF Candidate',
            'Index Numbers',
            'Tier',
            'Batch',
            'Traning Centre',
            'Exam Score (50)',
            'Percentage Score'
        ];
    }
}
