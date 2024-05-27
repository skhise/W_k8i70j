<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class ServiceQuotation extends Model
{

    protected $table = "service_quotation";
    protected $fillable = [
        "service_id",
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
            $count = ServiceQuotation::where(['dc_id' => $id])->count();
        } catch (Exception $exception) {

        }
        return $count;
    }
}