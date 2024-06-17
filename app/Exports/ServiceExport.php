<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ServiceExport implements FromArray, WithHeadings
{
    use Exportable;

    protected $items;
    private $headers = [
        'Content-Type' => 'text/csv',
    ];
    public function headings(): array
    {
        return [
            "Ticket No.",
            "Type",
            "Contract No.",
            "Client Name",
            "Service Type",
            "Issue Type",
            "Problem Reported By Customer",
            "Responce Time",
            "Problem Reported By Engineer",
            "Action Taken By Engineer",
            "Status",
            "Engineer",
            "Resolved At",
            "Age(Hours)",
            "Closed At",
            "Expansion",
            "Customer Charges",
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