<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    use HasFactory;
    
   protected $table = 'systemlogs';
   protected $fillable = [
       'loginId',
       'ActionDescription'
    ];



    public function scopeFilter($query, array $filters)
   {

      $query->when($filters['search'] ?? null, function ($query, $search) use ($filters) {

         $search_field = $filters['search_field'] ?? '';
         if (empty ($search_field)) {
            $query->where(function ($query) use ($search) {
               $query->orWhere('created_at', 'like', '%' . $search . '%');
            });

         }
      })->when($filters['trashed'] ?? null, function ($query, $trashed) {
         if ($trashed === 'with') {
            $query->withTrashed();
         } elseif ($trashed === 'only') {
            $query->onlyTrashed();
         }
      })->when($filters['created_at'] ?? null, function ($query, $search) {
         $query->where('created_at', 'like', '%' . $search . '%');
      });
   }
}