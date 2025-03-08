<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ServiceStatusExport implements FromArray, WithHeadings
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
            "Issue Description",
            "Status",
            "Engineer",
            "Resolved At",
            "Closed At",
            "Expenses",
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

    return array_map(function ($itemss) {
        // $arr = array();
      return  array_map(function($item){
            return [
                $item['serviceno'] ?? '',  // Ticket No.
                $item['CNRTType'] ?? '',  // Service Type
                $item['CNRTNumber'] ?? '',  // Contract No.
                $item['CSTName'] ?? '',  // Client Name
                $item['typename'] ?? '',  // Type
                $item['issue_name'] ?? '',  // Type
                $item['servicenote'] ?? '',  // Issue Type
                $item['StatusName'] ?? '',  // Status
                $item['EMPName'] ?? '',  // Engineer
                $item['resolveddatetime'] ?? '',  // Resolved At
                $item['closedat'] ?? '',  // Closed At
                $item['expenses1'] ?? '',  // Expansion
                $item['charges2'] ?? '',  // Customer Charges
                $item['closenote'] ?? '',  // Remark
            ];
        },$itemss);
        
    }, $this->items);
}
}