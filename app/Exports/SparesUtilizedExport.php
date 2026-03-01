<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SparesUtilizedExport implements FromArray, WithHeadings
{
    use Exportable;

    protected $items;

    public function headings(): array
    {
        return [
            'Sr. No.',
            'Product Name',
            'Product Type',
            'Stock Qty',
            'Reserved Qty',
            'Utilized Qty',
            'Last Used Date',
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
