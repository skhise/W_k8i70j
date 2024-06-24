<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class ServiceDc extends Model
{

    protected $table = "service_dc";
    protected $fillable = [
        "service_id",
        "dc_type",
        "dc_status",
        'dc_remark',
        'dc_amount',
        "issue_date"
    ];

    public function totalProduct($id)
    {
        $count = 0;
        try {
            $count = ServiceDcProduct::where(['dc_id' => $id])->count();
        } catch (Exception $exception) {

        }
        return $count;
    }
    public function scopeFilter($query, array $filters)
    {

        $query->when($filters['search'] ?? null, function ($query, $search) use ($filters) {

            $search_field = $filters['search_field'] ?? '';
            if (empty($search_field)) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('dc_type', 'like', '%' . $search . '%')
                        ->orWhere('clients.CST_Name', 'like', '%' . $search . '%');
                });

            }
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        })->when($filters['filter_status'] ?? null, function ($query, $search) {
            $query->where('dc_type', 'like', '%' . $search . '%');
        });
    }
}