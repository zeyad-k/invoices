<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices_attachemets;
use Illuminate\Support\Facades\Auth;

class InvoicesAttachemetsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $this->validate($request, [

            'file_name' => 'mimes:pdf,jpeg,png,jpg',

        ], [
            'file_name.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
        ]);

        // $this->validate($request, ['pic' => 'required|mimes:pdf|max:10000'], ['pic.mimes' => 'خطأ : تم حفظ الفاتورة و  لم يتم حفظ المرفق لابد ان يكون pdf']);

        $invoice_id = $request->invoice_id;
        $image = $request->file('file_name');
        $file_name = $image->getClientOriginalName();
        $invoice_number = $request->invoice_number;

        $attachments = new invoices_attachemets();
        $attachments->file_name = $file_name;
        $attachments->invoice_number = ' $invoice_number';
        $attachments->Created_by = Auth::user()->name;
        $attachments->id_Invoice = $invoice_id;
        $attachments->save();

        // move pic
        $imageName = $request->file_name->getClientOriginalName();
        $request->file_name->move(public_path('Attachments/' . $invoice_number), $imageName);

        session()->flash('Add', 'تم اضافة المرفق بنجاح');
        return back();

    }

    /**
     * Display the specified resource.
     */
    public function show(invoices_attachemets $invoices_attachemets)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoices_attachemets $invoices_attachemets)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoices_attachemets $invoices_attachemets)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(invoices_attachemets $invoices_attachemets)
    {
        //
    }
}
