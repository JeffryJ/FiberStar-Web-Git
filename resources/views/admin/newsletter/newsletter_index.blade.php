@extends('adminlte::page')

@section('title','Newsletter')

@section('css')
    <link rel="stylesheet" href="{{asset('css/admin/lte_custom_style.css')}}">
@stop

@section('content_header')
    <h1>Newsletter</h1>
@stop

@section('js')
    <script src="{{asset('js/admin/datatable_adjustment_script.js')}}"></script>
@stop

@section('content')
    <div class="view-button-wrapper">
        <a class="btn btn-success" target="_blank" href="{{url('/news')}}">View News Page</a>
        <a href="{{url('/admin/newsletter/add')}}" class="btn btn-primary">Add newsletter</a>

    </div>
    <div class="container-fluid">
        <div class="row newsletter-container">
            <table id ="newsletter-table" class="table table-striped table-bordered width-100">
                <thead>
                    <tr>
                        <th>Volume</th>
                        <th>Created at</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($newsletters as $newsletter)
                        <tr>
                            <td>{{$newsletter->volume}}</td>
                            <td>{{$newsletter->created_at->format('jS F Y')}}</td>
                            <td>
                                <a href="{{asset($newsletter->image_link)}}">
                                    <img src="{{asset($newsletter->image_link)}}">
                                </a>
                            </td>
                            <td class="action-column">
                                <a href="{{url('/admin/newsletter/edit/'.$newsletter->id)}}" class="btn btn-primary">Edit</a>
                                <form method="post" class="form-inline form-delete" action="{{url('/admin/newsletter/delete')}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" value="{{$newsletter->id}}">
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