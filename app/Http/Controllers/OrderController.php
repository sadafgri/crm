<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders=DB::table('order_products')
            ->join('products' , 'order_products.product_id' , '=' , 'products.id')
            ->join('orders' , 'order_products.order_id' , '=' , 'orders.id')
            ->join('users' , 'orders.user_id' , '=' , 'users.id')
            ->select('orders.id','orders.title','orders.total_price','order_products.count','orders.user_id', 'users.first_name','users.last_name','users.email','products.titel','products.price')
            ->where([
                ['orders.status' , '=' , 'enable'],
                ['products.status' , '=' , 'enable'],
                ['users.status' , '=' , 'enable'],
            ])
            ->get();

        return view('orders.ordersData' , ['orders' => $orders]);
    }
    public function create()
    {
      $products =  DB::table('products')->where('status','=','enable')->get();
      $users =  DB::table('users')->where('status','=','enable')->get();
        return view('orders.addOrder',['users'=>$users , 'products'=>$products]);
    }

    public function store(Request $request)
    {
        $products =  DB::table('products')->where('status','=','enable')->get();
        $data = $request->all();
        $total_price=0;
        foreach ($products as $product){
            foreach ($data as $key=>$value){
                if ($product->id==$key){
                    $price = $product->price;
                    $count =  $request->$key;
                    $sum = $price * $count;
                    $total_price+=$sum;
                }
            }
        }
        DB::table('orders')->insert([
            'user_id'=>$request->customer_id,
            'title'=>$request->order_name,
            'total_price'=>$total_price,
            'created_at'=>date('Y_m_d_H:i:s'),
        ]);

        $order_id = DB::getPdo()->lastInsertId();
        foreach($products as $product) {
            foreach ($data as $key=>$value)
                if ($product->id == $key) {
                    DB::table('order_products')->insert([
                        'order_id' => $order_id,
                        'product_id' => $product->id,
                        'count' => $request->$key,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
                }
        }
        return redirect()->route('orders.index');
    }
    public function edit($id)
    {
        $products =  DB::table('products')->where('status','=','enable')->get();
        $users =  DB::table('users')->where('status','=','enable')->get();
        $order =  DB::table('orders')->where('id',$id)->first();
        $order_products = DB::table('order_products')->join('products','products.id','=','order_products.product_id')->where('order_products.order_id',$order->id)->get();
        return view('orders.editOrderMenue',['users'=>$users,'order'=>$order,'products'=>$products,'order_products'=>$order_products]);
    }
    public function update(Request $request,$id)
    {
        DB::table('order_products')->where('order_id', $id) ->delete();
        $data = $request->all();
        $products=DB::table('products')->where('status','=','enable')->get();

        $total_price=0;
        foreach ($products as $product){
            foreach ($data as $key=>$value){
                if ($product->id==$key){
                    $price = $product->price;
                    $count =  $request->$key;
                    $sum = $price * $count;
                    $total_price += $sum;
                }
            }
        }
        DB::table('orders')->where('id',$id)->update([
             'total_price'=>$total_price,
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
        DB::table('order_products')->where('id',$id)->delete();
                foreach ($products as $product){
                    foreach ($data as $key=>$value){
                        if ($product->id==$key){
                            $count =  $request->$key;
                            if ($count >0){
                                DB::table('order_products')->insert([
                                    'order_id' => $id,
                                    'product_id' => $product->id,
                                    'count' => $count,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ]);
                            }
                        }
                    }
                }
        return redirect()->route('orders.index');
            }
    public function destroy($id)
    {
        DB::table('orders')->where('id',$id)->update(['status'=>'disable']);
        return back();
      }
}
