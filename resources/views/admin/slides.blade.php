@extends('layouts.admin')

@section('content')


<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Slider</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{route('admin.index')}}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Slides</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            @if(Session::has('status'))
                    <p class="alert alert-success">{{ Session::get('status') }}</p>
            @endif
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
                <a class="tf-button style-1 w208" href="{{ route('admin.slide.add') }}"><i
                        class="icon-plus"></i>Add new</a>
            </div>
            <div class="wg-table table-all-user">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Tagline</th>
                            <th>Title</th>
                            <th>Subtitle</th>
                            <th style="width:300px">Link</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($slides as $slide)
                        <tr>
                            <td>{{$slide->id}}</td>
                            <td class="pname">
                                <div class="image">
                                    <img src="{{asset('uploads/slides')}}/{{$slide->image}}" alt="{{$slide->title}}" class="image">
                                </div>
                            </td>
                            <td>{{$slide->tagline}}</td>
                            <td>{{$slide->title}}</td>
                            <td>{{$slide->subtitle}}</td>
                            <td style="width:500px">{{$slide->link}}</td>
                            <td>
                                <div class="list-icon-function">
                                    <a href="{{route('admin.slide.edit', ['id' => $slide->id] )}}">
                                        <div class="item edit">
                                            <i class="icon-edit-3"></i>
                                        </div>
                                    </a>
                                    <form id="delete-form-{{ $slide->id }}" action="{{ route('admin.slide.delete', ['id' => $slide->id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $slide->id }})" class="btn btn-danger">
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
            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{$slides->links('pagination::bootstrap-5')}}
            </div>
        </div>
    </div>
</div>


@endsection




@push('scripts')

<script>
    function confirmDelete(productId) {

        swal({
            title : "Are you sure you want to delete Slide?",
            text : "Once deleted, you will not be able to recover this data",
            type : "warning",
            buttons: ['No','Yes'],
            confirmButtonColor:'#dc3545',

        }).then(function(result){
            if(result){
                document.getElementById('delete-form-' + productId).submit();
            }
        })
        // if (confirm("Are you sure you want to delete this category?")) {
        //     document.getElementById('delete-form-' + productId).submit();
        // }
    }
</script>

 
@endpush