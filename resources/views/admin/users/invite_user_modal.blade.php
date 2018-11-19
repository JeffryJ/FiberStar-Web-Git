<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="modalLabel">Invite User</h4>
        </div>
        <form class="form-horizontal" action="{{url('/admin/users/invite')}}" method="post">
            {{csrf_field()}}

            <div class="modal-body">
                <div class="form-group">
                    <label for="email" class="col-md-2 col-xs-12 control-label">Email</label>
                    <div class="col-md-6 col-xs-12">
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                </div>

                <div class="form-group">
                    <label for="role" class="col-md-2 col-xs-12 control-label">Invite as</label>
                    <div class="col-md-6 col-xs-12">
                        <select class="form-control" id="role" name="role">
                            @foreach($roles as $role)
                                <option value="{{$role->id}}" >{{$role->role_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>

    </div>
</div>