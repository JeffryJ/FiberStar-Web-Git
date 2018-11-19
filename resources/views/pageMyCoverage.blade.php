@extends('layout.pageLayout')

@section('coverage_dependencies')
    <link rel="stylesheet" type="text/css" href="{{asset('css/my_coverage_style.css')}}">
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_API_KEY')}}&libraries=places"></script>
@endsection

@section('content')
    <div class="tint">
        <div class="myCoverage">
            <div class="myCoverage-layer-seperator" id="myCoveragelayerseperatoriD"></div>
            <div class="myCoverage-layer">
                <span class="myCoverage-layer-title"><i class="fas fa-map-marked"></i> Fill Your Information</span><br>
                <span class="myCoverage-layer-stage" id="stage">&nbsp;</span>
                <br>
                <span>
					<select class="myCoverage-layer-title-selector" id="City">
					  	<option value="null">--Pick Your City (Kota)--</option>
					  	@foreach($cities as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>
                        @endforeach
					  	<option value="none">My City Does Not Exist</option>
					</select>
				</span>
                <span>
					<select class="myCoverage-layer-title-selector" id="District">
					</select>
				</span>
                <span>
					<select class="myCoverage-layer-title-selector" id="SubDistrict">
					</select>
				</span>
                <span>
					<select class="myCoverage-layer-title-selector" id="Street">
					</select>
				</span><br>
                <div class="coverage-locator" id="coveragelocator">
                    <div class="popup" id="popup2">
                        <span class="coverage-request-timer" id="coverage-request-timer">
                            <p> Your request has been submitted. This pages will be refreshed in <span id="countdowntimer">5</span> Seconds</p>
				        </span>
                        <form action="{{url('api/coverage/coverage-request')}}" method="post" id="coverage-form">
                            <div class="coverage-form-only" id="coverage-form-only">
                                <div class="row">
                                    <div class="col margin-middle coverage-form-only-title">
                                        Request Form
                                        <div class="cov-exit-window" onclick="exitpopup()">
                                            <i class="fas fa-times"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col margin-right">
                                        <span class="cov-conf-title">Name: </span>
                                    </div>
                                    <div class="col coverage-form-only-input">
                                        <input type="text" name="nameInput" placeholder="Type Your Name" id="name_input">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col margin-right">
                                        <span class="cov-conf-title">Phone Number: </span>
                                    </div>
                                    <div class="col coverage-form-only-input">
                                        <input type="text" name="phoneNumberInput" placeholder="Type Your Phone Number" id="phone_no">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col margin-right">
                                        <span class="cov-conf-title">Email: </span>
                                    </div>
                                    <div class="col coverage-form-only-input">
                                        <input type="text" name="emailInput" placeholder="Type Your Email" id="email_input">
                                    </div>
                                </div>

                                <input type="hidden" name="street_input" id="street_input">
                                <input type="hidden" name="city_input" id="city_input">
                                <input type="hidden" name="district_input" id="district_input">
                                <input type="hidden" name="subdistrict_input" id="subdistrict_input">
                                <input type="hidden" name="postalcode_input" id="postalcode_input">
                                <input type="hidden" name="latitude_input" id="latitude_input">
                                <input type="hidden" name="longitude_input" id="longitude_input">

                                <div class="row">
                                    <div class="col margin-middle coverage-form-only-title">
                                        <input type="submit" class="button-back btn" id="buttonsendrequest" onclick="sendData()" value="Submit">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <span class="white">Please Give Us Your Exact Location</span><br>
                    <div class="pac-card" id="pac-card">
                        <div>
                            <div id="title">
                                FIBERSTAR COVERAGE AREA
                            </div>
                        </div>
                        <div id="pac-container">
                            <input id="pac-input" type="text" placeholder="Find Your Address">
                            <div style="width:80%;">
                                <div id="gmap-suggestions" class="autocomplete-suggestions"></div>
                            </div>
                        </div>
                    </div>
                    <div id="map"></div>

                    <div id="infowindow-content">
                        <span class="you-are-in">You are in:</span>
                        <!-- <img src="" width="16" height="16" id="place-icon"> -->
                        <span id="Lat-Long" class="title"></span><br>
                        <span id="place-name"></span><br>
                        <span id="place-address"></span><br>
                        <button type="button" class="button-after btn" id="buttonforward" onclick="funcforward()">
                            <span>This is</span>
                            <span>my Coordinate.</span>
                        </button>
                    </div>
                    <br>
                </div>
                <div id="youHaveBeen">YOU HAVE BEEN COVERED. You Can Contact Us for Further Information.
                    <br>
                    <button class="button-nip btn" onclick="gotofooter()">Contact Us</button>
                </div>
            </div>
        </div>
        </div>
@endsection

@section('specialjs')
    <script src="{{asset('js/my_coverage_script.js')}}"></script>
    <script src="{{asset('js/gmap_input_script.js')}}"></script>
@endsection