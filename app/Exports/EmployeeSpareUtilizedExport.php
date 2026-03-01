<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeSpareUtilizedExport implements FromArray, WithHeadings
{
    use Exportable;

    protected $items;

    public function headings(): array
    {
        return [
            'Sr. No.',
            'Issue Date',
            'Service No.',
            'Product Name',
            'Quantity',
            'DC Type',
        ];
    }

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function array(): array
    {
        return $this->items;
    }
}
