<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with('user');
        
        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Filter by date range
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Search by order ID or customer name
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('id', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($user) use ($request) {
                      $user->where('name', 'like', '%' . $request->search . '%')
                           ->orWhere('email', 'like', '%' . $request->search . '%');
                  });
            });
        }
        
        $orders = $query->latest()->paginate(15);
        
        // Get statistics
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        
        return view('admin.orders.index', compact(
            'orders', 
            'totalOrders', 
            'pendingOrders', 
            'processingOrders',
            'completedOrders', 
            'cancelledOrders',
            'totalRevenue'
        ));
    }
    
    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::with(['user', 'items.food'])->findOrFail($id);
        
        return view('admin.orders.show', compact('order'));
    }
    
    /**
     * Update order status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);
        
        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $order->status = $request->status;
        $order->save();
        
        // You can add notification logic here
        // Mail::to($order->user->email)->send(new OrderStatusUpdated($order));
        
        return redirect()->back()->with('success', 'Order status updated from ' . ucfirst($oldStatus) . ' to ' . ucfirst($order->status));
    }
    
    /**
     * Update multiple orders status.
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id',
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);
        
        Order::whereIn('id', $request->order_ids)->update(['status' => $request->status]);
        
        return redirect()->back()->with('success', count($request->order_ids) . ' orders updated successfully!');
    }
    
    /**
     * Remove the specified order.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        
        // Delete order items first
        $order->items()->delete();
        
        // Delete order
        $order->delete();
        
        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully!');
    }
    
    /**
     * Generate invoice for order.
     */
    public function generateInvoice($id)
    {
        $order = Order::with(['user', 'items.food'])->findOrFail($id);
        
        // You can generate PDF invoice here
        // For now, return a view
        return view('admin.orders.invoice', compact('order'));
    }
    
    /**
     * Export orders to CSV.
     */
    public function export(Request $request)
    {
        $query = Order::with('user');
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $orders = $query->get();
        
        $filename = 'orders_export_' . date('Y-m-d_H-i-s') . '.csv';
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        // Add CSV headers
        fputcsv($handle, ['Order ID', 'Customer', 'Email', 'Phone', 'Total Amount', 'Status', 'Date', 'Address']);
        
        // Add data rows
        foreach ($orders as $order) {
            fputcsv($handle, [
                $order->id,
                $order->user->name,
                $order->user->email,
                $order->phone,
                $order->total_amount,
                $order->status,
                $order->created_at->format('Y-m-d H:i:s'),
                $order->shipping_address
            ]);
        }
        
        fclose($handle);
        exit;
    }
}