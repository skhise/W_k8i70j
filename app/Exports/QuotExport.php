<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use App\Models\Contract;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QuotExport implements FromArray, WithHeadings
{
    use Exportable;

    protected $items;
    private $headers = [
        'Content-Type' => 'text/csv',
    ];
    public function headings(): array
    {
        return [
            "Date",
            "Client Name",
            'Total QTY',
            "Total Amount",
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