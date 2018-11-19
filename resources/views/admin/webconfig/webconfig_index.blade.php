@extends('adminlte::page')

@section('title', 'Web Configurations')

@section('css')
    <link rel="stylesheet" href="{{asset('css/admin/lte_custom_style.css')}}">
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@stop

@section('js')
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <script src="{{asset('js/admin/quill_editor_script.js')}}"></script>
    <script src="{{asset('js/admin/image_input_script.js')}}"></script>

    <script src="{{asset('js/admin/phone_input_script.js')}}"></script>

    <script src="{{asset('js/admin/datatable_adjustment_script.js')}}"></script>

    <script src="{{asset('js/admin/webconfig_script.js')}}"></script>
    <script src="{{asset('js/admin/alert_dismiss_script.js')}}"></script>
@stop

@section('content_header')
    <h1>Web Configurations</h1>
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
            <div class="col-md-12">
                <form action="{{ url('/admin/webconfig/update') }}" method="post" id="webconfig_form" enctype="multipart/form-data" class="form-horizontal inputform" >
                    {{csrf_field()}}

                    @if(isset($data))
                        <input type="hidden" name="id" value="{{$data->id}}">
                    @endif
                    <input type="hidden" id="to_be_deleted" name="to_be_deleted">

                    <div class = "form-group">
                        <label for="logo_image" class="col-md-2 col-xs-12 control-label">Logo</label>
                        <div class ="col-md-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        Browse… <input type="file" id="logo_image" name ="logo_image" accept=".jpg,.jpeg,.bmp,.png">
                                    </span>
                                </span>
                                <input type="text" name="logo_filename" class="form-control" readonly value="{{isset($data) ? $data->logo_image_link : "" }}">
                            </div>
                        </div>
                        {{--<div class="error col-xs-12 col-md-4">--}}
                            {{--{{$errors->first('corporate_values_image')}}--}}
                            {{--{{$errors->first('corporate_values_filename')}}--}}
                        {{--</div>--}}

                        <div class="col-md-6 col-xs-12 col-md-offset-2">
                            <img class="image-preview" id="logo_image_preview" src="{{isset($data) ? asset($data->logo_image_link) : ""}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="company_name" class="col-md-2 col-xs-12 control-label">Company Details</label>

                        <div class="col-md-6 col-xs-12">
                            <input type="text" class="form-control" placeholder="Company Name" id="company_name" name="company_name" value="{{old('company_name')? old('company_name'): (isset($data)? $data->company_name : "")}}">
                        </div>
                        {{--<div class="error col-xs-12 col-md-4">--}}
                            {{--{{$errors->first('company_name')}}--}}
                        {{--</div>--}}

                        <input name="address" type="hidden">
                        <div class="col-md-offset-2 col-md-6 col-xs-12">
                            <div class="form-control" data-target="address" id="address">{!! old('address')? old('address'): (isset($data)? $data->address : "")!!}</div>
                        </div>
                        {{--<div class="error col-xs-12 col-md-4">--}}
                            {{--{{$errors->first('address')}}--}}
                        {{--</div>--}}

                        <div class="col-md-offset-2 col-md-6 col-xs-12">
                            {{-- Validate .phone-input class to only allow + and digits --}}
                            <div class="col-md-3 no-padding">
                                <label class="control-label" for="phone">Phone</label>
                            </div>
                            <div class="col-md-9 no-padding">
                                <input type="text" placeholder="Phone Number" class="form-control phone-input" id="phone" name="phone" value="{{old('phone')? old('phone'): (isset($data)? $data->phone : "")}}">
                            </div>
                        </div>
                        {{--<div class="error col-xs-12 col-md-4">--}}
                            {{--{{$errors->first('phone')}}--}}
                        {{--</div>--}}

                        <div class="col-md-offset-2 col-md-6 col-xs-12">
                            {{-- Validate .phone-input class to only allow + and digits --}}
                            <div class="col-md-3 no-padding">
                                <label class="control-label" for="fax">Fax</label>
                            </div>
                            <div class="col-md-9 no-padding">
                                <input type="text" placeholder="Fax Number" class="form-control phone-input" id="fax" name="fax" value="{{old('fax')? old('fax'): (isset($data)? $data->fax : "")}}">
                            </div>
                        </div>

                        {{--<div class="error col-xs-12 col-md-4">--}}
                            {{--{{$errors->first('fax')}}--}}
                        {{--</div>--}}

                    </div>

                    <div class="form-group">
                        <label for="contact_email" class="col-md-2 col-xs-12 control-label">Contact Us Email</label>
                        <div class="col-md-6 col-xs-12">
                            <input type="email" class="form-control" placeholder="Email" id="contact_email" name="contact_email" value="{{old('contact_email')? old('contact_email'): (isset($data)? $data->contact_email : "")}}">
                        </div>
                        {{--<div class="error col-xs-12 col-md-4">--}}
                            {{--{{$errors->first('contact_email')}}--}}
                        {{--</div>--}}
                    </div>

                    <div class="form-group">
                        <label for="service_name" class="col-xs-6 col-md-2 control-label">Contact Us CC</label>
                        <div class="col-xs-6 col-md-10">
                            <button class="btn btn-primary" id="btn-add-cc">Add CC</button>
                        </div>
                    </div>

                    <div class="form-group" id="cc-container">
                        @if(old('ccs'))
                            @php ($number = 0)
                            @foreach(old('ccs') as $cc)
                                @if($cc != "")
                                    @php ($number++)
                                    <div class="col-md-offset-2 col-md-6 col-xs-8">
                                        <input type="text" class="form-control" id="{{"cc-".$number}}" placeholder="{{"CC ".$number}}" name="ccs[]" value="{{$cc}}">
                                        <input type="hidden" name="cc_ids[]" value="{{old("cc_ids")[$number-1]}}">
                                    </div>
                                    <div class="col-xs-4">
                                        <button class="delete-field btn btn-danger" id ="{{"button-".$number}}" data-target="{{"#cc-".$number}}">Delete</button>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            @php ($number = 0)
                            @foreach($ccs as $cc)
                                @php ($number++)
                                <div class="col-md-offset-2 col-md-6 col-xs-8">
                                    <input type="text" class="form-control" id="{{"cc-".$number}}" placeholder="{{"CC ".$number}}" name="ccs[]" value="{{$cc->email}}">
                                    <input type="hidden" name="cc_ids[]" value="{{$cc->id}}">
                                </div>
                                <div class="col-xs-4">
                                    <button class="delete-field btn btn-danger" id ="{{"button-".$number}}" data-target="{{"#cc-".$number}}">Delete</button>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class = "form-group">
                        <label for="logo_image" class="col-md-2 col-xs-12 control-label">Customer Care Image</label>
                        <div class ="col-md-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        Browse… <input type="file" id="cuscare_image" name ="cuscare_image" accept=".jpg,.jpeg,.bmp,.png">
                                    </span>
                                </span>
                                <input type="text" name="cuscare_filename" class="form-control" readonly value="{{isset($data) ? $data->customer_care_image_link : "" }}">
                            </div>
                        </div>
                        {{--<div class="error col-xs-12 col-md-4">--}}
                        {{--{{$errors->first('corporate_values_image')}}--}}
                        {{--{{$errors->first('corporate_values_filename')}}--}}
                        {{--</div>--}}

                        <div class="col-md-6 col-xs-12 col-md-offset-2">
                            <img class="image-preview" id="cuscare_image_preview" src="{{isset($data) ? asset($data->customer_care_image_link) : ""}}">
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

        <div class="row half-page">
            <div class="col-md-6 col-xs-12">
                <div class="row">
                    <h4>Social Media</h4>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="button" id="btn-add-socmed-modal" class="btn btn-primary" data-toggle="modal" data-target="#modal-container">
                            Add Social Media
                        </button>
                    </div>
                </div>

                <div class="row padded-table">
                    <table id="social-media-table"  class="table table-striped table-bordered width-100">
                        <thead>
                        <tr>
                            <th>Social Media Icon</th>
                            <th>URL</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($socmeds as $socmed)
                            <tr>
                                <td><img src="{{asset($socmed->icon_image_link)}}"></td>
                                <td class="longtext-column">{{$socmed->url}}</td>
                                <td class="action-column">
                                    <button type="button" class="btn-edit-socmed-modal btn btn-primary" data-toggle="modal" data-target="#modal-container" data-id="{{$socmed->id}}">
                                        Edit
                                    </button>
                                    <form method="post" class="form-inline form-delete" action="{{url('/admin/webconfig/social-media/delete')}}">
                                        {{csrf_field()}}
                                        <input type="hidden" name="id" value="{{$socmed->id}}">
                                        <input type="submit" class="btn btn-danger" value="Delete">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-6 col-xs-12">
                <div class="row">
                    <h4>Bing Map API Keys</h4>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="button" id="btn-add-apikey-modal" class="btn btn-primary" data-toggle="modal" data-target="#modal-container">
                            Add API Key
                        </button>
                    </div>
                </div>

                <div class="row padded-table">
                    <table id="bing-key-table"  class="table table-striped table-bordered width-100">
                        <thead>
                        <tr>
                            <th>API Key</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($apikeys as $apikey)
                            <tr>
                                <td class="longtext-column">{{$apikey->api_key}}</td>
                                <td class="action-column">
                                    <button type="button" class="btn-edit-apikey-modal btn btn-primary" data-toggle="modal" data-target="#modal-container" data-id="{{$apikey->id}}">
                                        Edit
                                    </button>
                                    <form method="post" class="form-inline form-delete" action="{{url('/admin/webconfig/bing-api-key/delete')}}">
                                        {{csrf_field()}}
                                        <input type="hidden" name="id" value="{{$apikey->id}}">
                                        <input type="submit" class="btn btn-danger" value="Delete">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-container" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    </div>
@stop