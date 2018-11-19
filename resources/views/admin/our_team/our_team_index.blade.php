@extends('adminlte::page')

@section('title', 'Our Team')

@section('css')
<link rel="stylesheet" href="{{asset('css/admin/lte_custom_style.css')}}">
@stop

@section('js')
    <script src="{{asset('js/admin/image_input_script.js')}}"></script>
    <script src="{{asset('js/admin/image_youtube_selector_script.js')}}"></script>
@stop

@section('content_header')
<h1> Our Team Settings </h1>
@stop

@section('content')
<div class="view-button-wrapper">
    <a class="btn btn-success" target="_blank" href="{{url('/team')}}">View Our Team Page</a>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ url('/admin/our-team/update') }}" method="post" id="our_team_form" enctype="multipart/form-data" class="form-horizontal inputform" >
                {{csrf_field()}}

                @if(isset($data))
                <input type="hidden" name="id" value="{{$data->id}}">
                @endif

                <div class="form-group">
                    <label for="opportunity1" class="col-md-2 col-xs-12 control-label">Opportunity 1</label>
                    <div class="col-md-6 col-xs-12">
                        <textarea rows="2" class="form-control" id="opportunity1" name="opportunity1">{{old('opportunity1')? old('opportunity1'): (isset($data)? $data->opportunity1 : "")}}</textarea>
                    </div>
                    <div class="error col-xs-12 col-md-4">
                        {{$errors->first('opportunity1')}}
                    </div>
                </div>

                <div class="form-group">
                    <label for="opportunity2" class="col-md-2 col-xs-12 control-label">Opportunity 2</label>
                    <div class="col-md-6 col-xs-12">
                        <textarea rows="2" class="form-control" id="opportunity2" name="opportunity2">{{old('opportunity2')? old('opportunity2'): (isset($data)? $data->opportunity2 : "")}}</textarea>
                    </div>
                    <div class="error col-xs-12 col-md-4">
                        {{$errors->first('opportunity2')}}
                    </div>
                </div>

                <div class="form-group">
                    <label for="opportunity3" class="col-md-2 col-xs-12 control-label">Opportunity 3</label>
                    <div class="col-md-6 col-xs-12">
                        <textarea rows="2" class="form-control" id="opportunity3" name="opportunity3">{{old('opportunity3')? old('opportunity3'): (isset($data)? $data->opportunity3 : "")}}</textarea>
                    </div>
                    <div class="error col-xs-12 col-md-4">
                        {{$errors->first('opportunity3')}}
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

    <div class="row">
        <h3>Slider Content</h3>
    </div>

    <div class="row display-flex gallery" id="slider-gallery">
        @if($images!=null)
            @foreach($images as $image)
                @if(strpos($image->media_link , 'youtube') === false)
                    <div class="col-md-3 col-xs-6">
                        <div class="thumbnail">
                            <a href="{{asset($image->media_link)}}" target="_blank">
                                <img class="img-responsive" src="{{asset($image->media_link)}}">
                            </a>
                            <div class="caption">
                                <center>
                                    <form method="post" action="{{url('admin/our-team/delete-media')}}">
                                        {{csrf_field()}}

                                        <input type="hidden" name="id" value="{{$image->id}}">

                                        <input type="submit" class="btn btn-danger" value="delete">
                                    </form>
                                </center>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-3 col-xs-6">
                        <div class="thumbnail">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="{{$image->media_link}}" frameborder="0" allow="encrypted-media" allowfullscreen></iframe>
                            </div>
                            <div class="caption">
                                <center>
                                    <form method="post" class="form-delete" action="{{url('admin/our-team/delete-media')}}">
                                        {{csrf_field()}}

                                        <input type="hidden" name="id" value="{{$image->id}}">

                                        <input type="submit" class="btn btn-danger" value="delete">
                                    </form>
                                </center>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            <center>
                <h4>No Content</h4>
            </center>
        @endif
    </div>

    <div class="row">
        <div><h4>Add Content</h4></div>
        <form id="slider-content-form" action="{{url('admin/our-team/add-media')}}" method="post" enctype="multipart/form-data" class="form-horizontal inputform">

            {{csrf_field()}}

            <div class="col-md-3 col-xs-12 no-padding">
                <select name="media_type" id ="media_type" class="form-control">
                    <option value="image" {{old('youtube_url') ? "" : "selected"}}>Image Upload</option>
                    <option value="youtube_url" {{old('youtube_url') ? "selected" : ""}}>Youtube URL</option>
                </select>
            </div>
            <div class ="col-md-5 col-xs-12" id="image-div">
                <div class="row">
                    <div class="col-12">
                        <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        Images <input type="file" id="media_images" name ="media_images[]" accept=".jpg,.jpeg,.bmp,.png" multiple>
                                    </span>
                                </span>
                            <input type="text" placeholder="Add Images" name="media_filename" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5 col-xs-12" id="youtube-div">
                <div class="row">
                    <div class="col-12">
                        <input type="text" class="form-control" placeholder="Youtube URL" id="youtube_url" name="youtube_url" value="{{ old('youtube_url') }}">
                    </div>
                </div>
            </div>

            <div class="col-md-1 col-xs-12 no-padding">
                <input type="submit" class="btn btn-primary">
            </div>

            <div class="error col-md-3 col-xs-12">
                {{$errors->first('youtube_url')}}
                {{$errors->first('media_images')}}
            </div>
        </form>
    </div>

</div>
@stop