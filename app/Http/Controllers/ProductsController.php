<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = sections::all();
        $products = products::all();
        return view('products.products', compact('products', 'sections'));
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
        $validatedData = $request->validate([
            'product_name' => [
                'required',
                'max:255',
                Rule::unique('products')->where(function ($query) use ($request) {
                    return $query->where('section_id', $request->section_id);
                }),
            ],
            'section_id' => 'required',
        ], [
            'product_name.required' => 'يرجي ادخال اسم المنتج',
            'product_name.unique' => 'اسم المنتج مسجل مسبقا',
        ]);
        $section = sections::where('id', $request->section_id)->first();

        if ($section) {
            $section_name = $section->section_name;
        } else {
            return redirect('/products')->with('error', 'Section not found');
        }
        Products::create([
            'product_name' => $request->product_name,
            'section_id' => $request->section_id,
            'description' => $request->description,
            'section_name' => $section_name,
        ]);
        session()->flash('Add', 'تم اضافة المنتج بنجاح');
        return redirect('/products')->with('success', 'تم اضافة المنتج بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = sections::where('section_name', $request->section_name)->first()->id;

        $Products = Products::findOrFail($request->pro_id);

        $Products->update([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $id,
        ]);

        session()->flash('edit', 'تم تعديل المنتج بنجاج');
        return redirect('/products')->with('success', 'تم تعديل المنتج بنجاح');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $Products = Products::findOrFail($request->pro_id);
        $Products->delete();
        session()->flash('delete', 'تم حذف المنتج بنجاح');
        return redirect('/products')->with('success', 'تم حذف المنتج بنجاح');

    }
}
