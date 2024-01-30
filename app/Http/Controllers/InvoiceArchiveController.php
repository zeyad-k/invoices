<?php

namespace App\Http\Controllers;

use App\Models\invoices_attachemets;

use App\Models\invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = invoices::onlyTrashed()->get();
        return view('Invoices.Archive_Invoices', compact('invoices'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->invoice_id;
        $invoice = invoices::withTrashed()->where('id', $id)->first()->restore();

        session()->flash('archive_invoice');
        return redirect('/InvoiceAchiveController');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoice = invoices::withTrashed()->where('id', $id)->first();
        $Attachment = invoices_attachemets::where('id_Invoice', $invoice->id)->first();
        if ($Attachment) {

            $directory = $Attachment->invoice_number;
            if (Storage::disk('public_old')->exists($directory)) {
                Storage::disk('public_old')->deleteDirectory($directory);
                // rmdir($directory);
            } else {
                session()->flash('file_not_found');
                return redirect('/invoices');
            }
        }
        $invoice->forceDelete();
        session()->flash('delete_invoice');
        return redirect('/InvoiceAchiveController');

    }
}
