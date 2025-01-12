@extends('layouts.app')

@section('content')


<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
      <h2 class="page-title">Shipping and Checkout</h2>
      <div class="checkout-steps">
        <a href="{{route('cart.index')}}" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">01</span>
          <span class="checkout-steps__item-title">
            <span>Shopping Bag</span>
            <em>Manage Your Items List</em>
          </span>
        </a>
        <a href="javascript:void(0)" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">02</span>
          <span class="checkout-steps__item-title">
            <span>Shipping and Checkout</span>
            <em>Checkout Your Items List</em>
          </span>
        </a>
        <a href="order-confirmation.html" class="checkout-steps__item">
          <span class="checkout-steps__item-number">03</span>
          <span class="checkout-steps__item-title">
            <span>Confirmation</span>
            <em>Review And Submit Your Order</em>
          </span>
        </a>
      </div>
      <form name="checkout-form" action="{{route('cart.place.an.order')}}" method="POST">
        @csrf
        <div class="checkout-form">
          <div class="billing-info__wrapper">
            <div class="row">
              <div class="col-6">
                <h4>SHIPPING DETAILS</h4>
              </div>
              <div class="col-6">
              </div>
            </div>

            {{-- @if($address)

                <div class="row">
                    <div class="col-md-12">
                        <div class="my-account__address-list">
                            <div class="my-account__address-item__detail">
                                <div> {{ $address->name }} </div>
                                <div> {{ $address->address }} </div>
                                <div> {{ $address->lankmark }} </div>
                                <div> {{ $address->city }} , {{ $address->state }} , {{ $address->country }} </div>
                                <div> {{ $address->zip }} </div>
                                <br>
                                <div> {{ $address->phone }} </div>
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
  
            @else --}}
                <div class="row mt-5">
                <div class="col-md-6">
                    <div class="form-floating my-3">
                    <input type="text" class="form-control" name="name" value="{{old('name')}}" required="">
                    <label for="name">Full Name *</label>
                    @error('name')
                    <span class="text-danger">{{$message}}</span>
                    @enderror



                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating my-3">
                    <input type="text" class="form-control" name="phone" value="{{old('phone')}}" required="">
                    <label for="phone">Phone Number *</label>
                    @error('phone')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating my-3">
                    <input type="text" class="form-control" name="zip" value="{{old('zip')}}" required="">
                    <label for="zip">Pincode *</label>
                    <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mt-3 mb-3">
                    <input type="text" class="form-control" name="state" required="">
                    <label for="state">State *</label>
                    <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating my-3">
                    <input type="text" class="form-control" name="city" value="{{old('city')}}" required="">
                    <label for="city">Town / City *</label>
                    <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating my-3">
                    <input type="text" class="form-control" name="address" value="{{old('address')}}" required="">
                    <label for="address">House no, Building Name *</label>
                    <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating my-3">
                    <input type="text" class="form-control" name="locality" value="{{old('locality')}}" required="">
                    <label for="locality">Road Name, Area, Colony *</label>
                    <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating my-3">
                    <input type="text" class="form-control" name="landmark" value="{{old('landmark')}}" required="">
                    <label for="landmark">Landmark *</label>
                    <span class="text-danger"></span>
                    </div>
                </div>
                </div>

            {{-- @endif --}}

          </div>
          <div class="checkout__totals-wrapper">
            <div class="sticky-content">
              <div class="checkout__totals">
                <h3>Your Order</h3>
                <table class="checkout-cart-items">
                  <thead>
                    <tr>
                      <th>PRODUCT</th>
                      <th align="right">SUBTOTAL</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach(Cart::instance('cart') as $item)
                    
                    <tr>
                      <td>
                       {{ $item->name }} x {{ $item->qty }}
                      </td>
                      <td align="right">
                        {{$item->subtotal()}}
                      </td>
                    </tr>




                    @endforeach

                  </tbody>
                </table>

                @if(Session::has('discounts'))

                    <table class="cart-totals">
                        <tbody>
                        <tr>
                            <th>Subtotal</th>
                            <td class="text-right">$ {{ Cart::instance('cart')->subtotal() }}</td>
                        </tr>
                        <tr>
                            <th>Discount {{ Session::get('coupon')['code'] }}</th>
                            <td class="text-right">$ {{ Session::get('discounts')['discount'] }}</td>
                        </tr>
                        <tr>
                            <th>Subtotal After Discount </th>
                            <td class="text-right">$ {{ Session::get('discounts')['subtotal'] }}</td>
                        </tr>
                        <tr>
                            <th>Shipping</th>
                            <td class="text-right">
                            Free
                            </td>
                        </tr>
                        <tr>
                            <th>VAT</th>
                            <td class="text-right">{{Session::get('discounts')['tax']}}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td class="text-right">{{ Session::get('discounts')['total'] }}</td>
                        </tr>
                        </tbody>
                    </table>

                @else

                    <table class="checkout-totals">
                    <tbody>
                        <tr>
                        <th>SUBTOTAL</th>
                        <td class="text-right">$ {{ Cart::instance('cart')->subtotal() }}</td>
                        </tr>
                        <tr>
                        <th>SHIPPING</th>
                        <td class="text-right">Free shipping</td>
                        </tr>
                        <tr>
                        <th>VAT</th>
                        <td class="text-right">${{ Cart::instance('cart')->tax() }}</td>
                        </tr>
                        <tr>
                        <th>TOTAL</th>
                        <td class="text-right">${{ Cart::instance('cart')->total() }}</td>
                        </tr>
                    </tbody>
                    </table>

                @endif



              </div>
              <div class="checkout__payment-methods">
                
                <div class="form-check">
                  <input class="form-check-input form-check-input_fill" type="radio" name="mode" value="card"
                    id="checkout_payment_method_2">
                  <label class="form-check-label" for="checkout_payment_method_2">
                    Credit or Debit Card
                  </label>
                </div>
                
                <div class="form-check">
                  <input class="form-check-input form-check-input_fill" type="radio" name="mode" value="cod"
                    id="checkout_payment_method_3">
                  <label class="form-check-label" for="checkout_payment_method_3">
                    Cash on delivery
                   
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input form-check-input_fill" type="radio" name="mode" value="paypal"
                    id="checkout_payment_method_4">
                  <label class="form-check-label" for="checkout_payment_method_4">
                    Paypal
                    
                  </label>
                </div>
                <div class="policy-text">
                  Your personal data will be used to process your order, support your experience throughout this
                  website, and for other purposes described in our <a href="terms.html" target="_blank">privacy
                    policy</a>.
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-checkout">PLACE ORDER</button>
            </div>
          </div>
        </div>
      </form>
    </section>
</main>


@endsection