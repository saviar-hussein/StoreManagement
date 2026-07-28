<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        // 1. Get Low Stock Categories (Using Category for now, will be Product later per PDF)
        // PDF says: "products where stock_quantity <= 10 ordered ascending"
        // We will use a safe query that won't crash if the products table doesn't exist yet.
        $lowStockItems = [];
        
        try {
            // This will work once you create the 'products' table in Slice 2
            $lowStockItems = DB::table('products')
                ->where('stock_quantity', '<=', 10)
                ->orderBy('stock_quantity', 'asc')
                ->get();
        } catch (\Exception $e) {
            // Table doesn't exist yet, return empty array safely
            $lowStockItems = [];
        }

        // 2. Mock data for revenue/transactions until Slice 4 (Point of Sale) is built
        $todaysRevenue = 0;
        $transactionCount = 0;

        try {
            // This will work once you create the 'sales' table in Slice 4
            $today = now()->startOfDay();
            $salesData = DB::table('sales')
                ->whereDate('created_at', $today)
                ->selectRaw('SUM(total_amount) as revenue, COUNT(*) as count')
                ->first();
                
            $todaysRevenue = $salesData->revenue ?? 0;
            $transactionCount = $salesData->count ?? 0;
        } catch (\Exception $e) {
            // Table doesn't exist yet
        }

        // 3. Return the JSON response
        return response()->json([
            'success' => true,
            'data' => [
                'todays_revenue' => $todaysRevenue,
                'transaction_count' => $transactionCount,
                'low_stock_items' => $lowStockItems,
            ]
        ], 200);
    }
}
