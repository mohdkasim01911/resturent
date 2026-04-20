<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
   

      private $centerLat = 27.1766701;  // Delhi
    private $centerLng = 78.0080745;
    private $maxRadius = 5; // 5 km


    public function index()
    {

    //    echo Hash::make('123456');
    //    die;


        $featuredFoods = Food::with('category')->where('is_available', true)->latest()->take(8)->get();
        $categories = Category::withCount('foods')->get();
        $popularFoods = Food::with('category')->where('is_available', true)->inRandomOrder()->take(6)->get();
        
        return view('user.home', compact('featuredFoods', 'categories', 'popularFoods'));
    }
    
    
    public function menu(Request $request)
    {
        $query = Food::with('category')->where('is_available', true);
        
        // Category filter
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
        
        // Search filter
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Price filter
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }
        
        $foods = $query->paginate(12);
        $categories = Category::all();
        $selectedCategory = $request->category;
        
        return view('user.menu', compact('foods', 'categories', 'selectedCategory'));
    }
    
    public function foodDetail($id)
    {
        $food = Food::with('category')->findOrFail($id);
        $relatedFoods = Food::where('category_id', $food->category_id)
            ->where('id', '!=', $id)
            ->where('is_available', true)
            ->limit(4)
            ->get();
        
        return view('user.food-detail', compact('food', 'relatedFoods'));
    }
    
    public function categoryWise($id)
    {
        $category = Category::findOrFail($id);
        $foods = Food::where('category_id', $id)
            ->where('is_available', true)
            ->paginate(12);
        $categories = Category::all();
        
        return view('user.menu', compact('foods', 'categories', 'category'));
    }
    
    public function search(Request $request)
    {
        $search = $request->search;
        $foods = Food::where('name', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->where('is_available', true)
            ->paginate(12);
        $categories = Category::all();
        
        return view('user.menu', compact('foods', 'categories', 'search'));
    }
    
    public function userDashboard()
    {
            
         if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }


        $user = Auth::user();
        $recentOrders = Order::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
        $totalOrders = Order::where('user_id', $user->id)->count();
        $totalSpent = Order::where('user_id', $user->id)
            ->where('status', 'completed')
            ->sum('total_amount');
        
        return view('user.dashboard', compact('user', 'recentOrders', 'totalOrders', 'totalSpent'));
    }

    public function saveLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

         $userLat = $request->latitude;
        $userLng = $request->longitude;
        
        $distance = $this->calculateDistance($this->centerLat, $this->centerLng, $userLat, $userLng);

            if ($distance > $this->maxRadius) {
                return response()->json(['message' => 'Sorry, we do not deliver to your location.','distance' => round($distance, 2)], 400);
            }

        return response()->json(['message' => 'Location saved successfully']);
    }

    // Calculate distance function
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371; // km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $R * $c;
    }

    public function saveLocationRestriction(Request $request)
    {
        $error = $request->query('error', 'You cannot order from this location.');
        return view('location-restricted', compact('error'));
    }
}