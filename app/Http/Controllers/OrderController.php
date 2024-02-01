<?php

namespace App\Http\Controllers;

use App\Events\OrderEmail;
use App\Http\Requests\storeOrderRequest;
use App\Http\Requests\updateOrderRequest;
use App\Mail\MailNotify;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;


class OrderController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == "customer") {
            $orders = auth()->user()->orders()->orderBy('id')->where('status', '=', 'enable')->get();
        } else {
            $orders = Order::OrderBy('id')->where('status', '=', 'enable')->get();
        }
        return response()->json([
            'status' => true,
            'orders' => $orders
        ]);
    }

//    public function create()
//    {
//        $products = Product::where('status', '=', 'enable')->get();
//        $users = User::where('status', '=', 'enable')->get();
//
//        return response()->json([
//            'products' => $products,
//            'users' => $users
//        ]);
//    }

    public function store(storeOrderRequest $request)
    {
        $total_price = 0;

        foreach ($request->products as $product) {
            $price = Product::find($product['product_id'])->price;
            $total_price += $price * $product['count'];
        }
        $orders = Order::create([
            'user_id' => $request->customer_id,
            'title' => $request->order_name,
            'total_price' => $total_price,
        ]);
        foreach ($request->products as $product){
            $orders->products()->attach($product['product_id'],['count'=>$product['count']]);
            $productModel = Product::find($product['product_id']);
            $newInventory = $productModel->inventory - $product['count'];
            $productModel->update(['inventory' => $newInventory]);
        }
        OrderEmail::dispatch($orders);
//        event(new OrderEmail($orders));

        return response()->json([
            'status' => true,
            'orders' => $orders
        ]);
    }

//    public function edit($id)
//    {
//        $products = Product::where('status', '=', 'enable')->get();
//        $users = User::where('status', '=', 'enable')->get();
//        $order = Order::where('id', $id)->first();
//        if (!$order) {
//            return response()->json([
//                'status' => false,
//                'message' => 'Order not found'
//            ], 404);
//        }

//        return response()->json([
//            'status' => true,
//            'order' => $order,
//            'users' => $users,
//            'products' => $products
//        ]);
//    }

    public function update(updateOrderRequest $request, $id)
    {
        $total_price = 0;
        foreach ($request->products as $product) {
            $productModel = Product::find($product['product_id']);
            $count = $product['count'];
            $price = $productModel->price;
            $total_price += $price * $count;

            $newInventory = $productModel->inventory - $count;
            $productModel->update(['inventory' => $newInventory]);

            $order = Order::find($id);
            $order->products()->syncWithoutDetaching([$product['product_id']=>['count'=>$product['count']]]);
        }
        Order::where('id', $id)->update([
            'user_id' => $request->customer_id,
            'title'=>$request->order_name,
            'total_price' => $total_price,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        return response()->json([
            'status' => true,
            'message' => 'order updated successfully',
            'order' => Order::find($id),
        ], 200);
    }
    public function destroy($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'order not found'
            ], 404);
        }
        Order::where('id',$id)->update(['status' => 'disable']);
        return response()->json([
            'status' => true,
            'message' => 'order delete successfully'
        ], 200);
    }

    public function filter(Request $request)
    {
        $query = Order::query();
        if ($request->filled('filterordername')) {
            $query->where('title', 'like', '%' . $request->filterordername . '%');
        }
        if ($request->filtername) {
            $user_id = User::where('first_name', $request->filtername)->first()->id;
            $query->where('user_id', $user_id);
        }
        if ($request->filled('filtertotalpriceMin') && $request->filled('filtertotalpriceMax')) {
            $query->whereBetween('total_price', [$request->filtertotalpriceMin, $request->filtertotalpriceMax]);
        }
        $ordersResults = $query->get();

        return response()->json([
            'status' => true,
            'message' => 'orders filtered successfully',
            'data' => $ordersResults
        ]);
    }
}
