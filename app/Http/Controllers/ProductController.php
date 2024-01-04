<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeProductRequest;
use App\Http\Requests\updateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function create()
    {
        return view('products.addProduct');
    }

    public function index()
    {
     $products = Product::all();
        return view("products.productsData",['products'=>$products]);
}
    public function store(storeProductRequest $request)
    {
        Product::create([
            'titel'=>$request->product_name,
            'price'=>$request->price,
            'inventory'=>$request->amount_available,
            'description'=>$request->explanation,
            'created_at'=>date('Y_m_d_H:i:s'),
        ]);
        return redirect()->route('products.index');
    }

    public function edit($id)
    {
        $products = Product::find($id);
        return view("products.editProductMenue",['products'=>$products]);
    }

    public function update(updateProductRequest $request,$id)
    {
        Product::where('id',$id)->update([
            'titel'=>$request->product_name,
            'price'=>$request->price,
            'inventory'=>$request->amount_available,
            'description'=>$request->explanation,
            ]);
        return redirect()->route('products.index');
    }
    public function destroy($id)
    {
         Product::where('id',$id)->update(['status'=>'disable']);
        return back();
    }

    public function filter(Request $request)
    {
        $products = Product::query();
        if ($request->filtername) {
            $products->where('titel', $request->filtername);
        }
        if ($request->filterpriceMin && $request->filterpriceMax) {
            $products ->whereBetween('price', [$request->filterpriceMin, $request->filterpriceMax]);
        }
        if ($request->filtermojodiMin && $request->filtermojodiMax) {
            $products ->whereBetween('inventory', [$request->filtermojodiMin, $request->filtermojodiMax]);
        }
        $productResults = $products->get();
        return view("products.productsData",['products'=>$productResults]);
    }
}
