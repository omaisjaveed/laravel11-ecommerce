@extends('layouts.admin')

@section('content')

<div class="main-content-wrap">
    <div class="flex items-center flex-wrap justify-between gap20 mb-27">
        <h3>Order Details</h3>
        <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
            <li>
                <a href="#">
                    <div class="text-tiny">Dashboard</div>
                </a>
            </li>
            <li>
                <i class="icon-chevron-right"></i>
            </li>
            <li>
                <div class="text-tiny">Order Items</div>
            </li>
        </ul>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="wg-box">
        <div class="flex items-center justify-between gap10 flex-wrap">
            <div class="wg-filter flex-grow">
                <h5>Ordered Details</h5>
            </div>
            <a class="tf-button style-1 w208" href="{{route('admin.orders')}}">Back</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Order No</th>
                    <td>{{$order->id}}</td>
                    <td>Mobile</td>
                    <td>{{$order->phone}}</td>
                    <td>Zip code</td>
                    <td>{{$order->zip}}</td>
                </tr>
                <tr>
                    <th>Order Date</th>
                    <td>{{$order->created_at}}</td>
                    <td>Delivered Date</td>
                    <td>{{$order->delivered_date}}</td>
                    <td>Canceled Date</td>
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
                            <span class="badge bg-warning">Ordered</span>
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
        <table class="table table-striped table-bordered table-transaction">
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


    <div class="wg-box mt-5">
        <h5>Update Order status</h5>
        <form action="{{route('admin.order.status.update')}}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="order_id" value="{{ $order->id }}"/>
            <div class="row">
                <div class="col-3">
                    <div class="select">
                        <select id="order_id" name="order_status">
                            <option value="ordered">ordered</option>
                            <option value="delivered">delivered</option>
                            <option value="canceled">canceled</option>
                        </select>                
                    </div>
                </div>
                <div class="col-3">
                    <button type="submit" class="btn btn-primary tf-button w208">Update Order Status</button>
                </div>
            </div>
            

        </form>
    </div>
</div>

@endsection