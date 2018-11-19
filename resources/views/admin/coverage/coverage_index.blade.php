
@extends('adminlte::page')

@section('title','Coverage')

@section('css')
    <link rel="stylesheet" href="{{asset('css/admin/lte_custom_style.css')}}">
@stop

@section('content_header')
    <h1>Coverage</h1>
@stop

@section('js')
    <script src="{{asset('js/admin/datatable_adjustment_script.js')}}"></script>
    <script src="{{asset('js/admin/image_input_script.js')}}"></script>
    <script src="{{asset('js/admin/alert_dismiss_script.js')}}"></script>
@stop

@section('content')

    <div class="alert-container">
        @if($errors->any())
            <div class="alert alert-light alert-error">
                <button type="button" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                @php($i = 1)
                @foreach( $errors->all() as $error)
                    {{$error}}
                    @if($i < count($errors->all()))
                        <br>
                    @endif
                    @php($i++)
                @endforeach
            </div>
        @elseif(session()->has('success'))
            <div class="alert alert-light alert-success">
                <button type="button" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{session()->get('success')}}
            </div>
        @endif
    </div>

    <div class="view-button-wrapper">
        <a class="btn btn-success" target="_blank" href="{{url('/coverage')}}">View Coverage Page</a>
        <a href="{{url('/admin/coverage/add')}}" class="btn btn-primary">Add Coverage Point</a>
        <form id="area-form" class="row" action="{{url('admin/coverage/import-area')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class = "col-xs-12 col-sm-12 col-md-12">
                <label for="imgInp" class="col-md-3 col-xs-12 control-label">Area Outlines CSV</label>
                <div class ="col-md-4 col-xs-12">
                    <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        Browse… <input type="file" id="area-csv" name ="area-csv" accept="text/csv">
                                    </span>
                                </span>
                        <input type="text" name="area-csv-filename" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="submit" class="btn btn-primary" value="Upload">
                </div>
                <div class="error col-xs-12 col-md-3">
                    {{$errors->first('area-csv')}}
                </div>
            </div>
        </form>
        <form class="row" id="coverage-form" action="{{url('admin/coverage/import-coverage')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class = "col-xs-12 col-sm-12 col-md-12">
                <label for="imgInp" class="col-md-3 col-xs-12 control-label">Fiberstar Coverage CSV</label>
                <div class ="col-md-4 col-xs-12">
                    <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        Browse… <input type="file" id="coverage-csv" name ="coverage-csv" accept="text/csv">
                                    </span>
                                </span>
                        <input type="text" name="coverage-csv-filename" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="submit" class="btn btn-primary" value="Upload">
                </div>
                <div class="error col-xs-12 col-md-3">
                    {{$errors->first('coverage-csv')}}
                </div>
            </div>
        </form>
    </div>

    <div class="container-fluid">
        <div class="row coverage-container">
            <table id ="coverage-table" class="table table-striped table-bordered width-100">
                <thead>
                <tr>
                    <th>Place</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Pass Through Type</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($areas as $area)
                        <tr>
                            <td>{{$area->place}}</td>
                            <td>{{$area->latitude}}</td>
                            <td>{{$area->longitude}}</td>
                            <td>{{$area->type->pass_through_type}}</td>
                            <td class="action-column">
                                <a href="{{url('/admin/coverage/edit/'.$area->id)}}" class="btn btn-primary">Edit</a>
                                <form method="post" class="form-inline form-delete" action="{{url('/admin/coverage/delete')}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" value="{{$area->id}}">
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