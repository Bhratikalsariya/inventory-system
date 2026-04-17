<?php

namespace App\Http\Controllers;

use App\Models\PurchaseProduct;
use App\Models\SellProduct;
use App\Models\Stock;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Static Summary Data ──────────────────────
        $totalPurchases  = PurchaseProduct::class::sum('total_amount');
        $totalSales      = SellProduct::class::sum('total_amount');
        $inventoryValue  = Stock::with('purchaseProducts')->where('current_stock', '>', 0)->get()->map(function ($stock) {
            return $stock->purchaseProducts->sum('total_amount');
        })->sum();

        // ── Static Low Stock Items ───────────────────
        $lowStockItems = Stock::where('current_stock', '<=', 10)->get();

        // ── Static Recent Purchases ──────────────────
        $recentPurchases = PurchaseProduct::class::orderBy('updated_at', 'desc')->take(5)->get();

        // ── Static Recent Sales ──────────────────────
        $recentSales = SellProduct::class::orderBy('updated_at', 'desc')->take(5)->get();

        $lowStockCount   = $recentSales->count() > 0 ? $lowStockItems->count() : 0;

        // ── Static Profit Data ───────────────────────
        $profitData = Stock::with('purchaseProducts','sellProducts')->get()->map(function ($stock) {
            $total_purchase_amount = $stock->purchaseProducts->sum(function ($p) {
                                                                    return $p->quantity * $p->rate;
                                                                });
            $total_sale_amount = $stock->sellProducts->sum(function ($s) {
                                                            return $s->quantity * $s->selling_price;
                                                        });
            $cost_of_sold = $stock->total_sold_qty * ($stock->purchaseProducts->sum(fn($p) => $p->quantity * $p->rate) / max($stock->total_purchased_qty,1));

            return (object)[
                'product_code' => $stock->product_code,
                'total_purchase_amount' => $total_purchase_amount,
                'total_sale_amount' => $total_sale_amount,
                'profit' => $total_sale_amount - $cost_of_sold,
                'current_stock' => $stock->current_stock,
            ];
        });

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