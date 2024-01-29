<?php

namespace App\Http\Controllers;

use App\Models\invoices;

use Illuminate\Http\Request;
use App\Models\invoices_details;
use App\Models\invoices_attachemets;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(invoices_details $invoices_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $invoice = invoices::where('id', $id)->first();
        $details = invoices_details::where('id_Invoice', $id)->get();
        $attachments = invoices_attachemets::where('id_Invoice', $id)->get();
        return view('invoices/details_invoice', compact('invoice', 'details', 'attachments'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Storage::disk('public_old')->delete($request->invoice_number . '/' . $request->file_name);

        $invoices = invoices_attachemets::findOrFail($request->id_file);
        $invoices->delete();
        session()->flash('delete', 'تم حذف المرفق بنجاح');

        return back();

    }
    // public function getDetails($id)
    // {
    //     // return $id;
    //     return view('invoices/details_invoice', compact('id'));
    // }
    // public function viewAttachment($invoice_number, $file_name)
    // {
    //     echo " Say hello";
    //     // $path = Storage::putFile('public_old', new File(($invoice_number . '/' . $file_name)));

    //     // $files = Storage::disk('public_old')->getDriver()->getAdapter()->applyPathPrefix($invoice_number . '/' . $file_name);
    //     // return response()->file($files);
    //     // return response()->file($path);

    //     return redirect(asset('Attachments/' . $invoice_number . '/' . $file_name));
    // }
    public function viewAttachment($invoice_number, $file_name)
    {
        // The file path should be relative to the Laravel's public directory
        $file_path = public_path('Attachments/' . $invoice_number . '/' . $file_name);

        // Check if the file exists before attempting to display it
        if (file_exists($file_path)) {
            return response()->file($file_path, [
                'Content-Disposition' => 'inline; filename="' . $file_name . '"'
            ]);
        } else {
            // You can return an error response or redirect back with an error message if the file does not exist
            session()->flash('delete', 'الملف غير موجود');
            return back();

        }
    }
    public function downloadAttachment($invoice_number, $file_name)
    {
        // The file path should be relative to the Laravel's public directory
        $file_path = public_path('Attachments/' . $invoice_number . '/' . $file_name);

        // Check if the file exists before attempting to download it
        if (file_exists($file_path)) {
            return response()->download($file_path);
        } else {
            // You can return an error response or redirect back with an error message if the file does not exist
            session()->flash('delete', 'الملف غير لالالا موجود');
            return back();
        }
    }
}
