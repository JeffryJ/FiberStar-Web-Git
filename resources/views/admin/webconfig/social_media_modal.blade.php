<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="modalLabel">{{$title}}</h4>
        </div>
        <form class="form-horizontal" action="{{isset($social_media) ? url('/admin/webconfig/social-media/edit') : url('/admin/webconfig/social-media/add')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}

            @if(isset($social_media))
                <input type="hidden" name="id" value="{{$social_media->id}}">
            @endif

            <div class="modal-body">
                <div class="form-group">
                    <label for="url" class="col-md-4 col-xs-12 control-label">URL</label>
                    <div class="col-md-6 col-xs-12">
                        <input type="text" class="form-control" id="url" name="url" value="{{isset($social_media)? $social_media->url : old('url')}}">
                    </div>
                </div>

                <div class = "form-group">
                    <label for="icon" class="col-md-4 col-xs-12 control-label">Social Media Icon</label>
                    <div class ="col-md-6 col-xs-12">
                        <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        Browse… <input type="file" id="icon" name ="icon" accept=".jpg,.jpeg,.bmp,.png">
                                    </span>
                                </span>
                            <input type="text" name="icon-filename" class="form-control" readonly value="{{isset($social_media) ? $social_media->icon_image_link : "" }}">
                        </div>
                    </div>

                    <div class="col-md-2 col-xs-12">
                        <img id="icon-preview" {{isset($social_media) ? 'src='.asset($social_media->icon_image_link) : ""}} >
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>

    </div>
</div>

<script>
    $(document).ready(function(){
        InputToImageLink("#icon","#icon-preview");
    });
</script>