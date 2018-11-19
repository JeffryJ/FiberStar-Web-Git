@extends('adminlte::page')

@section('title', $title)

@section('css')
    <link rel="stylesheet" href="{{asset('css/admin/lte_custom_style.css')}}">
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@stop

@section('js')
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <script src="{{asset('js/admin/quill_editor_script.js')}}"></script>
    <script src="{{asset('js/admin/image_input_script.js')}}"></script>

    <script src="{{asset('js/admin/testimony_form_script.js')}}"></script>
@stop

@section('content_header')
    <h1> {{$title}} </h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ isset($testimony) ? url('/admin/testimonies/edit') : url('/admin/testimonies/add')}}" method="post" id="testimony_form" enctype="multipart/form-data" class="form-horizontal inputform" >
                    {{csrf_field()}}

                    @if(isset($testimony))
                        <input type="hidden" name="id" value="{{$testimony->id}}">
                    @endif

                    <div class="form-group">
                        <label for="name" class="col-md-2 col-xs-12 control-label">Name</label>
                        <div class="col-md-6 col-xs-12">
                            <input type="text" class="form-control" id="name" name="name" value="{{isset($testimony)? $testimony->name : old('name')}}">
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('name')}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="title" class="col-md-2 col-xs-12 control-label">Title</label>
                        <div class="col-md-6 col-xs-12">
                            <input type="text" class="form-control" id="title" name="title" value="{{isset($testimony)? $testimony->title : old('title')}}">
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('title')}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="testimony" class="col-md-2 col-xs-12 control-label">Testimony</label>
                        <div class="col-md-6 col-xs-12">
                            {{--                            <input type="text" class="form-control" id="description" name="description" value="{{isset($milestone)? $milestone->description : old('description')}}">--}}
                            <textarea class="form-control" name="testimony" id="testimony" rows="4">{{isset($testimony)? $testimony->testimony : old('testimony')}}</textarea>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('testimony')}}
                        </div>
                    </div>

                    <div class = "form-group">
                        <label for="imgInp" class="col-md-2 col-xs-12 control-label">Testimony Image</label>
                        <div class ="col-md-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        Browse… <input type="file" id="imgInp" name ="image" accept=".jpg,.jpeg,.bmp,.png">
                                    </span>
                                </span>
                                <input type="text" name="readonly-filename" class="form-control" readonly value="{{isset($testimony) ? $testimony->image_link : "" }}">
                            </div>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('image')}}
                        </div>

                        <div class="col-md-6 col-xs-12 col-md-offset-2">
                            <img id="img-upload" src="{{isset($testimony) ? asset($testimony->image_link) : ""}}" width="100%">
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