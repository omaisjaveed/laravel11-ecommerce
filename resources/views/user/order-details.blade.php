@extends('layouts.app')

@section('content')
<main class="pt-90" style="padding-top: 0px;">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
      <h2 class="page-title">Order's Details</h2>
      <div class="row">
        <div class="col-lg-2">
          <ul class="account-nav">
            <li><a href="http://localhost:8000/account-dashboard" class="menu-link menu-link_us-s ">Dashboard</a></li>
            <li><a href="http://localhost:8000/account-orders" class="menu-link menu-link_us-s ">Orders</a></li>
            <li><a href="http://localhost:8000/account-addresses" class="menu-link menu-link_us-s ">Addresses</a></li>
            <li><a href="http://localhost:8000/account-details" class="menu-link menu-link_us-s ">Account Details</a>
            </li>
            <li><a href="http://localhost:8000/account-wishlists" class="menu-link menu-link_us-s ">Wishlist</a></li>
            <li>
              <form method="POST" action="http://localhost:8000/logout" id="logout-form-1">
                <input type="hidden" name="_token" value="3v611ELheIo6fqsgspMOk0eiSZjncEeubOwUa6YT" autocomplete="off">
                <a href="http://localhost:8000/logout" class="menu-link menu-link_us-s"
                  onclick="event.preventDefault(); document.getElementById('logout-form-1').submit();">Logout</a>
              </form>
            </li>
          </ul>
        </div>

        <div class="col-lg-10">

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                  
                    
                    <div class="row my-3">
                        <div class="col-md-6">
                            <h5>Ordered Details</h5>

                        </div>

                        <div class="col-md-6 text-right"> 

                            <a class="tf-button style-1 w208 btn btn-danger" href="{{route('user.orders')}}">Back</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Order No</th>
                            <td>{{$order->id}}</td>
                            <th>Mobile</th>
                            <td>{{$order->phone}}</td>
                            <th>Zip code</th>
                            <td>{{$order->zip}}</td>
                        </tr>
                        <tr>
                            <th>Order Date</th>
                            <td>{{$order->created_at}}</td>
                            <th>Delivered Date</th>
                            <td>{{$order->delivered_date}}</td>
                            <th>Canceled Date</th>
                            <td>{{$order->canceled_date}}</td>
                        </tr>
                        <tr>
                            <th>Order Status</th>
                            <td colspan="5">
                                @if($order->status == 'delivered')
                                    <span class="badge bg-success">Delivered</span>
                                @elseif($order->status == 'canceled')
                                    <span class="badge bg-danger">Canceled</span>
                                @else
                                    <span class="badge bg-success">Ordered</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
        
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
        
                </div>
            </div>
        
        
            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Ordered Items</h5>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">SKU</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Brand</th>
                                <th class="text-center">Options</th>
                                <th class="text-center">Return Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
        
                            @foreach($orderItems as $item)
                            <tr>
        
                                <td class="pname">
                                    <div class="image">
                                        <img src="{{asset('uploads/products')}}/{{$item->product->image}}" alt="" class="image">
                                    </div>
                                    <div class="name">
                                        <a href="{{ route('shop.product.details', ['product_slug' => $item->product->slug]) }}" target="_blank"
                                            class="body-title-2">{{$item->product->name}}</a>
                                    </div>
                                </td>
                                <td class="text-center">{{$item->price }}</td>
                                <td class="text-center">{{$item->quantity }}</td>
                                <td class="text-center">{{$item->product->SKU }}</td>
                                <td class="text-center">{{$item->product->category->name }}</td>
                                <td class="text-center">{{$item->product->brand->name }}</td>
                                <td class="text-center">{{$item->options }}</td>
                                <td class="text-center">{{$item->options == 0 ? "No" : "Yes" }}</td>
                                <td class="text-center">
                                    <div class="list-icon-function view-icon">
                                        <div class="item eye">
                                            <i class="icon-eye"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            
        
                        </tbody>
                    </table>
                </div>
        
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{$orderItems->links('pagination::bootstrap-5')}}
        
                </div>
            </div>
        
            <div class="wg-box mt-5">
                <h5>Shipping Address</h5>
                <div class="my-account__address-item col-md-6">
                    <div class="my-account__address-item__detail">
                        <p>{{ $order->name }}</p>
                        <p>{{ $order->address }}</p>
                        <p>{{ $order->locality }}</p>
                        <p>{{ $order->zip }}</p>
                        <p>{{ $order->city }}</p>
                        <p>{{ $order->country }}</p>
                        <p>{{ $order->landmark }}</p>
                        <br>
                        <p>{{ $order->phone }}</p>
                    </div>
                </div>
            </div>
        
            <div class="wg-box mt-5">
                <h5>Transactions</h5>
                <table class="table table-bordered table-transaction">
                    <tbody>
                        <tr>
                            <th>Subtotal</th>
                            <td>$ {{ $order->subtotal }}</td>
                            <th>Tax</th>
                            <td> $ {{ $order->tax }}</td>
                            <th>Discount</th>
                            <td>$ {{ $order->discount }}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td>{{ $order->total }}</td>
                            {{-- <th>Payment Mode</th> --}}
                            {{-- <td>{{ $transaction->mode }}</td> --}}
                            {{-- <th>Status</th> --}}
                            {{-- <td> --}}
                                {{-- @if($transaction->status == "approved" )
                                    <span class="badge bg-success">Approved </span>
                                @elseif($transaction->status == "declinded")
                                    <span class="badge bg-danger">Declined </span>
                                @elseif($transaction->status == "refunded")
                                    <span class="badge bg-secondary">Refunded </span>
                                @else
                                    <span class="badge bg-warning">Pending </span>
                                @endif --}}
                            {{-- </td> --}}
                        </tr>
                        
                    </tbody>
                </table>
            </div>


            <div class="wg-box mt-5 text-right">
                <form id="cancel-form-{{ $order->id }}" method="post" action="{{route('user.order.cancel')}}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{$order->id}}"/>
                    <button class="btn btn-danger" type="button" onclick="confirmDelete({{ $order->id }})">Cancel Order</button>
                </form>
            </div>


        </div>

      </div>
    </section>
  </main>

@endsection





@push('scripts')

<script>
    function confirmDelete(categoryId) {

        swal({
            title : "Are you sure you want to Cancel order?",
            text : "Once Cancel, you will not be able to recover this Order",
            type : "warning",
            buttons: ['No','Yes'],
            confirmButtonColor:'#dc3545',

        }).then(function(result){
            if(result){
                document.getElementById('cancel-form-' + categoryId).submit();
            }
        })
        // if (confirm("Are you sure you want to delete this category?")) {
        //     document.getElementById('delete-form-' + categoryId).submit();
        // }
    }
</script>

 
@endpush