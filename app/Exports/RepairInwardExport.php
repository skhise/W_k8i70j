<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RepairInwardExport implements FromArray, WithHeadings
{
    use Exportable;

    protected $items;
    
    public function headings(): array
    {
        return [
            "Sr. No.",
            "Inward No.",
            "Date",
            "Customer Name",
            "Ticket No.",
            "Status",
            "Spare Type",
            "Part/Model Name",
            "Description",
            "Location",
            "Remark"
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
