<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ContractBaseAccessory;
use App\Models\ContractBaseProduct;
use App\Models\Attachment;
use App\Models\ProductImage;

class Contract extends Model
{
    use HasFactory;

    protected $table = 'contracts';
    protected $fillable = [
        'CNRT_ID',
        'CNRT_Number',
        'CNRT_TypeStatus',
        'CNRT_SiteType',
        'CNRT_Type',
        'CNRT_RefNumber',
        'CNRT_Date',
        'CNRT_CustomerID',
        'CNRT_Phone1',
        'CNRT_CustomerContactPerson',
        'CNRT_Phone2',
        'CNRT_CustomerEmail',
        'CNRT_SiteLocation',
        'CNRT_SiteAddress',
        'CNRT_StartDate',
        'CNRT_EndDate',
        'CNRT_Charges',
        'CNRT_Charges_Pending',
        'CNRT_Charges_Paid',
        'CNRT_BaseProduct',
        'CNRT_BaseProductQTY',
        'CNRT_TNC',
        'CNRT_Status',
        'CNRT_Note',
        'CNRT_OfficeAddress',
        'CNRT_Site',
        'CNRT_Created_By',
        'AgreementSubject',
        'AgreementBody',
        'AgreementScope',
        'deleted_at'


    ];
    protected $primaryKey = 'CNRT_ID';

    public function baseaccessory()
    {
        return $this->hasMany(ContractBaseAccessory::class, 'contractId', 'CNRT_ID');
    }
    public function baseproduct()
    {
        return $this->hasMany(ContractBaseProduct::class, 'CNRT_ID', 'CNRT_ID');

    }
    public function productimage()
    {
        return $this->hasMany(ProductImage::class, 'Contract_Id', 'CNRT_ID');

    }
    public function attachment()
    {
        return $this->hasMany(Attachment::class, 'Contract_Id', 'CNRT_ID');

    }
    public static function boot()
    {
        parent::boot();
        self::deleting(function ($contract) { // before delete() method call this
            if ($contract->baseaccessory()->count() > 0) {
                $contract->baseaccessory()->each(function ($baseaccessory) {
                    $baseaccessory->delete(); // <-- direct deletion
                });
            }
            if ($contract->baseproduct()->count() > 0) {
                $contract->baseproduct()->each(function ($baseproduct) {
                    $baseproduct->delete(); // <-- direct deletion
                });
            }
            if ($contract->productimage()->count() > 0) {
                $contract->productimage()->each(function ($productimage) {
                    $productimage->delete(); // <-- direct deletion
                });
            }
            if ($contract->attachment()->count() > 0) {
                $contract->attachment()->each(function ($attachment) {
                    $attachment->delete(); // <-- direct deletion
                });
            }

        });
    }
    public function scopeFilter($query, array $filters)
    {

        $query->when($filters['search'] ?? null, function ($query, $search) use ($filters) {

            $search_field = $filters['search_field'] ?? '';
            if (empty($search_field)) {
                $query->where('CNRT_Number', 'like', '%' . $search . '%')
                    ->orWhere('CNRT_Number', 'like', '%' . $search . '%');
            }
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        })->when($filters['filter_status'] ?? null, function ($query, $search) {
            $query->where('CNRT_Status', 'like', '%' . $search . '%');
        });
    }
}