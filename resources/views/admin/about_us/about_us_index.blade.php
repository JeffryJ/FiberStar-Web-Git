@extends('adminlte::page')

@section('title', 'About Us')

@section('css')
    <link rel="stylesheet" href="{{asset('css/admin/lte_custom_style.css')}}">
@stop

@section('js')
    <script src="{{asset('js/admin/image_input_script.js')}}"></script>
    <script src="{{asset('js/admin/about_us_form_script.js')}}"></script>
@stop

@section('content_header')
    <h1> About Us Settings </h1>
@stop

@section('content')
    <div class="view-button-wrapper">
        <a class="btn btn-success" target="_blank" href="{{url('/about')}}">View About Us Page</a>
    </div>

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <form action="{{ url('/admin/about-us/update') }}" method="post" id="about_us_form" enctype="multipart/form-data" class="form-horizontal inputform" >
                    {{csrf_field()}}

                    @if(isset($data))
                        <input type="hidden" name="id" value="{{$data->id}}">
                    @endif

                    <div class="form-group">
                        <label for="vision" class="col-md-2 col-xs-12 control-label">Vision</label>
                        <div class="col-md-6 col-xs-12">
                            <textarea rows="2" class="form-control" id="vision" name="vision">{{old('vision')? old('vision'): (isset($data)? $data->vision : "")}}</textarea>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('vision')}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="mission" class="col-md-2 col-xs-12 control-label">Mission</label>
                        <div class="col-md-6 col-xs-12">
                            <textarea rows="2" class="form-control" id="mission" name="mission">{{old('mission')? old('mission'): (isset($data)? $data->mission : "")}}</textarea>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('mission')}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="corporate_values_description" class="col-md-2 col-xs-12 control-label">Corporate Values Description</label>
                        <div class="col-md-6 col-xs-12">
                            <textarea rows="4" class="form-control" id="corporate_values_description" name="corporate_values_description">{{old('corporate_values_description')? old('corporate_values_description'): (isset($data)? $data->corporate_values_description : "")}}</textarea>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('corporate_values_description')}}
                        </div>
                    </div>

                    <div class = "form-group">
                        <label for="corporate_values_image" class="col-md-2 col-xs-12 control-label">Corporate Values Image</label>
                        <div class ="col-md-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        Browse… <input type="file" id="corporate_values_image" name ="corporate_values_image" accept=".jpg,.jpeg,.bmp,.png">
                                    </span>
                                </span>
                                <input type="text" name="corporate_values_filename" class="form-control" readonly value="{{isset($data) ? $data->corporate_values_image_link : "" }}">
                            </div>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('corporate_values_image')}}
                            {{$errors->first('corporate_values_filename')}}
                        </div>

                        <div class="col-md-6 col-xs-12 col-md-offset-2">
                            <img class="image-preview" id="img-preview" src="{{isset($data) ? asset($data->corporate_values_image_link) : ""}}">
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