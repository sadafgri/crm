<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeProductRequest;
use App\Http\Requests\updateProductRequest;
use App\Models\Product;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
//    public function create()
//    {
//        return view('products.addProduct');
//    }

    public function index()
    {
     $products = Product::all();
        return response()->json([
            'status' => true,
            'message' => 'Products retrieved successfully',
            'data' => $products
        ]);
    }
    public function store(storeProductRequest $request)
    {
       $product = Product::create([
            'titel'=>$request->product_name,
            'price'=>$request->price,
            'inventory'=>$request->amount_available,
            'description'=>$request->explanation,
            'created_at'=>date('Y_m_d_H:i:s'),
        ]);
        return response()->json([
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

//    public function edit($id)
//    {
//        $products = Product::find($id);
//        if (!$products) {
//            return response()->json([
//                'status' => false,
//                'message' => 'Product not found'
//            ], 404);
//        }
//        // Return the product as JSON
//        return response()->json([
//            'status' => true,
//            'message' => 'Product retrieved successfully',
//            'data' => $products
//        ]);
//    }

    public function update(updateProductRequest $request,$id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ], 404);
        }
        Product::where('id',$id)->update([
            'titel'=>$request->product_name,
            'price'=>$request->price,
            'inventory'=>$request->amount_available,
            'description'=>$request->explanation,
            ]);
        return response()->json([
            'status' => true,
            'message' => 'Product updated successfully',
            'data' => Product::find($id)
        ], 200);
    }
    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ], 404);
        }
        Product::where('id',$id)->update(['status'=>'disable']);
        return response()->json([
            'status' => true,
            'message' => 'Product delete successfully'
        ], 200);
    }

    public function filter(Request $request)
    {
        $minPriceFilter = AllowedFilter::callback('priceMin', function ($query, $value) {
            $query->where('price', '>=', $value);
        });
        $maxPriceFilter = AllowedFilter::callback('priceMax', function ($query, $value) {
            $query->where('price', '<=', $value);
        });

        $mininventoryFilter = AllowedFilter::callback('mojodiMin', function ($query, $value) {
            $query->where('inventory', '>=', $value);
        });
        $maxinventoryFilter = AllowedFilter::callback('mojodiMax', function ($query, $value) {
            $query->where('inventory', '<=', $value);
        });


        $products = QueryBuilder::for(Product::class)
          ->allowedFilters([
              $mininventoryFilter, $maxinventoryFilter,
              $minPriceFilter , $maxPriceFilter ,
           AllowedFilter::exact('titel')->ignore(null),
       ])->get();
        return response()->json([
            'status' => true,
            'message' => 'Products filtered successfully',
            'data' => $products
        ]);
    }
}
