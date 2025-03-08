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
            "Customer Name",
            "Product",
            "Service Type",
            "Issue Type",
            "Issue Description",
            "Contact Person",
            "Reported At",
            "Responce Time",
            "Action Taken By Engineer",
            "Status",
            "Engineer",
            "Resolved At",
            "Age(Hours)",
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
                    $item['product'] ?? '',  // Client Name
                    $item['typename'] ?? '',  // Type
                    $item['issue_name'] ?? '',  // Issue Type
                    $item['servicenote'] ?? '',  // Problem Reported By Customer
                    $item['contactperson'] ?? '',  // Problem Reported By Customer
                    $item['createdat'] ?? '',  // Response Time
                    $item['responsetime'] ?? '',  // Response Time
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