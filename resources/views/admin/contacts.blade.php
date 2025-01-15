@extends('layouts.admin')

@section('content')

<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>All Messages</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href=" {{route('admin.index')}} ">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Coupons</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search">
                        <fieldset class="name">
                            <input type="text" placeholder="Search here..." class="" name="name"
                                tabindex="2" value="" aria-required="true" required="">
                        </fieldset>
                        <div class="button-submit">
                            <button class="" type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <a class="tf-button style-1 w208" href="{{route('admin.coupon.add')}}"><i
                        class="icon-plus"></i>Add new 44</a>
            </div>
            <div class="wg-table table-all-user">
                <div class="table-responsive">
                    @if(Session::has('status'))
                        <p class="alert alert-success">{{ session::get('status') }}</p>
                    @endif
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th style="width: 300px">Email</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contacts as $contact)
                            <tr>
                                <td>{{$contact->id}}</td>
                                <td>{{$contact->name}}</td>
                                <td>{{$contact->phone}}</td>
                                <td>{{$contact->email}}</td>
                                <td>{{$contact->comment}}</td>
                                <td>{{$contact->created_at}}</td>
                                <td>
                                    <div class="list-icon-function">
                                        
                                        <form id="delete-form-{{ $contact->id }}" action="{{ route('admin.contact.delete', ['id' => $contact->id ]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete({{ $contact->id }})" class="btn btn-danger">
                                                <i class="icon-trash-2"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{$contacts->links('pagination::bootstrap-5')}}
            </div>
        </div>
    </div>
</div>

@endsection



@push('scripts')

<script>
    function confirmDelete(couponId) {

        swal({
            title : "Are you sure you want to delete?",
            text : "Once deleted, you will not be able to recover this data",
            type : "warning",
            buttons: ['No','Yes'],
            confirmButtonColor:'#dc3545',

        }).then(function(result){
            if(result){
                document.getElementById('delete-form-' + couponId).submit();
            }
        })
    }
</script>

 
@endpush