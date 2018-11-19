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

    <script src="{{asset('js/admin/news_form_script.js')}}"></script>
@stop

@section('content_header')
    <h1> {{$title." Article"}} </h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ isset($article) ? url('/admin/news/edit') : url('/admin/news/add')}}" method="post" id="news_form" enctype="multipart/form-data" class="form-horizontal inputform" >
                    {{csrf_field()}}

                    @if(isset($article))
                        <input type="hidden" name="id" value="{{$article->id}}">
                    @endif

                    <div class="form-group">
                        <label for="title" class="col-md-2 col-xs-12 control-label">News Title</label>
                        <div class="col-md-6 col-xs-12">
                            <input type="text" class="form-control" id="title" name="title" value="{{isset($article)? $article->news_title : old('title')}}">
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('title')}}
                        </div>
                    </div>

                    <div class="form-group">
                        <input name="article" type="hidden">
                        <label for="article" class="col-md-2 col-xs-12 control-label">Article</label>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-control editor" data-target="article" id="article">{!! isset($article)? $article->article : old('article') !!}</div>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('article')}}
                        </div>
                    </div>

                    <div class = "form-group">
                        <label for="imgInp" class="col-md-2 col-xs-12 control-label">News Image</label>
                        <div class ="col-md-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        Browse… <input type="file" id="imgInp" name ="image" accept=".jpg,.jpeg,.bmp,.png">
                                    </span>
                                </span>
                                <input type="text" name="readonly-filename" class="form-control" readonly value="{{isset($article) ? $article->image_link : "" }}">
                            </div>
                        </div>
                        <div class="error col-xs-12 col-md-4">
                            {{$errors->first('image')}}
                        </div>

                        <div class="col-md-6 col-xs-12 col-md-offset-2">
                            <img id="img-upload" src="{{isset($article) ? asset($article->image_link) : ""}}" width="100%">
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