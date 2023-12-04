<?php

namespace App\Http\Controllers;

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
        $products = DB::table('products')->get();
        return view("products.productsData",['products'=>$products]);
}
    public function store(Request $request)
    {
//        $request->validate([
//            'title'=>'required',
//            'price'=>'required',
//            'inventory'=>'required',
//            'description'=>'required',
//        ]);
        DB::table('products')->insert([
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
        $products = DB::table('products')->where('id',$id)->first();
        return view("products.editProductMenue",['products'=>$products]);
    }

    public function update(Request $request,$id)
    {
        $products = DB::table('products')->where('id',$id)->update([
            'titel'=>$request->product_name,
            'price'=>$request->price,
            'inventory'=>$request->amount_available,
            'description'=>$request->explanation,
            'update_at'=>date('Y_m_d_H:i:s'),
        ]);
        return redirect()->route('products.index');
    }
    public function destroy($id)
    {
        DB::table('products')->where('id',$id)->update(['status'=>'disable']);
        return back();
    }
}
