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

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($quotation) { // before delete() method call this
            
            if ($quotation->quotation_products()->count() > 0) {
                $quotation->quotation_products()->each(function ($quotation_products) {
                    $quotation_products->delete();
                });
            }

            // do the rest of the cleanup...
        });
    }
    public function quotation_products(){
        return $this->hasMany(QuotationProduct::class, 'id', 'quot_id');
    }
    public function scopeFilter($query, array $filters)
    {

        $query->when($filters['search'] ?? null, function ($query, $search) use ($filters) {

            $search_field = $filters['search'] ?? '';
            // dd($search_field);
            if (!empty($search_field)) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('clients.CST_Name', 'like', '%' . $search . '%');
                });

            }
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
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