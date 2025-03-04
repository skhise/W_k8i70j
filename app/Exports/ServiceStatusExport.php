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

    return array_map(function ($itemss) {
        // $arr = array();
      return  array_map(function($item){
            return [
                $item['serviceno'] ?? '',  // Ticket No.
                $item['typename'] ?? '',  // Service Type
                $item['CNRTNumber'] ?? '',  // Contract No.
                $item['CSTName'] ?? '',  // Client Name
                $item['typename'] ?? '',  // Type
                $item['servicenote'] ?? '',  // Issue Type
                $item['servicenote'] ?? '',  // Problem Reported By Customer
                $item['responsetime'] ?? '',  // Response Time
                $item['problemreported_by_engineer'] ?? '',  // Problem Reported By Engineer
                $item['actiontakenbyengineer'] ?? '',  // Action Taken By Engineer
                $item['StatusName'] ?? '',  // Status
                $item['EMPName'] ?? '',  // Engineer
                $item['resolveddatetime'] ?? '',  // Resolved At
                $item['createddiffhours'] ?? '',  // Age (Hours)
                $item['closedat'] ?? '',  // Closed At
                $item['expenses1'] ?? '',  // Expansion
                $item['charges2'] ?? '',  // Customer Charges
                $item['closenote'] ?? '',  // Remark
            ];
        },$itemss);
        
    }, $this->items);
}
}