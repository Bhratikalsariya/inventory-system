<?php

namespace App\Http\Controllers;

use App\Models\PurchaseProduct;
use App\Models\SellProduct;
use App\Models\Stock;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function purchasesCsv(Request $request)
    {
        
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="purchases_report.csv"',
        ];
        
        $purchases = PurchaseProduct::latest()->get();
        $csvContent = "ID,Product Code,Quantity,Rate,GST %,GST Amount,Total Amount,Date\n";
        foreach ($purchases as $purchase) {
        $csvContent .= $purchase->id . "," .
                $purchase->product_code . "," .
                $purchase->quantity . "," .
                $purchase->rate . "," .
                $purchase->gst_percent . "," .
                $purchase->gst_amount . "," .
                $purchase->total_amount . "," .
                $purchase->created_at . "\n";
        }

        return response($csvContent, 200, $headers);
    }

    public function salesCsv(Request $request)
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="sales_report.csv"',
        ];
        $sells = SellProduct::latest()->get();
        $csvContent = "ID,Product Code,Quantity,Selling Price,GST %,GST Amount,Total Amount,Date,Notes\n";

        foreach ($sells as $key => $sell) {
            $csvContent .= $sell->id . "," .
                $sell->product_code . "," .
                $sell->quantity . "," .
                $sell->selling_price . "," .
                $sell->gst_percent . "," .
                $sell->gst_amount . "," .
                $sell->total_amount . "," .
                $sell->created_at . "," .
                ($sell->notes ?? '') . "\n";
        }

        return response($csvContent, 200, $headers);
    }

    public function stockCsv(Request $request)
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="stock_report.csv"',
        ];

        $stocks = Stock::latest()->get();

        $csvContent = "ID,Product Code,Total Purchased,Total Sold,Current Stock\n";

        foreach ($stocks as $stock) {
            $csvContent .= $stock->id . "," .
                $stock->product_code . "," .
                $stock->total_purchased_qty . "," .
                $stock->total_sold_qty . "," .
                $stock->current_stock . "\n";
        }

        return response($csvContent, 200, $headers);
    }
}