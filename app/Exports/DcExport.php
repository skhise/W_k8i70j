<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use App\Models\Contract;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DcExport implements FromArray, WithHeadings
{
    use Exportable;

    protected $items;
    private $headers = [
        'Content-Type' => 'text/csv',
    ];
    public function headings(): array
    {
        return [
            "Client Name",
            'Contract No.',
            'Service No.',
            'Total QTY',
            "Total Amount",
            "Issue Date",
            "Type"

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