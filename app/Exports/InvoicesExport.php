<?php

namespace App\Exports;

use App\Models\invoices;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvoicesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    // public function collection()
    // {
    //     return invoices::all();
    //     // return invoices::select('', );
    // }
    public function collection()
    {
        return Invoices::all()->map(function ($invoice) {
            return [
                'id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'invoice_Date' => $invoice->invoice_Date,
                'Due_date' => $invoice->Due_date,
                'product' => $invoice->product,
                'Amount_collection' => $invoice->Amount_collection,
                'Amount_Commission' => $invoice->Amount_Commission,
                'Discount' => $invoice->Discount,
                'Value_VAT' => $invoice->Value_VAT,
                'Rate_VAT' => $invoice->Rate_VAT,
                'Total' => $invoice->Total,
                'Status' => $invoice->Status,
                'Value_Status' => $invoice->Value_Status,
                'note' => $invoice->note,
                'Payment_Date' => $invoice->Payment_Date,
                // Add more columns as needed
            ];
        });
    }
    public function headings(): array
    {
        return [
            'ID',
            'Invoice Number',
            'Invoice Date',
            'Due Date',
            'Product',
            'Amount Collection',
            'Amount Commission',
            'Discount',
            'Value VAT',
            'Rate VAT',
            'Total',
            'Status',
            'Value Status',
            'Note',
            'Payment Date',
            // Add more column headers as needed
        ];
    }
}
