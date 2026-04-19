<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('user.cart', compact('cart', 'total'));
    }
    
    public function add($id, Request $request)
    {

        $food = Food::findOrFail($id);
        $cart = Session::get('cart', []);
        
        $variantName = $request->variant_name;
        $quantity = $request->quantity ?? 1;
        $price = $food->price;

    if ($food->variant_type === 'multiple' && $variantName) {                   

        $variants = $food->variants;

        // if double encoded
        if (is_string($variants)) {
            $variants = json_decode($variants, true);

            if (is_string($variants)) {
                $variants = json_decode($variants, true);
            }
        }

        if (is_array($variants)) {

            foreach ($variants as $variant) {

                if (!empty($variant['name']) && $variant['name'] === $variantName) {
                    $price = $variant['price'];
                    break;
                }
            }
        }

    }
        
        // Create unique key for cart item
        $cartKey = $id . '_' . ($variantName ? str_replace(' ', '_', $variantName) : '');
        
        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                'key' => $cartKey,
                'id' => $food->id,
                'name' => $food->name . ($variantName ? ' (' . $variantName . ')' : ''),
                'price' => $price,
                'quantity' => $quantity,
                'image' => $food->image,
                'variant_name' => $variantName
            ];
        }
        
        Session::put('cart', $cart);
        
        return redirect()->route('user.cart')->with('success', $food->name . ' added to cart!');
    }
    
    public function update($key, Request $request)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
            return redirect()->route('user.cart')->with('success', '');
        }
        
        return redirect()->route('user.cart')->with('error', 'Item not found!');
    }
    
    public function remove($key, Request $request)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$key])) {
            unset($cart[$key]);
            Session::put('cart', $cart);
            return redirect()->route('user.cart')->with('success', 'Item removed from cart!');
        }
        
        return redirect()->route('user.cart')->with('error', 'Item not found!');
    }
    
    public function clear(Request $request)
    {
        Session::forget('cart');
        return redirect()->route('user.cart')->with('success', 'Cart cleared successfully!');
    }
}