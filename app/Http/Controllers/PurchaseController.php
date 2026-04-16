<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        // ── Static Purchase Data ─────────────────────
        $allPurchases = collect([
            (object)[
                'id'            => 101,
                'product_code'  => 'PRD-001',
                'quantity'      => 50,
                'rate'          => 250.00,
                'gst_percent'   => 18,
                'gst_amount'    => 2250.00,
                'total_amount'  => 14750.00,
                'purchase_date' => now()->subDays(1),
                'notes'         => 'Bulk order from supplier A',
            ],
            (object)[
                'id'            => 102,
                'product_code'  => 'PRD-003',
                'quantity'      => 100,
                'rate'          => 120.00,
                'gst_percent'   => 12,
                'gst_amount'    => 1440.00,
                'total_amount'  => 13440.00,
                'purchase_date' => now()->subDays(2),
                'notes'         => null,
            ],
        ]);

        // ── Simple filter by product_code ────────────
        $filtered = $allPurchases;
        if ($request->filled('product_code')) {
            $search = strtoupper($request->product_code);
            $filtered = $filtered->filter(function ($item) use ($search) {
                return str_contains($item->product_code, $search);
            });
        }

        // ── Manual Pagination ────────────────────────
        $perPage = 8;
        $page    = $request->get('page', 1);
        $offset  = ($page - 1) * $perPage;

        $purchases = new LengthAwarePaginator(
            $filtered->slice($offset, $perPage)->values(),
            $filtered->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('purchases.index', compact('purchases'));
    }

    public function store(Request $request)
    {
        // No DB — just flash success and redirect
        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase recorded successfully! (Demo mode — no database connected)');
    }
}