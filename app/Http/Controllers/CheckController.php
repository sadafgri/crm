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
        return view('check.checksData', ['factors' => $factors]);
    }

    public function create()
    {
        $orders = Order::where('status','=','enable')->get();
        return view('check.addCheck', ['orders' => $orders]);
    }

    public function store(Request $request)
    {
        $order = Order::where('id', $request->input('order_id'))->first();
        $existingFactor = Factor::where('order_id', $request->input( 'order_id'))->first();
        if (!$order){  return back()->withErrors(['order_id' => 'The order does not exist.']);}
        if ($existingFactor) { return back()->withErrors(['order_id' => 'A factor for this order already exists.']);}
                 Factor::create([
                'title'=>$request->order_id,
                'total_price'=>$request->total_pay,
                'order_id'=>$order->id,
            ]);
        return redirect()->route('checks.index');
    }

    public function edit($id)
    {
        $products = Product::where('status','=','enable')->get();
        $orders = Order::where('status','=','enable')->get();
        $factors = Factor::where('id',$id)->first();
        return view('check.editCheckMenue',['factors' => $factors,'products' => $products ,'orders' => $orders]);
    }

    public function update(Request $request, $id)
    {
        $order = Order::where('id', $request->input('order_id'))->first();

        Factor::where('id',$id)->update([
            'title'=>$request->order_id,
            'total_price'=>$request->total_pay,
            'order_id'=>$order->id,
        ]);


        return redirect()->route('checks.index');
    }

    public function destroy($id)
    {
        $factor = Factor::find($id);
        if ($factor) {
            $factor->delete();
        }
        return redirect()->route('checks.index');
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
        return view('check.checksData', ['factors' => $factorsResults]);
    }
}
