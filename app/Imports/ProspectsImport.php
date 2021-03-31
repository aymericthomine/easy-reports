<?php

namespace App\Imports;

use App\Models\Prospect;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProspectsImport implements ToModel, WithStartRow, WithBatchInserts, WithChunkReading // , ShouldQueue // , WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Prospect([
            'A' => $row[0],
            'B' => $row[1],
            'C' => $row[2],
            'D' => $row[3],
            'E' => $row[4],
            'F' => $row[5],
            'G' => $row[6],
            'H' => $row[7],
            'I' => $row[8],
            'J' => $row[9],
            'K' => $row[10],
            'L' => $row[11],
            'M' => $row[12],
            'N' => $row[13],
            'O' => $row[14],
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function batchSize(): int
    {
        return 100;
    }
}
