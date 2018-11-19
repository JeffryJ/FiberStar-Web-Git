@extends('adminlte::page')

@section('title','Testimonies')

@section('css')
    <link rel="stylesheet" href="{{asset('css/admin/lte_custom_style.css')}}">
@stop

@section('content_header')
    <h1>Testimonies</h1>
@stop

@section('js')
    <script src="{{asset('js/admin/datatable_adjustment_script.js')}}"></script>
@stop

@section('content')
    <div class="view-button-wrapper">
        <a class="btn btn-success" target="_blank" href="{{url('/home')}}">View Landing Page</a>
        <a href="{{url('/admin/testimonies/add')}}" class="btn btn-primary">Add Testimony</a>
    </div>

    <div class="container-fluid">
        <div class="row news-container">
            <table id ="news-table" class="table table-striped table-bordered width-100">
                <thead>
                <tr>
                    <th>Shown in Web?</th>
                    <th>Name</th>
                    <th>Title</th>
                    <th>Testimony</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @php($count = 1)
                @foreach($testimonies as $testimony)
                    <tr>
                        <td>
                            @if($count>=1 && $count <=3)
                                {{"Testimony ".$count}}
                            @else
                                {{""}}
                            @endif
                        </td>
                        <td>{{$testimony->name}}</td>
                        <td>{{$testimony->title}}</td>
                        <td class="longtext-column">{{$testimony->testimony}}</td>
                        <td>
                            <a href="{{asset($testimony->image_link)}}" target="_blank">
                                <img src="{{ asset($testimony->image_link)}}">
                            </a>
                        </td>
                        <td class="action-column">
                            <a href="{{url('/admin/testimonies/edit/'.$testimony->id)}}" class="btn btn-primary">Edit</a>
                            <form method="post" class="form-inline form-delete" action="{{url('/admin/testimonies/delete')}}">
                                {{csrf_field()}}
                                <input type="hidden" name="id" value="{{$testimony->id}}">
                                <input type="submit" class="btn btn-danger" value="Delete">
                            </form>
                        </td>
                    </tr>
                    @php($count++)
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop