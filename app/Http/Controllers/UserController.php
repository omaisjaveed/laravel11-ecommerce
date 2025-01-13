<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\orderItems;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth; // Add this line

use Illuminate\Http\Request;

class UserController extends Controller
{
    function index(){
        return view('user.index');
    }

    function orders(){
        $order = Order::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate(10);
        return view('user.orders',compact('order'));
    }

    function orders_details($order_id){
        $order = Order::where('user_id', Auth::user()->id)->where('id',$order_id)->first();
        if($order){
            $orderItems = OrderItem::where('order_id', $order_id)->orderBy('id')->paginate(12);
            $transaction = Transaction::where('order_id', $order_id)->first();
            return view('user.order-details',compact('order', 'orderItems' , 'transaction'));
        }
        else{
            return redirect()->route('login');
        }
    }


    function cancel_order(Request $request){
        $order = Order::find($request->id);
        $order->status = 'canceled';
        $order->canceled_date = Carbon::now();

        $order->save();
        return back()->with('status'," order status has been Canceled");
    }


}
