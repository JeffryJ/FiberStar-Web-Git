@extends('layout.pageLayout')

@section('coverage_dependencies')
    <link rel="stylesheet" type="text/css" href="{{asset('css/fiberstar_coverage_style.css')}}">
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_API_KEY')}}&libraries=places"></script>
@endsection

@section('content')
    <div class="tint">
        <div id="coverage_coverage_wrapper">
            <div class="pac-card" id="pac-card">
                <div>
                    <div id="title">
                        FIBERSTAR COVERAGE AREA
                    </div>
                    <button class="btn-primary" onclick="SearchMyCoverage()">Search My Coverage</button>
                </div>
                <div id="map"></div>
            </div>
        </div>
    </div>
@endsection

@section('specialjs')
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>--}}
    {{--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXge64YlZticgaOM0hXwM5k4h_FuSjGms&libraries=places&callback=initMap" async defer>--}}
    {{--</script>--}}
    <script>
        var coordinates ={!! $outlines !!};
    </script>
    <script src="{{asset('js/fiberstar_coverage_script.js')}}"></script>
@endsection