@extends('adminlte::page')

@section('title', 'Landing Page')

@section('css')
    <link rel="stylesheet" href="{{asset('css/admin/lte_custom_style.css')}}">
@stop

@section('js')
    <script src="{{asset('js/admin/image_input_script.js')}}"></script>
    <script src="{{asset('js/admin/landing_page_form_script.js')}}"></script>
    <script src="{{asset('js/admin/image_youtube_selector_script.js')}}"></script>
@stop

@section('content_header')
    <h1> Landing Page Settings </h1>
@stop

@section('content')
    <div class="view-button-wrapper">
        <a class="btn btn-success" target="_blank" href="{{url('/home')}}">View Landing Page</a>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ url('/admin/landing-page/update') }}" method="post" id="landing_page_form" enctype="multipart/form-data" class="form-horizontal inputform" >
                    {{csrf_field()}}

                    @if(isset($data))
                        <input type="hidden" name="id" value="{{$data->id}}">
                    @endif

                    <div class = "form-group">
                        <label for="imgInp" class="col-md-2 col-xs-12 control-label">Background Image</label>
                        <div class ="col-md-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        Browse… <input type="file" id="background_image" name ="background_image" accept=".jpg,.jpeg,.bmp,.png">
                                    </span>
                                </span>
                                <input type="text" name="background_image_filename" class="form-control" readonly value="{{isset($data) ? $data->background_image_link : "" }}">
                            </div>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('background_image')}}
                            {{$errors->first('background_image_filename')}}
                        </div>
                        <div class="col-md-6 col-xs-12 col-md-offset-2">
                            <img id="background_image_preview" src="{{isset($data) ? asset($data->background_image_link) : ""}}" width="100%">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="who_we_are" class="col-md-2 col-xs-12 control-label">Who We Are</label>
                        <div class="col-md-6 col-xs-12">
                            <textarea rows="4" class="form-control" id="who_we_are" name="who_we_are">{{old('who_we_are')? old('who_we_are'): (isset($data)? $data->who_we_are : "")}}</textarea>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('who_we_are')}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="benefit1_title" class="col-md-2 col-xs-12 control-label">Benefit 1</label>
                        <div class="col-md-6 col-xs-12">
                            <input type="text" class="form-control" placeholder="Title" id="benefit1_title" name="benefit1_title" value="{{old('benefit1_title')? old('benefit1_title'): (isset($data)? $data->benefit1_title : "")}}">
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('benefit1_title')}}
                        </div>

                        <div class="col-md-offset-2 col-md-6 col-xs-12">
                            <textarea class="form-control" placeholder="Description" id="benefit1_description" name="benefit1_description">{{old('benefit1_description')? old('benefit1_description'): (isset($data)? $data->benefit1_description : "")}}</textarea>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('benefit1_description')}}
                        </div>

                        <div class ="col-md-offset-2 col-md-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        Browse… <input type="file" id="benefit1_image" name ="benefit1_image" accept=".jpg,.jpeg,.bmp,.png">
                                    </span>
                                </span>
                                <input type="text" placeholder="Benefit Image" name="benefit1_filename" class="form-control" readonly value="{{isset($data)? $data->benefit1_image_link : ""}}">
                            </div>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('benefit1_image')}}
                            {{$errors->first('benefit1_filename')}}
                        </div>
                        <div class="col-md-6 col-xs-12 col-md-offset-2">
                            <img class="image-preview" id="benefit1_image_preview" src="{{isset($data) ? asset($data->benefit1_image_link) : ""}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="benefit2_title" class="col-md-2 col-xs-12 control-label">Benefit 2</label>
                        <div class="col-md-6 col-xs-12">
                            <input type="text" class="form-control" placeholder="Title" id="benefit2_title" name="benefit2_title" value="{{old('benefit2_title')? old('benefit2_title'): (isset($data)? $data->benefit2_title : "")}}">
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('benefit2_title')}}
                        </div>

                        <div class="col-md-offset-2 col-md-6 col-xs-12">
                            <textarea class="form-control" placeholder="Description" id="benefit2_description" name="benefit2_description">{{old('benefit2_description')? old('benefit2_description'): (isset($data)? $data->benefit2_description : "")}}</textarea>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('benefit2_description')}}
                        </div>

                        <div class ="col-md-offset-2 col-md-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        Browse… <input type="file" id="benefit2_image" name ="benefit2_image" accept=".jpg,.jpeg,.bmp,.png">
                                    </span>
                                </span>
                                <input type="text" placeholder="Benefit Image" name="benefit2_filename" class="form-control" readonly value="{{isset($data)? $data->benefit2_image_link : ""}}">
                            </div>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('benefit2_image')}}
                            {{$errors->first('benefit2_filename')}}
                        </div>
                        <div class="col-md-6 col-xs-12 col-md-offset-2">
                            <img class="image-preview" id="benefit2_image_preview" src="{{isset($data) ? asset($data->benefit2_image_link) : ""}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="benefit2_title" class="col-md-2 col-xs-12 control-label">Benefit 3</label>
                        <div class="col-md-6 col-xs-12">
                            <input type="text" class="form-control" placeholder="Title" id="benefit3_title" name="benefit3_title" value="{{old('benefit3_title')? old('benefit3_title'): (isset($data)? $data->benefit3_title : "")}}">
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('benefit3_title')}}
                        </div>

                        <div class="col-md-offset-2 col-md-6 col-xs-12">
                            <textarea class="form-control" placeholder="Description" id="benefit3_description" name="benefit3_description">{{old('benefit3_description')? old('benefit3_description'): (isset($data)? $data->benefit3_description : "")}}</textarea>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('benefit3_description')}}
                        </div>

                        <div class ="col-md-offset-2 col-md-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        Browse… <input type="file" id="benefit3_image" name ="benefit3_image" accept=".jpg,.jpeg,.bmp,.png">
                                    </span>
                                </span>
                                <input type="text" placeholder="Benefit Image" name="benefit3_filename" class="form-control" readonly value="{{isset($data)? $data->benefit3_image_link : ""}}">
                            </div>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('benefit3_image')}}
                            {{$errors->first('benefit3_filename')}}
                        </div>
                        <div class="col-md-6 col-xs-12 col-md-offset-2">
                            <img class="image-preview" id="benefit3_image_preview" src="{{isset($data) ? asset($data->benefit3_image_link) : ""}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="benefit2_title" class="col-md-2 col-xs-12 control-label">Benefit 4</label>
                        <div class="col-md-6 col-xs-12">
                            <input type="text" class="form-control" placeholder="Title" id="benefit4_title" name="benefit4_title" value="{{old('benefit4_title')? old('benefit4_title'): (isset($data)? $data->benefit4_title : "")}}">
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('benefit4_title')}}
                        </div>

                        <div class="col-md-offset-2 col-md-6 col-xs-12">
                            <textarea class="form-control" placeholder="Description" id="benefit4_description" name="benefit4_description">{{old('benefit4_description')? old('benefit4_description'): (isset($data)? $data->benefit4_description : "")}}</textarea>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('benefit4_description')}}
                        </div>

                        <div class ="col-md-offset-2 col-md-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        Browse… <input type="file" id="benefit4_image" name ="benefit4_image" accept=".jpg,.jpeg,.bmp,.png">
                                    </span>
                                </span>
                                <input type="text" placeholder="Benefit Image" name="benefit4_filename" class="form-control" readonly value="{{isset($data)? $data->benefit4_image_link : ""}}">
                            </div>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('benefit4_image')}}
                            {{$errors->first('benefit4_filename')}}
                        </div>
                        <div class="col-md-6 col-xs-12 col-md-offset-2">
                            <img class="image-preview" id="benefit4_image_preview" src="{{isset($data) ? asset($data->benefit4_image_link) : ""}}">
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

        {{--Slider Component, unused--}}

        {{--<div class="row">--}}
            {{--<h3>Slider Content</h3>--}}
        {{--</div>--}}

        {{--<div class="row display-flex gallery" id="slider-gallery">--}}
            {{--@if($images!=null)--}}
                {{--@foreach($images as $image)--}}
                    {{--@if(strpos($image->media_link , 'youtube') === false)--}}
                        {{--<div class="col-md-3 col-xs-6">--}}
                            {{--<div class="thumbnail">--}}
                                {{--<a href="{{asset($image->media_link)}}" target="_blank">--}}
                                    {{--<img class="img-responsive" src="{{asset($image->media_link)}}">--}}
                                {{--</a>--}}
                                {{--<div class="caption">--}}
                                    {{--<center>--}}
                                        {{--<form method="post" action="{{url('admin/landing-page/delete-media')}}">--}}
                                            {{--{{csrf_field()}}--}}

                                            {{--<input type="hidden" name="id" value="{{$image->id}}">--}}

                                            {{--<input type="submit" class="btn btn-danger" value="delete">--}}
                                        {{--</form>--}}
                                    {{--</center>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--@else--}}
                        {{--<div class="col-md-3 col-xs-6">--}}
                            {{--<div class="thumbnail">--}}
                                {{--<div class="embed-responsive embed-responsive-16by9">--}}
                                    {{--<iframe class="embed-responsive-item" src="{{$image->media_link}}" frameborder="0" allow="encrypted-media" allowfullscreen></iframe>--}}
                                {{--</div>--}}
                                {{--<div class="caption">--}}
                                    {{--<center>--}}
                                        {{--<form method="post" class="form-delete" action="{{url('admin/landing-page/delete-media')}}">--}}
                                            {{--{{csrf_field()}}--}}

                                            {{--<input type="hidden" name="id" value="{{$image->id}}">--}}

                                            {{--<input type="submit" class="btn btn-danger" value="delete">--}}
                                        {{--</form>--}}
                                    {{--</center>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--@endif--}}
                {{--@endforeach--}}
            {{--@else--}}
                {{--<center>--}}
                    {{--<h4>No Content</h4>--}}
                {{--</center>--}}
            {{--@endif--}}
        {{--</div>--}}

        {{--<div class="row">--}}
            {{--<div><h4>Add Content</h4></div>--}}
            {{--<form id="slider-content-form" action="{{url('admin/landing-page/add-media')."#slider-content-form"}}" method="post" enctype="multipart/form-data" class="form-horizontal inputform">--}}

                {{--{{csrf_field()}}--}}

                {{--<div class="col-md-3 col-xs-12 no-padding">--}}
                    {{--<select name="media_type" id ="media_type" class="form-control">--}}
                        {{--<option value="image" {{old('youtube_url') ? "" : "selected"}}>Image Upload</option>--}}
                        {{--<option value="youtube_url" {{old('youtube_url') ? "selected" : ""}}>Youtube URL</option>--}}
                    {{--</select>--}}
                {{--</div>--}}
                {{--<div class ="col-md-5 col-xs-12" id="image-div">--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-12">--}}
                            {{--<div class="input-group">--}}
                                {{--<span class="input-group-btn">--}}
                                    {{--<span class="btn btn-default btn-file">--}}
                                        {{--Images <input type="file" id="media_images" name ="media_images[]" accept=".jpg,.jpeg,.bmp,.png" multiple>--}}
                                    {{--</span>--}}
                                {{--</span>--}}
                                {{--<input type="text" placeholder="Add Images" name="media_filename" class="form-control" readonly>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="col-md-5 col-xs-12" id="youtube-div">--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-12">--}}
                            {{--<input type="text" class="form-control" placeholder="Youtube URL" id="youtube_url" name="youtube_url" value="{{ old('youtube_url') }}">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="col-md-1 col-xs-12 no-padding">--}}
                    {{--<input type="submit" class="btn btn-primary">--}}
                {{--</div>--}}

                {{--<div class="error col-md-3 col-xs-12">--}}
                    {{--{{$errors->first('youtube_url')}}--}}
                    {{--{{$errors->first('media_images')}}--}}
                {{--</div>--}}
            {{--</form>--}}
        {{--</div>--}}

    </div>



@stop