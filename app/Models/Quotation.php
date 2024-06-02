<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{

    protected $table = "quotation";
    protected $fillable = [
        "customer_id",
        "quot_type",
        "quot_status",
        'quot_remark',
        'quot_amount',
        "issue_date"
    ];

    public function totalProduct($id)
    {
        $count = 0;
        try {
            $count = QuotationProduct::where(['quot_id' => $id])->count();
        } catch (Exception $exception) {

        }
        return $count;
    }
    public function totalAmount($id)
    {
        $sum = 0;
        try {
            $sum = QuotationProduct::where(['quot_id' => $id])->sum('amount');
        } catch (Exception $exception) {

        }
        return $sum;
    }
}