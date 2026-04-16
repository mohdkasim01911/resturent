<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Category;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::with('category')->latest()->paginate(10);
        return view('admin.foods.index', compact('foods'));
    }
    
    public function create()
    {
        $categories = Category::all();
        return view('admin.foods.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'variant_type' => 'required|in:none,multiple',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'boolean'
        ]);
        
        $data = $request->all();
        
        // Handle variants
        if ($request->variant_type === 'multiple') {
            $variants = [];
            if ($request->has('variant_names') && $request->has('variant_prices')) {
                for ($i = 0; $i < count($request->variant_names); $i++) {
                    if (!empty($request->variant_names[$i]) && $request->variant_prices[$i] !== null) {
                        $variants[] = [
                            'name' => $request->variant_names[$i],
                            'price' => (float) $request->variant_prices[$i]
                        ];
                    }
                }
            }
            $data['variants'] = json_encode($variants);
            $data['price'] = 0; // Reset price for variant items
        } else {
            $data['variants'] = null;
        }

        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/foods'), $imageName);
            $data['image'] = 'uploads/foods/' . $imageName;
        }
        
        Food::create($data);
        
        return redirect()->route('admin.foods.index')
            ->with('success', 'Food created successfully!');
    }
    
    public function edit(Food $food)
    {
        $categories = Category::all();
        return view('admin.foods.edit', compact('food', 'categories'));
    }
   


    public function update(Request $request, Food $food)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'variant_type' => 'required|in:none,multiple',
            'is_available' => 'boolean'
        ]);
        
        // Direct assignment
        $food->name = $request->name;
        $food->description = $request->description;
        $food->category_id = $request->category_id;
        $food->variant_type = $request->variant_type;
        $food->is_available = $request->is_available ? 1 : 0;
        
        // Handle variants
        if ($request->variant_type === 'multiple') {
            $variants = [];
            if ($request->has('variant_names') && $request->has('variant_prices')) {
                for ($i = 0; $i < count($request->variant_names); $i++) {
                    if (!empty($request->variant_names[$i]) && $request->variant_prices[$i] !== null && $request->variant_prices[$i] !== '') {
                        $variants[] = [
                            'name' => $request->variant_names[$i],
                            'price' => (float) $request->variant_prices[$i]
                        ];
                    }
                }
            }
            $food->variants = json_encode($variants);
            $food->price = null;
        } else {
            $food->variants = null;
            $food->price = $request->price;
        }
        
        // Handle image
        if ($request->hasFile('image')) {
            if ($food->image && file_exists(public_path($food->image))) {
                unlink(public_path($food->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/foods'), $imageName);
            $food->image = 'uploads/foods/' . $imageName;
        }
        
        // Save the food
        if ($food->save()) {
            return redirect()->route('admin.foods.index')
                ->with('success', 'Food updated successfully!');
        } else {
            return redirect()->back()
                ->with('error', 'Failed to update food!');
        }
    }


    
    public function destroy(Food $food)
    {
        if ($food->image && file_exists(public_path($food->image))) {
            unlink(public_path($food->image));
        }
        
        $food->delete();
        
        return redirect()->route('admin.foods.index')
            ->with('success', 'Food deleted successfully!');
    }
    
    public function toggleStatus($id)
    {
        $food = Food::findOrFail($id);
        $food->is_available = !$food->is_available;
        $food->save();
        
        return redirect()->back()->with('success', 'Food status updated!');
    }
}