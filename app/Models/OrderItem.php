<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    
    // Add fillable properties
    protected $fillable = [
        'order_id',
        'food_id',
        'quantity',
        'price',
        'portion_name' // Add this if you want to store which portion was selected
    ];
    
    // Or use guarded if you want to protect specific fields
    // protected $guarded = [];
    
    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}