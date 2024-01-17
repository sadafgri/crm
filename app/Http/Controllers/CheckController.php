<?php

namespace App\Http\Controllers;

use App\Models\Factor;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    public function index()
    {
        $factors = Factor::all();
        return response()->json([
            'status' => true,
            'message' => 'factors retrieved successfully',
            'data' => $factors
        ]);
    }

//    public function create()
//    {
//        $orders = Order::where('status','=','enable')->get();
//        return response()->json([
//            'status' => true,
//            'data' => $orders
//        ]);
//    }

    public function store(Request $request)
    {
        $order = Order::where('id', $request->input('order_id'))->first();
        $existingFactor = Factor::where('order_id', $request->input( 'order_id'))->first();
        if (!$order){  return response()->json(['order_id' => 'The order does not exist.']);}
        if ($existingFactor) { return response()->json(['order_id' => 'A factor for this order already exists.']);}
               $factor = Factor::create([
                'title'=>$request->order_id,
                'total_price'=>$request->total_pay,
                'order_id'=>$order->id,
            ]);
        return response()->json([
            'status' => true,
            'message' => 'factors retrieved successfully',
            'data' => $factor
        ]);
    }

//    public function edit($id)
//    {
//        $products = Product::where('status','=','enable')->get();
//        $orders = Order::where('status','=','enable')->get();
//        $factors = Factor::where('id',$id)->first();
//        if (!$factors) {
//            return response()->json([
//                'status' => false,
//                'message' => 'factor not found'
//            ], 404);
//        }
//        return response()->json([
//            'status' => true,
//            'message' => 'factor retrieved successfully',
//            'factors' => $factors
//        ]);
//    }

    public function update(Request $request, $id)
    {
        $order = Order::where('id', $request->input('order_id'))->first();

        Factor::where('id',$id)->update([
            'title'=>$request->order_id,
            'total_price'=>$request->total_pay,
            'order_id'=>$order->id,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'factor retrieved successfully',
            'data' => Factor::find($id)
        ]);    }

    public function destroy($id)
    {
        $factor = Factor::find($id);
        if (!$factor) {
            return response()->json([
                'status' => false,
                'message' => 'factor not found'
            ], 404);
        }
        Factor::where('id',$id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'factor delete successfully'
        ], 200);
    }

    public function filter(Request $request)
    {
        $factor = Factor::query();
        if($request->filterOrderId){
            $factor->where('order_id',$request->filterOrderId);
        }
        if ($request->filled('filterOrderTotalPriceMin') && $request->filled('filterOrderTotalPriceMax')) {
            $factor->whereBetween('total_price', [$request->filterOrderTotalPriceMin, $request->filterOrderTotalPriceMax]);
        }
        if ($request->filterUserName ) {
            $order_id = User::where('user_name',$request->filterUserName)->first()->id ;
            $factor->where('order_id', $order_id);
        }
//        if ($request->filterProductName) {
//            $product_id = Product::where('titel', $request->filterProductName)->first()->id;
//            $order = Order::where('order_id', $product_id)->get();
//        }
        $factorsResults = $factor->get();
        return response()->json([
            'status' => true,
            'message' => 'factor filtered successfully',
            'data' => $factorsResults
        ]);
    }
}
