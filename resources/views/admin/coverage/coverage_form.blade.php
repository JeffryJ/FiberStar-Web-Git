@extends('adminlte::page')

@section('title', $title)

@section('css')
    <link rel="stylesheet" href="{{asset('css/admin/lte_custom_style.css')}}">
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@stop

@section('content_header')
    <h1> {{$title}} </h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ isset($area) ? url('/admin/coverage/edit') : url('/admin/coverage/add')}}" method="post" id="news_form" enctype="multipart/form-data" class="form-horizontal inputform" >
                    {{csrf_field()}}

                    @if(isset($area))
                        <input type="hidden" name="id" value="{{$area->id}}">
                    @endif

                    <div class="form-group">
                        <label for="place" class="col-md-2 col-xs-12 control-label">Place</label>
                        <div class="col-md-6 col-xs-12">
                            <input type="text" class="form-control" id="place" name="place" value="{{isset($area)? $area->place : old('place')}}">
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('place')}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="latitude" class="col-md-2 col-xs-12 control-label">Latitude</label>
                        <div class="col-md-6 col-xs-12">
                            <input type="number" step="any" class="form-control" id="latitude" name="latitude" value="{{isset($area)? $area->latitude : old('latitude')}}">
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('latitude')}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="longitude" class="col-md-2 col-xs-12 control-label">Longitude</label>
                        <div class="col-md-6 col-xs-12">
                            <input type="number" step="any" class="form-control" id="longitude" name="longitude" value="{{isset($area)? $area->longitude : old('longitude')}}">
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('longitude')}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pass_through_type" class="col-md-2 col-xs-12 control-label">Pass Through</label>
                        <div class="col-md-6 col-xs-12">
                            <select class="form-control" id="pass_through_type" name="pass_through_type">
                                <option value="" {{isset($area) ? "" : old('pass_through_type') == "" ? "selected" : ""}}>Select</option>
                                @foreach($types as $type)
                                    <option value="{{$type->id}}" {{isset($area) ? ($area->pass_through_type_id == $type->id ?  "selected" : "")  : old('pass_through_type') == $type->id ? "selected" : ""}}>{{$type->pass_through_type}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('pass_through_type')}}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-primary">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@stop