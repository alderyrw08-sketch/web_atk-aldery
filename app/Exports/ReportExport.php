<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function __construct(private array $report)
    {
    }

    public function array(): array
    {
        $rows = $this->report['rows'];

        if (!empty($this->report['summary'])) {
            $rows[] = [];
            foreach ($this->report['summary'] as $label => $value) {
                $rows[] = [$label, $value];
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return $this->report['headings'];
    }
}