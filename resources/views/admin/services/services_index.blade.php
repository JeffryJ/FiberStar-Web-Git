@extends('adminlte::page')

@section('title','Services')

@section('css')
    <link rel="stylesheet" href="{{asset('css/admin/lte_custom_style.css')}}">
@stop

@section('content_header')
    <h1>Services</h1>
@stop

@section('js')
    <script src="{{asset('js/admin/datatable_adjustment_script.js')}}"></script>
@stop

@section('content')
    <div class="view-button-wrapper">
        <a class="btn btn-success" target="_blank" href="{{url('/services')}}">View Services Page</a>
        <a href="{{url('/admin/services/add')}}" class="btn btn-primary">Add Service</a>
    </div>

    <div class="container-fluid">
        <div class="row news-container">
            <table id ="services-table" class="table table-striped table-bordered width-100">
                <thead>
                <tr>
                    <th>Service Name</th>
                    <th>Description</th>
                    <th>Advantages</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($services as $service)
                    <tr>
                        <td>{{$service->service_name}}</td>
                        <td class="longtext-column">
                            {!! $service->description !!}
                        </td>
                        <td>
                            <ul>
                                @foreach($service->advantages as $service_advantage)
                                    <li>{{$service_advantage->advantage}}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <a href="{{asset($service->image_link)}}" target="_blank"><img src="{{asset($service->image_link)}}"></a>
                        </td>
                        <td class="action-column">
                            <a href="{{url('/admin/services/edit/'.$service->id)}}" class="btn btn-primary">Edit</a>
                            <form method="post" class="form-inline form-delete" action="{{url('/admin/services/delete')}}">
                                {{csrf_field()}}
                                <input type="hidden" name="id" value="{{$service->id}}">
                                <input type="submit" class="btn btn-danger" value="Delete">
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop