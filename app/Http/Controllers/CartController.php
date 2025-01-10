<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use Carbon\Carbon;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;

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
                return redirect()->back()->with('success','Coupon Code Applied');
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
            $subtotalAfterDiscount = Cart::instance('cart')::
        }
    }
}
