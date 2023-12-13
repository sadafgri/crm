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
       $orders=Order::OrderBy('id')->where('status','=','enable')->get();
//        $orders=DB::table('order_products')
//            ->join('products' , 'order_products.product_id' , '=' , 'products.id')
//            ->join('orders' , 'order_products.order_id' , '=' , 'orders.id')
//            ->join('users' , 'orders.user_id' , '=' , 'users.id')
//            ->select('orders.id','orders.title','orders.total_price','order_products.count','orders.user_id', 'users.first_name','users.last_name','users.email','products.titel','products.price')
//            ->where([
//                ['orders.status' , '=' , 'enable'],
//                ['products.status' , '=' , 'enable'],
//                ['users.status' , '=' , 'enable'],
//            ])
//            ->get();
        return view('orders.ordersData' , ['orders' => $orders]);
    }
    public function create()
    {
      $products = Product::where('status','=','enable')->get();
      $users = User::where('status','=','enable')->get();
        return view('orders.addOrder',['users'=>$users , 'products'=>$products]);
    }

    public function store(storeOrderRequest $request)
    {
//        $product=DB::table('products')->find($request->product_id);
        $products=Product::where('status','enable')->get();
        $total_price=0;
        foreach ($products as $product)
        {
            $product_name='product_'.$product->id;
            $total_price+=($product->price)*($request->$product_name);
        }
        Order::create([
            'user_id'=>$request->customer_id,
            'title'=>$request->order_name,
            'total_price'=>$total_price,
//           'created_at'=>date('Y-m-d H:i:s'),
        ]);
        $order_id=Order::orderBy('id','desc')->first();
        foreach($products as $product)
        {
            $product_name='product_'.$product->id;
            if($request->$product_name)
            {
                $product->orders()->attach($order_id,[
                    'count'=>$request->$product_name,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
//                DB::table('order_product')->insert([
//                    'order_id'=>$order_id,
//                    'product_id'=>$product->id,
//                    'count'=>$request->$product_name,
//                    'created_at'=>date('Y-m-d H:i:s'),
//                ]);
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
        $products = Product::where('status','=','enable')->get();
        $users = User::where('status','=','enable')->get();
        $order = Order::where('id',$id)->first();
        return view('orders.editOrderMenue',['users'=>$users,'order'=>$order,'products'=>$products]);
    }
    public function update(updateOrderRequest $request,$id)
    {
        $order=Order::where('id',$id)->first();
        $products=Product::where('status','enable')->get();
        $total_price=0;
        foreach ($products as $product)
        {
//            $count1=DB::table('order_product')
//                ->join('products','products.id','=','order_product.product_id')
//                ->where('order_product.order_id',$id)
//                ->where('products.id',$product->id)
//                ->first();
            $count1=$product->orders->where('id',$id)->first();
//dd($count1);
            if($count1)
                $count=$count1->pivot->count;
            else
                $count=0;
            $product_name='product_'.$product->id;
            $newinventory = $product->inventory + $count - $request->$product_name ;

            $total_price+=($product->price)*($request->$product_name);

            Product::where('id', $product->id)->update([
                'inventory' => $newinventory,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
        Order::where('id',$id)->update([
            'user_id'=>$request->customer_id,
            'total_price'=>$total_price,
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
//        foreach($order->products as $order_product)
//        {
//            $order_product->pivot->delete();
//        }
        $order->products()->detach();
//        DB::table('order_product')
//            ->where('order_id',$id)
//            ->delete();
        foreach($products as $product)
        {
            $product_name='product_'.$product->id;
            if($request->$product_name)
            {
//                DB::table('order_product')->insert([
//                    'order_id'=>$id,
//                    'product_id'=>$product->id,
//                    'count'=>$request->$product_name,
//                    'updated_at'=>date('Y-m-d H:i:s'),
//                ]);
                $product->orders()->save($order,[
                    'count'=>$request->$product_name,
                    'updated_at'=>date('Y-m-d H:i:s'),
                ]);
            }
        }
        return redirect()->route('orders.index');
    }

public function destroy($id)
    {
        Order::where('id',$id)->update(['status'=>'disable']);
        return back();
      }
}
