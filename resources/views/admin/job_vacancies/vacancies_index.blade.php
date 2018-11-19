@extends('adminlte::page')

@section('title','Job Vacancies')

@section('css')
    <link rel="stylesheet" href="{{asset('css/admin/lte_custom_style.css')}}">
@stop

@section('content_header')
    <h1>Job Vacancies</h1>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            $('#vacancies-table').DataTable({
                "scrollX" : true,
                "order": []
            });
        });
    </script>
@stop

@section('content')
    <a href="{{url('/admin/job-vacancies/add')}}" class="btn btn-primary btn-add">Add Job Vacancy</a>
    <div class="container-fluid">
        <div class="row vacancies-container">
            <table id ="vacancies-table" class="table table-striped table-bordered width-100">
                <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Period</th>
                    <th>Location</th>
                    <th>Renumeration</th>
                    <th>Qualifications</th>
                    <th>Responsibilities</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($vacancies as $vacancy)
                        <tr>
                            <td>{{$vacancy->job_title}}</td>
                            <td>{{$vacancy->start_date->format('j M Y')." - ".$vacancy->end_date->format('j M Y')}}</td>
                            <td>{{$vacancy->location}}</td>
                            <td>{{$vacancy->renumeration}}</td>
                            <td class="longtext-column">{{$vacancy->qualifications}}</td>
                            <td class="longtext-column">{{$vacancy->responsibilities}}</td>
                            <td>
                                <a href="{{asset($vacancy->image_link)}}" target="_blank"><img src="{{ asset($vacancy->image_link)}}"></a>
                            </td>
                            <td class="action-column">
                                <a class="btn btn-success" target="_blank" href="{{url('/job/'.$vacancy->id)}}">View</a>
                                <a href="{{url('/admin/job-vacancies/edit/'.$vacancy->id)}}" class="btn btn-primary">Edit</a>
                                <form method="post" class="form-inline form-delete" action="{{url('/admin/job-vacancies/delete')}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" value="{{$vacancy->id}}">
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