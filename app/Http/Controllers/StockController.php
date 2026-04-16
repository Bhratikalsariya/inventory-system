<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class StockController extends Controller
{
    public function index(Request $request)
    {
        // ── Static Stock Data ────────────────────────
        $allStock = collect([
            (object)[
                'id'                  => 1,
                'product_code'        => 'PRD-001',
                'total_purchased_qty' => 140,
                'total_sold_qty'      => 50,
                'current_stock'       => 90,
            ],
            (object)[
                'id'                  => 2,
                'product_code'        => 'PRD-002',
                'total_purchased_qty' => 75,
                'total_sold_qty'      => 15,
                'current_stock'       => 60,
            ],
            (object)[
                'id'                  => 3,
                'product_code'        => 'PRD-012',
                'total_purchased_qty' => 150,
                'total_sold_qty'      => 150,
                'current_stock'       => 0,
            ],
        ]);

        // ── Simple filter ────────────────────────────
        $filtered = $allStock;
        if ($request->filled('product_code')) {
            $search = strtoupper($request->product_code);
            $filtered = $filtered->filter(function ($item) use ($search) {
                return str_contains($item->product_code, $search);
            });
        }

        // ── Summary counts ───────────────────────────
        $totalProducts  = $allStock->count();
        $inStockCount   = $allStock->where('current_stock', '>', 0)->count();
        $outOfStockCount = $allStock->where('current_stock', '==', 0)->count();

        // ── Manual Pagination ────────────────────────
        $perPage = 10;
        $page    = $request->get('page', 1);
        $offset  = ($page - 1) * $perPage;

        $stocks = new LengthAwarePaginator(
            $filtered->slice($offset, $perPage)->values(),
            $filtered->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('stock.index', compact(
            'stocks',
            'totalProducts',
            'inStockCount',
            'outOfStockCount'
        ));
    }
}