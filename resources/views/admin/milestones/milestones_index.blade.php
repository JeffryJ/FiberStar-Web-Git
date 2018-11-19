@extends('adminlte::page')

@section('title','Milestones')

@section('css')
    <link rel="stylesheet" href="{{asset('css/admin/lte_custom_style.css')}}">
@stop

@section('content_header')
    <h1>Milestones</h1>
@stop

@section('js')
    <script src="{{asset('js/admin/datatable_adjustment_script.js')}}"></script>
@stop

@section('content')
    <div class="view-button-wrapper">
        <a class="btn btn-success" target="_blank" href="{{url('/about')}}">View About Us Page</a>
        <a href="{{url('/admin/milestones/add')}}" class="btn btn-primary">Add Milestone</a>
    </div>

    <div class="container-fluid">
        <div class="row news-container">
            <table id ="milestones-table" class="table table-striped table-bordered width-100">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($milestones as $milestone)
                        <tr>
                            <td>{{$milestone->date->format('jS F Y')}}</td>
                            <td>{{$milestone->description}}</td>
                            <td>
                                <a href="{{asset($milestone->image_link)}}" target="_blank">
                                    <img src="{{asset($milestone->image_link)}}">
                                </a>
                            </td>
                            <td class="action-column">
                                <a href="{{url('/admin/milestones/edit/'.$milestone->id)}}" class="btn btn-primary">Edit</a>
                                <form method="post" class="form-inline form-delete" action="{{url('/admin/milestones/delete')}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" value="{{$milestone->id}}">
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