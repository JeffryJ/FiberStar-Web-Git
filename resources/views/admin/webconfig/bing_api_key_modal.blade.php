<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="modalLabel">{{$title}}</h4>
        </div>
        <form class="form-horizontal" action="{{isset($apikey) ? url('/admin/webconfig/bing-api-key/edit') : url('/admin/webconfig/bing-api-key/add')}}" method="post">
            {{csrf_field()}}

            @if(isset($apikey))
                <input type="hidden" name="id" value="{{$apikey->id}}">
            @endif

            <div class="modal-body">
                <div class="form-group">
                    <label for="api_key" class="col-md-4 col-xs-12 control-label">API Key</label>
                    <div class="col-md-6 col-xs-12">
                        <input type="text" class="form-control" id="api_key" name="api_key" value="{{isset($apikey)? $apikey->api_key : ""}}">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>

    </div>
</div>