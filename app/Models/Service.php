<?php
namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceHistory;
use App\Models\ServiceAccessory;

class Service extends Model
{
   use HasFactory;

   protected $table = 'services';
   protected $fillable = [
      'service_no',
      'service_date',
      'customer_id',
      'contract_id',
      'contact_person',
      'contact_number1',
      'contact_number2',
      'contact_email',
      'site_address',
      'site_google_link',
      'issue_type',
      'service_type',
      'service_priority',
      'service_status',
      'service_note',
      'assigned_to',
      'ClosedBy',
      'resolved_datetime',
      'areaId',
      'product_id',
      'product_name',
      'product_description',
      'product_type',
      'deleted_at',
      'service_sub_status',
      'notification_flag',
   ];

   public function wasRecentlyUpdated($minutes = 1)
   {

      return $this->notification_flag == 1;
      // Assuming you have two timestamps
      $startTime = $this->last_updated;
      $endTime = now();

      // Create DateTime objects from the timestamps
      $startDateTime = new DateTime($startTime);
      $endDateTime = new DateTime($endTime);

      // Calculate the time difference
      $timeDifference = $endDateTime->diff($startDateTime);

      // Convert the time difference to minutes
      $timeDifferenceInMinutes = ($timeDifference->h * 60) + $timeDifference->i;
      return $timeDifferenceInMinutes <= $minutes;
   }
   public function history()
   {
      return $this->hasMany(ServiceHistory::class);
   }
   public function accessory()
   {
      return $this->hasMany(ServiceAccessory::class);

   }
   public function contractscheduleservice()
   {
      return $this->belongsTo(ContractScheduleService::class, "Service_Call_Id", "id");

   }
   public static function boot()
   {
      parent::boot();

      self::deleting(function ($service) { // before delete() method call this
         $service->history()->each(function ($history) {
            $history->delete(); // <-- direct deletion
         });
         $service->accessory()->each(function ($accessory) {
            $accessory->delete(); // <-- raise another deleting event on Post to delete comments
         });
         // do the rest of the cleanup...
      });
   }
   public function scopeFilter($query, array $filters)
   {

      $query->when($filters['search'] ?? null, function ($query, $search) use ($filters) {

         $search_field = $filters['search_field'] ?? '';
         if (empty ($search_field)) {
            $query->where('service_no', 'like', '%' . $search . '%')
               ->orWhere('service_no', 'like', '%' . $search . '%');
         }
      })->when($filters['trashed'] ?? null, function ($query, $trashed) {
         if ($trashed === 'with') {
            $query->withTrashed();
         } elseif ($trashed === 'only') {
            $query->onlyTrashed();
         }
      })->when($filters['filter_status'] ?? null, function ($query, $search) {
         $query->where('service_status', 'like', '%' . $search . '%');
      });
   }
}