<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ResultImport implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation
{
    /**
    * @param Collection $collection
    */
    private $data = [];

    public function collection(Collection $rows)
    {
        $this->data = $rows;
    }

    public function getImportedData()
    {
        return $this->data;
    }


    public function rules(): array
    {
        return [
          '*.vendor_id' => 'required',
          '*.application_id' => 'required',
          '*.exam_score_50' => 'required|integer|between:0,100',
          '*.percentage_score' => 'required|integer|between:0,100',
        ];

        // "sn" => 1
        // "vendor_id" => 5
        // "application_id" => 2
        // "name_of_candidate" => "Public Vendor 1"
        // "index_numbers" => "PCN/MT/4-2021/AB/SCH3/T1/1003"
        // "tier" => "Tier 1"
        // "batch" => "4/2021"
        // "traning_centre" => "School 3"
        // "exam_score_50" => 12
        // "percentage_score" => 56
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
