<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';
    
    protected $fillable = [
        'name',
        'description',
        'price',
        'variant_type',
        'variants',
        'image',
        'category_id',
        'is_available'
    ];
    
    protected $casts = [
        'is_available' => 'boolean',
        'price' => 'decimal:2'
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    // Simple hasVariants method
    public function hasVariants()
    {
        if ($this->variant_type !== 'multiple') {
            return false;
        }
        
        if (empty($this->variants)) {
            return false;
        }
        
        return true;
    }
    
    // Get variants as array
    public function getVariantsArray()
    {


      

        if (empty($this->variants)) {
            return [];
        }
        
        if (is_string($this->variants)) {
            //  $decoded = json_decode($this->variants, true);

            $decoded = json_decode($this->variants, true);

            // If still string, decode again
            if (is_string($decoded)) {
                $decoded = json_decode($decoded, true);
            }

             $indexed = array_values($decoded);

    
            return is_array($indexed) ? $indexed : [];
        }
        
        return is_array($this->variants) ? $this->variants : [];
    }
    
    // Get min price from variants
    public function getMinPrice()
    {
        $variants = $this->getVariantsArray();


        if (empty($variants)) {
            return $this->price;
        }
        
        $prices = array_column($variants, 'price');

      

        return !empty($prices) ? min($prices) : $this->price;
    }
    
    // Get price for specific variant
    public function getVariantPrice($variantName)
    {
        $variants = $this->getVariantsArray();
        foreach ($variants as $variant) {
            if ($variant['name'] === $variantName) {
                return $variant['price'];
            }
        }
        return $this->price;
    }
}