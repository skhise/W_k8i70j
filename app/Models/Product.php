<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'products';
    protected $fillable = [
        'Product_ID',
        'Product_Name',
        'Product_Description',
        'Product_Price',
        'Image_Path',
        'Status',
        'Product_Type'
    ];

    protected $primaryKey = 'Product_ID';

    public function serialnumbers()
    {
        return $this->hasMany(ProductSerialNumber::class);
    }
    public function scopeFilter($query, array $filters)
    {

        $query->when($filters['search'] ?? null, function ($query, $search) use ($filters) {

            $search_field = $filters['search_field'] ?? '';
            if (empty ($search_field)) {
                $query->where('Product_Name', 'like', '%' . $search . '%');

            }
            if ($search_field == "Product_Name") {
                $query->where('Product_Name', 'like', '%' . $search . '%');
            }
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        })->when($filters['filter_status'] ?? null, function ($query, $search) {
            $query->where('Status', 'like', '%' . $search . '%');
        })->when($filters['filter_type'] ?? null, function ($query, $search) {
            $query->where('type', 'like', '%' . $search . '%');
        });
    }
}