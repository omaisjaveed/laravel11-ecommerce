<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Transaction;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth; // Add this line

class CartController extends Controller
{
    public function index(){
        $items = Cart::instance('cart')->content();
        return view('cart', compact('items'));
    }

    public function add_to_cart(Request $request){
        Cart::instance('cart')->add($request->id, $request->name, $request->quantity, $request->price)->associate('App\Models\Product');
        return redirect()->back();
    }

    public function increase_cart_quantity($rowId){
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId,$qty);
        return redirect()->back();
    }

    public function decrease_cart_quantity($rowId){
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        Cart::instance('cart')->update($rowId,$qty);
        return redirect()->back();
    }

    public function remove_item($rowId){
        Cart::instance('cart')->remove($rowId);
        return redirect()->back();
    }

    public function empty_cart(){
        Cart::instance('cart')->destroy();
        return redirect()->back();
    }

    public function apply_coupon_code(Request $request){
        $coupon_code = $request->coupon_code;

        if(isset($coupon_code)){

            $coupon = Coupon::where('code',$coupon_code)->where('expiry_date','>=', Carbon::today())->first();
            if(!$coupon){
                return redirect()->back()->with('error','Invalid Coupon Code');
            }
            else{
                Session::put('coupon',[
                    'code' => $coupon->code,
                    'type' => $coupon->type,
                    'value' => $coupon->value,
                    'cart_value' => $coupon->cart_value,
                ]);
                $this->calculate_discount();
                return redirect()->back()->with('success','Coupon has been Applied');
            }
        }
        else{
            return redirect()->back()->with('error','Invalid Coupon Code');
        }
    }


    public function calculate_discount(){
        $discount = 0; 
        if(Session::has('coupon')){
            if(Session::get('coupon')['type'] == 'fixed'){
                $discount = Session::get('coupon')['value'];
            }
            else{
                $discount = Cart::instance('cart')->subtotal() * (Session::get('coupon')['value']/100);
            }
            $subtotalAfterDiscount = Cart::instance('cart')->subtotal() - $discount;
            $taxAfterDiscount = ($subtotalAfterDiscount * config('cart.tax')) / 100;
            $totaltaxAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;

            Session::put('discounts',[
                'discount' => number_format(floatval($discount),2,'.',''),
                'subtotal' => number_format(floatval($subtotalAfterDiscount),2,'.',''),
                'tax' => number_format(floatval($taxAfterDiscount),2,'.',''),
                'total' => number_format(floatval($totaltaxAfterDiscount),2,'.',''),
            ]);
        }
    }

    public function remove_coupon_code(){
        Session::forget('coupon');
        Session::forget('discounts');
        return redirect()->back()->with('success','Coupon Has been Removed');
    }

    public function checkout(){
        if(!Auth::check()){
            return redirect('login');
        }
        $address = Address::where('user_id', Auth::user()->id)->where('isdefault', 1)->first();
        return view('checkout',compact('address'));  
    }

    public function place_an_order(Request $request){
        $user_id = Auth::user()->id;
        $address = Address::where('user_id',$user_id)->where('isdefault',true)->first();

        // if(!$address){
            $request->validate([
                'name' => 'required',
                'phone' => 'required|numeric|digits:10',
                'zip' => 'required|numeric|digits:6',
                'state' => 'required',
                'city' => 'required',
                'address' => 'required',
                'locality' => 'required',
                'landmark' => 'required',
            ]);

            $address = new Address();
            $address->name = $request->name;
            $address->phone = $request->phone;
            $address->zip = $request->zip;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->address = $request->address;
            $address->locality = $request->locality;
            $address->landmark = $request->landmark;
            $address->country = 'PAKISTAN';
            $address->user_id = $user_id;
            $address->isdefault = true;
            $address->save();

            // return redirect()->back()->with('success','Coupon Has been Removed');

        // }

        $this->setAmountforCheckout();
        $order = new Order();



        $order->user_id = $user_id;
        $order->subtotal = Session::get('checkout')['subtotal'];
        $order->discount = Session::get('checkout')['discount'];
        $order->tax = Session::get('checkout')['tax'];
        $order->total = Session::get('checkout')['total'];
        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->locality = $request->locality;
        $order->address = $request->address;
        $order->city = $request->city;
        $order->state = $request->state;
        $order->country = $request->country;
        $order->landmark = $request->landmark;
        $order->zip = $request->zip;
        $order->type = $request->type;
        $order->status = $request->status;
        $order->is_shipping_different = $request->is_shipping_different;
        $order->delivered_date = $request->delivered_date;
        $order->canceled_date = $request->canceled_date;
        $order->save();

        // foreach(Cart::instance('cart')->content() as $item){
        //     $orderItem = new OrderItem;
        //     $orderItem->product_id = $item->id;
        //     $orderItem->order_id = $order->id;
        //     $orderItem->price = $item->price;
        //     $orderItem->quantity = $item->qty;
        //     $orderItem->save();
        // }

        // if($request->mod == 'card'){
        // }
        // else if($request->mod == 'paypal'){

        // }
        // if($request->mod == 'cod'){

        //     $transaction = new Transaction();
        //     $transaction->user_id = $user_id;
        //     $transaction->order_id = $order_id;
        //     $transaction->mode = $request->mode;
        //     $transaction->status = "pending";
        //     $transaction->save();
        // }

        // Cart::instance('cart')->destroy();
        // Session::forget('checkout');
        // Session::forget('discounts');
        // Session::forget('coupon');
        // Session::put('order_id',$order_id);
        // return redirect()->route('order.confirmation');
    }


    public function setAmountforCheckout(){
        if(!Cart::instance('cart')->content()->count() > 0){
            Session::forget('checkout');
            return;
        }

        if(Session::has('coupon')){
            Session::put('checkout', [
                'discount' => Session::get('discounts')['discount'],
                'subtotal' => Session::get('discounts')['subtotal'],
                'tax' => Session::get('discounts')['tax'],
                'total' => Session::get('discounts')['total'],
            ]);
        }
        else{
            Session::put('checkout', [
                'discount' => 0,
                'subtotal' => Cart::instance('cart')->subtotal(),
                'tax' => Cart::instance('cart')->tax(),
                'total' => Cart::instance('cart')->total(),
            ]);
        }
    }

    public function order_confirmation(){
        if(Session::has('order_id')){
            $order = Order::find(Session::get('order_id'));
            return view('order-confirmation', compact('order'));
        }
        return redirect()->route('cart.index');
    }
}
