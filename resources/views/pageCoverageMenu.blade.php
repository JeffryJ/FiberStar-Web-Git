@extends('layout.pageLayout')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('css/coverage_menu_style.css')}}">
    <div class="tint">
        <div class="container-fluid">
            <div class="row" id="row">
                <a class="vc-fp-s50" id="fp_cv_btn_btnlf">
                    <div class="col cv-fp-mid cv-fp-lf-hv">
                        <div class="coverage-fp-div cv-lf-btn">
                            <div class="cv-mid">
                                FIBERSTAR COVERAGE
                            </div>
                        </div>
                    </div>
                </a>
                <a class="vc-fp-s50" id="fp_cv_btn_btnlr">
                    <div class="col cv-fp-mid cv-fp-lf-hv">
                        <div class="coverage-fp-div cv-lr-btn">
                            <div class="cv-mid">
                                FIND MY LOCATION
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('specialjs')
    <script src="{{asset('js/coverage_menu_script.js')}}"></script>
@endsection