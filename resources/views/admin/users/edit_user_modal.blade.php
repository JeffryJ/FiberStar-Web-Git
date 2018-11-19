<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="modalLabel">Edit User</h4>
        </div>
        <form class="form-horizontal" action="{{url('/admin/users/edit')}}" method="post">
            {{csrf_field()}}

            <input type="hidden" name="id" value="{{$user->id}}">

            <div class="modal-body">
                <div class="form-group">
                    <label for="title" class="col-md-4 col-xs-12 control-label">Name</label>
                    <div class="col-md-6 col-xs-12">
                        <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}">
                    </div>
                </div>

                @if($user->id != \Illuminate\Support\Facades\Auth::id())
                    <div class="form-group">
                        <label for="role" class="col-md-4 col-xs-12 control-label">Role</label>
                        <div class="col-md-6 col-xs-12">
                            <select class="form-control" id="role" name="role">
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}" {{$user->role_id == $role->id ? "selected" : ""}}>{{$role->role_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @else
                    <div class="form-group">
                        <div class="col-md-offset-4"><h3>Change Password</h3></div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-md-4 col-xs-12 control-label">New Password</label>
                        <div class="col-md-6 col-xs-12">
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="col-md-4 col-xs-12 control-label">Confirm Password</label>
                        <div class="col-md-6 col-xs-12">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>
                @endif

            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>

    </div>
</div>