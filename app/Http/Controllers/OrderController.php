<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeOrderRequest;
use App\Http\Requests\updateOrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == "customer") {
            $orders = auth()->user()->orders()->orderBy('id')->where('status', '=', 'enable')->get();
            return view('orders.ordersData', ['orders' => $orders]);
        } else {
            $orders = Order::OrderBy('id')->where('status', '=', 'enable')->get();
            return view('orders.ordersData', ['orders' => $orders]);
        }
    }

    public function create()
    {
        $products = Product::where('status', '=', 'enable')->get();
        $users = User::where('status', '=', 'enable')->get();
        return view('orders.addOrder', ['users' => $users, 'products' => $products]);
    }

    public function store(storeOrderRequest $request)
    {
        $products = Product::where('status', 'enable')->get();
        $total_price = 0;
        foreach ($products as $product) {
            $product_name = 'product_' . $product->id;
            $total_price += ($product->price) * ($request->$product_name);
        }
        Order::create([
            'user_id' => $request->customer_id,
            'title' => $request->order_name,
            'total_price' => $total_price,
        ]);
        $order_id = Order::orderBy('id', 'desc')->first();
        foreach ($products as $product) {
            $product_name = 'product_' . $product->id;
            if ($request->$product_name) {
                $product->orders()->attach($order_id, [
                    'count' => $request->$product_name,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                Product::where('id', $product->id)->update([
                    'inventory' => ($product->inventory) - ($request->$product_name),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
        return redirect()->route('orders.index');
    }

    public function edit($id)
    {
        $products = Product::where('status', '=', 'enable')->get();
        $users = User::where('status', '=', 'enable')->get();
        $order = Order::where('id', $id)->first();
        return view('orders.editOrderMenue', ['users' => $users, 'order' => $order, 'products' => $products]);
    }

    public function update(updateOrderRequest $request, $id)
    {
        $order = Order::where('id', $id)->first();
        $products = Product::where('status', 'enable')->get();
        $total_price = 0;
        foreach ($products as $product) {

            $count1 = $product->orders->where('id', $id)->first();

            if ($count1)
                $count = $count1->pivot->count;
            else
                $count = 0;
            $product_name = 'product_' . $product->id;
            $total_price += ($product->price) * ($request->$product_name);
            $newinventory = $product->inventory + $count - $request->$product_name;

            Product::where('id', $product->id)->update([
                'inventory' => $newinventory,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
        Order::where('id', $id)->update([
            'user_id' => $request->customer_id,
            'total_price' => $total_price,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $order->products()->detach();
        foreach ($products as $product) {
            $product_name = 'product_' . $product->id;
            if ($request->$product_name) {
                $product->orders()->save($order, [
                    'count' => $request->$product_name,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
        return redirect()->route('orders.index');
    }

    public function destroy($id)
    {
        Order::where('id', $id)->update(['status' => 'disable']);
        return back();
    }

    public function filter(Request $request)
    {
        $query = Order::query();
        if ($request->filled('filterordername')) {
            $query->where('title', 'like', '%' . $request->filterordername . '%');
            dd($query->get());
        }
        if ($request->filtername) {
            $user_id = User::where('first_name',$request->filtername)->first()->id ;
            $query->where('user_id', $user_id);
        }
        if ($request->filled('filtertotalpriceMin') && $request->filled('filtertotalpriceMax')) {
            $query->whereBetween('total_price', [$request->filtertotalpriceMin, $request->filtertotalpriceMax]);
        }
        $ordersResults = $query->get();

        return view('orders.ordersData', ['orders' => $ordersResults]);
    }
}
