<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Static Summary Data ──────────────────────
        $totalPurchases  = 487500.00;
        $totalSales      = 623800.00;
        $inventoryValue  = 215400.00;
        $lowStockCount   = 4;

        // ── Static Low Stock Items ───────────────────
        $lowStockItems = collect([
            (object)[
                'id'            => 1,
                'product_code'  => 'PRD-005',
                'current_stock' => 3,
            ],
            (object)[
                'id'            => 2,
                'product_code'  => 'PRD-012',
                'current_stock' => 0,
            ],
        ]);

        // ── Static Recent Purchases ──────────────────
        $recentPurchases = collect([
            (object)[
                'id'            => 101,
                'product_code'  => 'PRD-001',
                'quantity'      => 50,
                'rate'          => 250.00,
                'gst_percent'   => 18,
                'gst_amount'    => 2250.00,
                'total_amount'  => 14750.00,
                'purchase_date' => now()->subDays(1),
                'notes'         => 'Bulk order',
            ],
        ]);

        // ── Static Recent Sales ──────────────────────
        $recentSales = collect([
            (object)[
                'id'            => 201,
                'product_code'  => 'PRD-001',
                'quantity'      => 10,
                'selling_price' => 400.00,
                'gst_percent'   => 18,
                'gst_amount'    => 720.00,
                'total_amount'  => 4720.00,
                'sale_date'     => now()->subDays(1),
                'notes'         => 'Walk-in customer',
            ],
        ]);

        // ── Static Profit Data ───────────────────────
        $profitData = collect([
            (object)[
                'product_code'          => 'PRD-010',
                'total_purchase_amount' => 36000.00,
                'total_sale_amount'     => 48000.00,
                'profit'                => 12000.00,
                'current_stock'         => 120,
            ],
            (object)[
                'product_code'          => 'PRD-005',
                'total_purchase_amount' => 22000.00,
                'total_sale_amount'     => 19500.00,
                'profit'                => -2500.00,
                'current_stock'         => 3,
            ],
        ]);

        return view('dashboard.index', compact(
            'totalPurchases',
            'totalSales',
            'inventoryValue',
            'lowStockCount',
            'lowStockItems',
            'recentPurchases',
            'recentSales',
            'profitData'
        ));
    }
}