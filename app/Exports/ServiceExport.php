<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SweviceExport implements FromArray, WithHeadings
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
            "Site",
            "AMC Charges",
            "Payment Received",
            "Payment Pending",
            "Start Date",
            "Expiry Date",
            "Status"

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