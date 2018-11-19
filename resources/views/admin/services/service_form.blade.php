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
    <script src="{{asset('js/admin/service_form_script.js')}}"></script>

@stop

@section('content_header')
    <h1> {{$title}} </h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ isset($service) ? url('/admin/services/edit') : url('/admin/services/add')}}" method="post" id="service_form" enctype="multipart/form-data" class="form-horizontal inputform" >
                    {{csrf_field()}}

                    @if(isset($service))
                        <input type="hidden" name="id" value="{{$service->id}}">

                        <input type="hidden" id="to_be_deleted" name="to_be_deleted">
                    @endif

                    <div class="form-group">
                        <label for="service_name" class="col-md-2 col-xs-12 control-label">Service Name</label>
                        <div class="col-md-6 col-xs-12">
                            <input type="text" class="form-control" id="service_name" name="service_name" value="{{isset($service)? $service->service_name: old('service_name')}}">
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('service_name')}}
                        </div>
                    </div>

                    <div class="form-group">
                        <input name="description" type="hidden">
                        <label for="description" class="col-md-2 col-xs-12 control-label">Description</label>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-control editor" data-target="description" id="description">{!! isset($service)? $service->description : old('description') !!}</div>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('description')}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="service_name" class="col-xs-6 col-md-2 control-label">Advantages</label>
                        <div class="col-xs-6 col-md-10">
                            <button class="btn btn-primary" id="btn-add-advantage">Add Advantage</button>
                        </div>
                    </div>

                    <div class="form-group" id="advantage-container">
                        @if(isset($service))
                            @php ($number = 0)
                            @foreach($service->advantages as $advantage)
                                @php ($number++)
                                    <div class="col-md-offset-2 col-md-6 col-xs-8">
                                        <input type="text" class="form-control" id="{{"advantage-".$number}}" placeholder="{{"Advantage ".$number}}" name="advantages[]" value="{{$advantage->advantage}}">
                                        <input type="hidden" name="advantage_ids[]" value="{{$advantage->id}}">
                                    </div>
                                    <div class="col-xs-4">
                                        <button class="delete-field btn btn-danger" id ="{{"button-".$number}}" data-target="{{"#advantage-".$number}}">Delete</button>
                                    </div>
                            @endforeach
                        @elseif(old('advantages'))
                            @php ($number = 0)
                            @foreach(old('advantages') as $advantage)
                                @if($advantage != "")
                                    @php ($number++)
                                        <div class="col-md-offset-2 col-md-6 col-xs-8">
                                            <input type="text" class="form-control" id="{{"advantage-".$number}}" placeholder="{{"Advantage ".$number}}" name="advantages[]" value="{{$advantage}}">
                                            <input type="hidden" name="advantage_ids[]" value="0">
                                        </div>
                                        <div class="col-xs-4">
                                            <button class="delete-field btn btn-danger" id ="{{"button-".$number}}" data-target="{{"#advantage-".$number}}">Delete</button>
                                        </div>
                                @endif
                            @endforeach
                        @endif
                    </div>

                    <div class = "form-group">
                        <label for="imgInp" class="col-md-2 col-xs-12 control-label">Service Image</label>
                        <div class ="col-md-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        Browse… <input type="file" id="imgInp" name ="image" accept=".jpg,.jpeg,.bmp,.png">
                                    </span>
                                </span>
                                <input type="text" name="readonly-filename" class="form-control" readonly value="{{isset($service) ? $service->image_link : "" }}">
                            </div>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('image')}}
                        </div>
                        <div class="col-md-6 col-xs-12 col-md-offset-2">
                            <img id="img-upload" src="{{isset($service) ? asset($service->image_link) : ""}}" width="100%">
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