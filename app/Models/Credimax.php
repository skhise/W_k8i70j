<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credimax extends Model
{
    
    public $timestamps = true;
    protected $table = 'credimax_indicators';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'successIndicator',
        'sessionID',
        'sessionVersion',
        'orderID',
        'type',
        'status'
    ];

    /**
     * Set fields for sorting
     * @var array
     */
    public static $sortableFields = [
        /*'user_id',
        'menu_item_id',
        'menu_category_id',
        'meal_purchase_id',
        'status',
        'kcal',
        'menu_item_date',
        'menu_item_day',
        'menu_item_name',
        'first_name',
        'last_name',
        'mobile',
        'delivery_address',
        'delivery_time',
        'notes',*/
    ];
    
    /*public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function menuCategory() {
        return $this->belongsTo(MenuCategory::class, 'menu_category_id');
    }
    
    public function mealPurchase() {
        return $this->belongsTo(MealPurchase::class, 'meal_purchase_id');
    }*/
    
}
