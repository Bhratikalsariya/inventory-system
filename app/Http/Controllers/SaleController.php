<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellProductRequest;
use App\Models\PurchaseProduct;
use App\Models\SellProduct;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        // ── Static Sale Data ─────────────────────────
        $allSales = SellProduct::all();
        // $allSales = collect([
        //     (object)[
        //         'id'            => 201,
        //         'product_code'  => 'PRD-001',
        //         'quantity'      => 10,
        //         'selling_price' => 400.00,
        //         'gst_percent'   => 18,
        //         'gst_amount'    => 720.00,
        //         'total_amount'  => 4720.00,
        //         'sale_date'     => now()->subDays(1),
        //         'notes'         => 'Walk-in customer',
        //     ],
        //     (object)[
        //         'id'            => 202,
        //         'product_code'  => 'PRD-003',
        //         'quantity'      => 40,
        //         'selling_price' => 180.00,
        //         'gst_percent'   => 12,
        //         'gst_amount'    => 864.00,
        //         'total_amount'  => 8064.00,
        //         'sale_date'     => now()->subDays(1),
        //         'notes'         => null,
        //     ],
        // ]);

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
        $productCodes = PurchaseProduct::pluck('product_code')->unique()->toArray();

        // ── Stock data for client-side validation ────
        // $stockData = PurchaseProduct::select('product_code')
        //     ->selectRaw('SUM(quantity) as total_purchased')
        //     ->groupBy('product_code')
        //     ->pluck('total_purchased', 'product_code')
        //     ->toArray();

        $stockData = PurchaseProduct::with('stock')->get()->map(function ($item) {
            return [$item->product_code => $item->stock ? $item->stock->current_stock : 0];
        })->collapse()->toArray();

        return view('sales.index', compact('sales', 'productCodes', 'stockData'));
    }

    public function store(SellProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $gst_amount = ($request->selling_price * $request->quantity * $request->gst_percent) / 100;
            $sellProduct = SellProduct::create([
                'product_code'  => $request->product_code,
                'quantity'      => $request->quantity,
                'selling_price' => $request->selling_price,
                'gst_percent'   => $request->gst_percent,
                'gst_amount'    => $gst_amount,
                'total_amount'  => ($request->selling_price * $request->quantity) + ($gst_amount),
            ]);
            $stockData = Stock::where('product_code', $request->product_code)->first();
            if ($stockData) {
                if ($stockData->current_stock < $request->quantity) {
                    return back()->with('error', 'Not enough stock');
                }

                $stockData->total_sold_qty += $request->quantity;
                $stockData->current_stock -= $request->quantity;
                $stockData->save();

            } else {
                return back()->with('error', 'Product not found in stock');
            }
            DB::commit();
            return redirect()
                ->route('sales.index')
                ->with('success', 'Sale recorded successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('sales.index')
                ->with('error', 'Failed to record sale: ' . $e->getMessage());
        }
    }
}