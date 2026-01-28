<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UtilizedProductExport implements FromArray, WithHeadings
{
    use Exportable;

    protected $items;
    private $headers = [
        'Content-Type' => 'text/csv',
    ];
    
    public function headings(): array
    {
        return [
            "Sr. No.",
            "Client Name",
            "Contract No.",
            "Service No.",
            "Product Name",
            "Serial Number",
            "DC Type",
            "Amount",
            "Description",
            "Issue Date"
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
