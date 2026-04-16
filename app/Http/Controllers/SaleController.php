<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        // ── Static Sale Data ─────────────────────────
        $allSales = collect([
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
            (object)[
                'id'            => 202,
                'product_code'  => 'PRD-003',
                'quantity'      => 40,
                'selling_price' => 180.00,
                'gst_percent'   => 12,
                'gst_amount'    => 864.00,
                'total_amount'  => 8064.00,
                'sale_date'     => now()->subDays(1),
                'notes'         => null,
            ],
        ]);

        // ── Simple filter ────────────────────────────
        $filtered = $allSales;
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

        $sales = new LengthAwarePaginator(
            $filtered->slice($offset, $perPage)->values(),
            $filtered->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // ── Product codes for Sale form dropdown ─────
        $productCodes = [
            'PRD-001', 'PRD-002', 'PRD-003', 'PRD-005',
            'PRD-007', 'PRD-008', 'PRD-010', 'PRD-012',
            'PRD-015', 'PRD-019', 'PRD-020',
        ];

        // ── Stock data for client-side validation ────
        $stockData = [
            'PRD-001' => 90,
            'PRD-002' => 60,
            'PRD-003' => 60,
            'PRD-005' => 3,
            'PRD-007' => 20,
            'PRD-008' => 7,
            'PRD-010' => 120,
            'PRD-012' => 0,
            'PRD-015' => 22,
            'PRD-019' => 2,
            'PRD-020' => 35,
        ];

        return view('sales.index', compact('sales', 'productCodes', 'stockData'));
    }

    public function store(Request $request)
    {
        return redirect()
            ->route('sales.index')
            ->with('success', 'Sale recorded successfully! (Demo mode — no database connected)');
    }
}