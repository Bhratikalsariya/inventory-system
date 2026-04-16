<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function purchasesCsv(Request $request)
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="purchases_report.csv"',
        ];

        $csvContent = "ID,Product Code,Quantity,Rate,GST %,GST Amount,Total Amount,Date,Notes\n";
        $csvContent .= "101,PRD-001,50,250.00,18,2250.00,14750.00,2025-01-15,Bulk order\n";
        $csvContent .= "102,PRD-003,100,120.00,12,1440.00,13440.00,2025-01-14,\n";
        $csvContent .= "103,PRD-007,25,890.00,18,4005.00,26255.00,2025-01-13,Quarterly restock\n";
        $csvContent .= "104,PRD-010,200,45.00,5,450.00,9450.00,2025-01-12,\n";
        $csvContent .= "105,PRD-015,30,1500.00,28,12600.00,57600.00,2025-01-11,Premium items\n";

        return response($csvContent, 200, $headers);
    }

    public function salesCsv(Request $request)
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="sales_report.csv"',
        ];

        $csvContent = "ID,Product Code,Quantity,Selling Price,GST %,GST Amount,Total Amount,Date,Notes\n";
        $csvContent .= "201,PRD-001,10,400.00,18,720.00,4720.00,2025-01-15,Walk-in customer\n";
        $csvContent .= "202,PRD-003,40,180.00,12,864.00,8064.00,2025-01-15,\n";
        $csvContent .= "203,PRD-007,5,1350.00,18,1215.00,7965.00,2025-01-14,Dealer order\n";
        $csvContent .= "204,PRD-010,80,75.00,5,300.00,6300.00,2025-01-13,\n";
        $csvContent .= "205,PRD-015,8,2200.00,28,4928.00,22528.00,2025-01-12,Corporate sale\n";

        return response($csvContent, 200, $headers);
    }

    public function stockCsv(Request $request)
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="stock_report.csv"',
        ];

        $csvContent = "ID,Product Code,Total Purchased,Total Sold,Current Stock\n";
        $csvContent .= "1,PRD-001,140,50,90\n";
        $csvContent .= "2,PRD-002,75,15,60\n";
        $csvContent .= "3,PRD-003,100,40,60\n";
        $csvContent .= "4,PRD-005,10,7,3\n";
        $csvContent .= "5,PRD-007,25,5,20\n";
        $csvContent .= "6,PRD-008,60,53,7\n";
        $csvContent .= "7,PRD-010,200,80,120\n";
        $csvContent .= "8,PRD-012,150,150,0\n";
        $csvContent .= "9,PRD-015,30,8,22\n";
        $csvContent .= "10,PRD-019,20,18,2\n";
        $csvContent .= "11,PRD-020,35,12,23\n";

        return response($csvContent, 200, $headers);
    }
}