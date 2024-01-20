<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceFieldReport extends Model
{
    use HasFactory;
    
   protected $table = 'service_fieldreport';
   protected $fillable = [
       'ServiceId',
       'QuotationNo',
       'QuotationDate',
       'FWTDS',
       'PWTDS',
       'FWPH',
       'PWPH',
       'FWHardness',
       'PWHardness',
       'FeedPumpPr',
       'HpPumpPr',
       'FilterOutletPr',
       'FeedFlow',
       'FilterInletPr',
       'RejectFlow',
       'SystemPr',
       'ProductFlow',
       'RejectPr',
       'DOA',
       'TOA',
       'ETOA',
       'ObservationNote',
       'ServiceType',
       'PaymentMode',
       'ServiceCharges',
       'Part_Fitting',
       'Vat',
       'TotalAmount',
       'PaymentStatus',
       'EquipmentLeft',
       'Remarks',
       'EquipmenttoOrder',
       'saltVisit',
       'saltVisitDate',
       'filterVisit',
       'filterVisitDate',
       'isSubmitted',
       'payment_date',
       'payment_id',
       'payment_status',
       'payment_method',
    ];
 
}