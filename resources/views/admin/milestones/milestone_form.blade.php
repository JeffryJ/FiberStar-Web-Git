@extends('adminlte::page')

@section('title', $title)

@section('css')
    <link rel="stylesheet" href="{{asset('css/admin/lte_custom_style.css')}}">
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@stop

@section('js')
    <script src="{{asset('js/admin/image_input_script.js')}}"></script>
    <script src="{{asset('js/admin/milestone_form_script.js')}}"></script>
@stop

@section('content_header')
    <h1> {{$title}} </h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ isset($milestone) ? url('/admin/milestones/edit') : url('/admin/milestones/add')}}" method="post" id="milestone_form" enctype="multipart/form-data" class="form-horizontal inputform" >
                    {{csrf_field()}}

                    @if(isset($milestone))
                        <input type="hidden" name="id" value="{{$milestone->id}}">
                    @endif

                    <div class="form-group">
                        <label for="date" class="col-md-2 col-xs-12 control-label">Date</label>
                        <div class="col-md-6 col-xs-12">
                            <input type="date" class="form-control" id="date" name="date" value="{{isset($milestone)? $milestone->date->format('Y-m-d') : old('date')}}">
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('date')}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-md-2 col-xs-12 control-label">Description</label>
                        <div class="col-md-6 col-xs-12">
{{--                            <input type="text" class="form-control" id="description" name="description" value="{{isset($milestone)? $milestone->description : old('description')}}">--}}
                            <textarea class="form-control" name="description" id="description" rows="4">{{isset($milestone)? $milestone->description : old('description')}}</textarea>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('description')}}
                        </div>
                    </div>

                    <div class = "form-group">
                        <label for="imgInp" class="col-md-2 col-xs-12 control-label">Milestone Image</label>
                        <div class ="col-md-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        Browse… <input type="file" id="imgInp" name ="image" accept=".jpg,.jpeg,.bmp,.png">
                                    </span>
                                </span>
                                <input type="text" name="readonly-filename" class="form-control" readonly value="{{isset($milestone) ? $milestone->image_link : "" }}">
                            </div>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('image')}}
                        </div>
                        <div class="col-md-6 col-xs-12 col-md-offset-2">
                            <img id="img-upload" src="{{isset($milestone) ? asset($milestone->image_link) : ""}}" width="100%">
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