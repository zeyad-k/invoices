<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use id;
use App\Models\User;
use App\Models\invoices;
use App\Models\sections;
use Illuminate\Http\Request;
use App\Models\invoices_details;
use App\Notifications\addInvoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\invoices_attachemets;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $invoices_details = invoices_details::all();
        // $sections = sections::all();
        $invoices = invoices::all();
        return view('invoices/invoices', compact('invoices'));
        // return view('invoices/invoices', compact('sections', 'invoices', 'invoices_details'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = sections::all();
        return view('invoices/add_invoice', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            // 'product' => "موقت",
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,

        ]);

        $invoice_id = invoices::latest()->first()->id;
        invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            // 'product' => "موقت",
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),

        ]);

        if ($request->hasFile('pic')) {
            // $this->validate($request, ['pic' => 'required|mimes:pdf|max:10000'], ['pic.mimes' => 'خطأ : تم حفظ الفاتورة و  لم يتم حفظ المرفق لابد ان يكون pdf']);

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoices_attachemets();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->id_Invoice = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
            // $file = $request->pic;
            // return Storage::putFile('lara-bbb', $file);
            // $file = $request->file('pic');
            // $upload = $file->store('invAttachments');
            // dd(storage::url('invAttachments'));
            // $request->pic->Storage::putFile($invoice_number, $imageName);
            // return Storage::putFileAs('Attachments', $file, $imageName);
        }


        $user = User::first();
        // Notification::send($user, new addInvoice($invoice_id));

        // $user = User::get();
        $invoices = invoices::latest()->first();
        Notification::send($user, new \App\Notifications\AddInvoiceDatabase($invoices));

        // event(new MyEventClass('hello world'));

        session()->flash('invoice_added');
        return redirect('/invoices');

        // session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        // return redirect('/invoices')->with('success', 'تم  اضافة الفاتوره بنجاح');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.status_update', compact('invoices'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoices = invoices::where('id', $id)->first();
        $sections = sections::all();
        return view('invoices.edit_invoice', compact('sections', 'invoices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $invoices = invoices::findOrFail($request->invoice_id);
        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // return dd($request);
        // return $id = $request->invoice_id;
        $invoice = invoices::find($request->invoice_id);
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
        return redirect('/invoices');
    }
    public function archiveInvoice(Request $request)
    {

        $invoice = invoices::find($request->invoice_id);

        $invoice->Delete();
        session()->flash('archive_invoice');
        return redirect('/invoices');
    }

    public function getProducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("product_name", "id");
        return json_encode($products);
    }
    public function Status_show($id)
    {
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.status_update', compact('invoices'));
    }
    public function Status_Update($id, Request $request)
    {
        $invoices = invoices::findOrFail($id);

        if ($request->Status === 'مدفوعة') {

            $invoices->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        } else {
            $invoices->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update');
        return redirect('/invoices');

    }

    public function invoices_paid()
    {
        $invoices = invoices::where('Value_Status', 1)->get();
        return view('invoices.invoices_paid', compact('invoices'));
    }
    public function invoices_unpaid()
    {
        $invoices = invoices::where('Value_Status', 2)->get();
        return view('invoices.invoices_unpaid', compact('invoices'));
    }
    public function invoices_partiallyPaid()
    {
        $invoices = invoices::where('Value_Status', 3)->get();
        return view('invoices.invoices_Partial', compact('invoices'));
    }

    public function Print_invoice($id)
    {
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.Print_invoice', compact('invoices'));
    }

    public function export()
    {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }
}

