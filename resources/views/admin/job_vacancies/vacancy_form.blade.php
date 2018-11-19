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
    <script src="{{asset('js/admin/vacancy_form_script.js')}}"></script>

@stop

@section('content_header')
    <h1> {{$title}} </h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ isset($vacancy) ? url('/admin/job-vacancies/edit') : url('/admin/job-vacancies/add')}}" method="post" id="vacancy_form" enctype="multipart/form-data" class="form-horizontal inputform" >
                    {{csrf_field()}}

                    @if(isset($vacancy))
                        <input type="hidden" name="id" value="{{$vacancy->id}}">
                    @endif

                    <div class="form-group">
                        <label for="title" class="col-md-2 col-xs-12 control-label">Job Title</label>
                        <div class="col-md-6 col-xs-12">
                            <input type="text" class="form-control" id="title" name="title" value="{{isset($vacancy)? $vacancy->job_title : old('title')}}">
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('title')}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="start_date" class="col-md-2 col-xs-12 control-label">Start Date</label>
                        <div class="col-md-6 col-xs-12">
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{isset($vacancy)? $vacancy->start_date->format('Y-m-d') : old('start_date')}}">
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('start_date')}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="end_date" class="col-md-2 col-xs-12 control-label">End Date</label>
                        <div class="col-md-6 col-xs-12">
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{isset($vacancy)? $vacancy->end_date->format('Y-m-d') : old('end_date')}}">
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('end_date')}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="location" class="col-md-2 col-xs-12 control-label">Location</label>
                        <div class="col-md-6 col-xs-12">
                            <input type="text" class="form-control" id="location" name="location" value="{{isset($vacancy)? $vacancy->location : old('location')}}">
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('location')}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="renumeration" class="col-md-2 col-xs-12 control-label">Renumeration</label>
                        <div class="col-md-6 col-xs-12">
                            <input type="text" class="form-control" id="renumeration" name="renumeration" value="{{isset($vacancy)? $vacancy->renumeration : old('renumeration')}}">
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('renumeration')}}
                        </div>
                    </div>

                    <div class="form-group">
                        <input name="qualifications" type="hidden">
                        <label for="qualifications" class="col-md-2 col-xs-12 control-label">Qualifications</label>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-control editor" data-target="qualifications" id="qualifications">{!! isset($vacancy)? $vacancy->qualifications : old('qualifications') !!}</div>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('qualifications')}}
                        </div>
                    </div>

                    <div class="form-group">
                        <input name="responsibilities" type="hidden">
                        <label for="responsibilities" class="col-md-2 col-xs-12 control-label">Responsibilities</label>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-control editor" data-target="responsibilities" id="responsibilities">{!! isset($vacancy)? $vacancy->responsibilities : old('responsibilities') !!}</div>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('responsibilities')}}
                        </div>
                    </div>

                    <div class = "form-group">
                        <label for="imgInp" class="col-md-2 col-xs-12 control-label">Job Image</label>
                        <div class ="col-md-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        Browse… <input type="file" id="imgInp" name ="image" accept=".jpg,.jpeg,.bmp,.png">
                                    </span>
                                </span>
                                <input type="text" name="readonly-filename" class="form-control" readonly value="{{isset($vacancy) ? $vacancy->image_link : "" }}">
                            </div>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('image')}}
                        </div>
                        <div class="col-md-6 col-xs-12 col-md-offset-2">
                            <img id="img-upload" src="{{isset($vacancy) ? asset($vacancy->image_link) : ""}}" width="100%">
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