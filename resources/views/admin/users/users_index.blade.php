@extends('adminlte::page')

@section('title','Users')

@section('css')
    <link rel="stylesheet" href="{{asset('css/admin/lte_custom_style.css')}}">
@stop

@section('js')
    <script src="{{asset('js/admin/datatable_adjustment_script.js')}}"></script>
    <script src="{{asset('js/admin/user_script.js')}}"></script>
    <script src="{{asset('js/admin/alert_dismiss_script.js')}}"></script>
@stop

@section('content')

    <div class="alert-container">
        @if($errors->any())
            <div class="alert alert-light alert-error">
                <button type="button" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                @php($i = 1)
                @foreach( $errors->all() as $error)
                    {{$error}}
                    @if($i < count($errors->all()))
                        <br>
                    @endif
                    @php($i++)
                @endforeach
            </div>
        @elseif(session()->has('success'))
            <div class="alert alert-light alert-success">
                <button type="button" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{session()->get('success')}}
            </div>
        @endif
    </div>

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <div class="panel panel-default panel-profile">
                    <div class="panel-heading"><h3>Profile</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">Name</div>
                            <div class="col-md-8">{{$me->name}}</div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">Email</div>
                            <div class="col-md-8">{{$me->email}}</div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">Role</div>
                            <div class="col-md-8">{{$me->role->role_name}}</div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">Registered since</div>
                            <div class="col-md-8">{{$me->created_at->format('jS F Y')}}</div>
                        </div>

                        <div class="row">
                            <div class="col-md-offset-4 col-md-8">
                                <button type="button" class="btn-edit-modal btn btn-primary" data-toggle="modal" data-target="#modal-container" data-id="{{$me->id}}">
                                    Edit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <h3>Active Users</h3>
        </div>

        <div class="row active-users-container">
            <table id ="active-users-table" class="table table-striped table-bordered width-100">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Register Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->role->role_name}}</td>
                        <td>{{$user->created_at->format('jS F Y')}}</td>
                        <td class="action-column">
                            <button type="button" class="btn-edit-modal btn btn-primary" data-toggle="modal" data-target="#modal-container" data-id="{{$user->id}}">
                                Edit
                            </button>
                            <form method="post" class="form-inline form-delete" action="{{url('/admin/users/delete')}}">
                                {{csrf_field()}}
                                <input type="hidden" name="id" value="{{$user->id}}">
                                <input type="submit" class="btn btn-danger" value="Delete">
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="row">
            <h3>Pending Users</h3>
        </div>

        <div class="row">
            <div class="col-12">
                <button type="button" id="btn-invite" class="btn btn-primary" data-toggle="modal" data-target="#modal-container">
                    Invite New User
                </button>
            </div>
        </div>

        <div class="row pending-users-container">
            <table id ="pending-users-table" class="table table-striped table-bordered width-100">
                <thead>
                <tr>
                    <th>Email</th>
                    <th>Invited to be</th>
                    <th>Invited by</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pendings as $pending)
                    <tr>
                        <td>{{$pending->email}}</td>
                        <td>{{$pending->role->role_name}}</td>
                        <td>{{$pending->inviter->name}}</td>
                        <td class="action-column">
                            <form method="post" class="form-inline form-delete" action="{{url('/admin/users/delete-invite')}}">
                                {{csrf_field()}}
                                <input type="hidden" name="id" value="{{$pending->id}}">
                                <input type="submit" class="btn btn-danger" value="Delete">
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{--modal--}}
    <div class="modal fade" id="modal-container" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    </div>

@stop