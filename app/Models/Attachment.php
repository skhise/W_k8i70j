<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Contract;
class Attachment extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $table = 'contract_attachment';
   protected $fillable = [
       'Contract_Id',
       'Attachment_Path',
       'Description'
    ];
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
    
}