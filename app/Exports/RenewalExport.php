<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RenewalExport implements FromArray, WithHeadings
{
    use Exportable;

    protected $items;
    private $headers = [
        'Content-Type' => 'text/csv',
    ];
    
    public function headings(): array
    {
        return [
            "Contract No.",
            "Contract Type",
            "Customer Name",
            "Start Date",
            "Expiry Date",
            "Cost",
            "Note",
            "Renewal Date"
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
