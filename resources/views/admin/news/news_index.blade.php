@extends('adminlte::page')

@section('title','News')

@section('css')
    <link rel="stylesheet" href="{{asset('css/admin/lte_custom_style.css')}}">
@stop

@section('content_header')
    <h1>News Articles</h1>
@stop

@section('js')
    <script src="{{asset('js/admin/datatable_adjustment_script.js')}}"></script>
@stop

@section('content')
    <a href="{{url('/admin/news/add')}}" class="btn btn-primary btn-add">Add news</a>
    <div class="container-fluid">
        <div class="row news-container">
            <table id ="news-table" class="table table-striped table-bordered width-100">
                <thead>
                    <tr>
                        <th>News Title</th>
                        <th>News Article</th>
                        <th>Date Created</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $article)
                        {{--<img src="{{asset('storage/news/'.$article->image_link)}}" width="100%">--}}
                        <tr>
                            <td class="longtext-column">{{$article->news_title}}</td>
                            <td class="longtext-column">
                                {!! $article->article !!}
                            </td>
                            <td>{{$article->created_at->format('jS F Y')}}</td>
                            <td>
                                <a href="{{asset($article->image_link)}}" target="_blank">
                                    <img src="{{ asset($article->image_link)}}">
                                </a>
                            </td>
                            <td class="action-column">
                                <a class="btn btn-success" target="_blank" href="{{url('/news/'.$article->id)}}">View</a>
                                <a href="{{url('/admin/news/edit/'.$article->id)}}" class="btn btn-primary">Edit</a>
                                <form method="post" class="form-inline form-delete" action="{{url('/admin/news/delete')}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" value="{{$article->id}}">
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