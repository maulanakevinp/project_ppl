@extends('layouts.app')

@section('title', __('forest.create'))

@section('content')
<!-- Notification -->
@if($errors->any())<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<!-- /.Notification -->
<form method="POST" action="{{ route('forests.store') }}" accept-charset="UTF-8" enctype="multipart/form-data">
    @csrf
    <div class="row justify-content-center">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header font-weight-bold">{{ __('forest.create') }}</div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="nik" class="control-label">{{ __('forest.nik') }}</label>
                        <input id="nik" type="text" class="form-control{{ $errors->has('nik') ? ' is-invalid' : '' }}" name="nik" value="{{ old('nik') }}" required>
                        {!! $errors->first('nik', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">{{ __('forest.name') }}</label>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>
                        {!! $errors->first('name', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="owner_address" class="control-label">{{ __('forest.owner_address') }}</label>
                        <textarea id="owner_address" class="form-control{{ $errors->has('owner_address') ? ' is-invalid' : '' }}" name="owner_address" rows="4">{{ old('owner_address') }}</textarea>
                        {!! $errors->first('owner_address', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label">{{ __('forest.address') }}</label>
                        <textarea id="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" rows="4">{{ old('address') }}</textarea>
                        {!! $errors->first('address', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="ktp_scan" class="control-label">{{ __('user.nik_file') }}</label>
                        <div class="text-center">
                            <img id="nik_image" src="{{ asset('img/noimage.jpg') }}" class="img-thumbnail">
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input {{ $errors->has('ktp_scan') ? ' is-invalid' : '' }}" id="ktp_scan" name="ktp_scan">
                            <label id="custom-file-label-nik" class="custom-file-label" for="ktp_scan">{{__('Choose file')}}</label>
                        </div>
                        {!! $errors->first('ktp_scan', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="photo" class="control-label">{{ __('user.photo') }}</label>
                        <div class="text-center">
                            <img id="photo_image" src="{{ asset('img/noimage.jpg') }}" class="img-thumbnail">
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input {{ $errors->has('photo_file') ? ' is-invalid' : '' }}" id="photo_file" name="photo_file">
                            <label id="custom-file-label-photo" class="custom-file-label" for="photo">{{__('Choose file')}}</label>
                        </div>
                        {!! $errors->first('photo_file', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header font-weight-bold">Location</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude" class="control-label">{{ __('forest.latitude') }}</label>
                                <input id="latitude" type="text" class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}"
                                    name="latitude"
                                    value="{{ old('latitude', request('latitude', ((float)auth()->user()->latitude1 + (float)auth()->user()->latitude2)/2)) }}">
                                {!! $errors->first('latitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude" class="control-label">{{ __('forest.longitude') }}</label>
                                <input id="longitude" type="text" class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}"
                                    name="longitude"
                                    value="{{ old('longitude', request('longitude', ((float)auth()->user()->longitude1 + (float)auth()->user()->longitude2)/2)) }}">
                                {!! $errors->first('longitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <p class="text-danger"><small>*The marker must be in the area of point of SW and point of NE</small></p>
                    <div id="mapid"></div>
                </div>
                <div class="card-footer">
                    <input type="submit" value="{{ __('forest.create') }}" class="btn btn-success float-right">
                    <a href="{{ route('forests.index') }}" class="btn btn-outline-secondary float-right">{{ __('app.cancel') }}</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
    integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
    crossorigin=""/>

<style>
    #mapid { height: 300px; }
</style>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
    crossorigin=""></script>

<!-- location control -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol/dist/L.Control.Locate.min.css" />

<!-- location control -->
<script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol/dist/L.Control.Locate.min.js" charset="utf-8"></script>
<script>
$(document).ready(function () {
    $("#nik_file").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings("#custom-file-label-nik").addClass("selected").html(fileName);
        readURL1(this);
    });

    function readURL1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#nik_image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#photo_file").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings("#custom-file-label-photo").addClass("selected").html(fileName);
        readURL2(this);
    });

    function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#photo_image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
});
</script>
<script>
    var mapCenter = [{{ old('latitude', request('latitude', ((float)auth()->user()->latitude1 + (float)auth()->user()->latitude2)/2)) }}, {{ old('longitude', request('longitude', ((float)auth()->user()->longitude1 + (float)auth()->user()->longitude2)/2)) }}];
    var map = L.map('mapid').setView(mapCenter, {{ config('leaflet.zoom_level') }});

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var sW = L.icon({
        iconUrl: "{{asset('img/icon/point-sw.png')}}",

        iconSize: [25, 35], // size of the icon
        iconAnchor: [0, 35], // point of the icon which will correspond to marker's location
        popupAnchor: [13, -35] // point from which the popup should open relative to the iconAnchor
    });
    var nE = L.icon({
        iconUrl: "{{asset('img/icon/point-ne.png')}}",

        iconSize: [25, 35], // size of the icon
        iconAnchor: [25, 0], // point of the icon which will correspond to marker's location
        popupAnchor: [0, 0] // point from which the popup should open relative to the iconAnchor
    });
    var marker = L.marker([@json(auth()->user()->latitude1), @json(auth()->user()->longitude1)], {
        icon: sW
    }).addTo(map).bindPopup('Point of SW');

    var marker2 = L.marker([@json(auth()->user()->latitude2), @json(auth()->user()->longitude2)], {
        icon: nE
    }).addTo(map).bindPopup('Point of NE');
    
    var greenIcon = L.icon({
        iconUrl: "{{asset('img/icon/leaf-green.png')}}",
        shadowUrl: "{{asset('img/icon/leaf-shadow.png')}}",

        iconSize: [38, 95], // size of the icon
        shadowSize: [50, 64], // size of the shadow
        iconAnchor: [22, 94], // point of the icon which will correspond to marker's location
        shadowAnchor: [4, 62], // the same for the shadow
        popupAnchor: [-3, -76] // point from which the popup should open relative to the iconAnchor
    });
    var marker = L.marker(mapCenter,{icon:greenIcon}).addTo(map);
    function updateMarker(lat, lng) {
        marker
        .setLatLng([lat, lng])
        .bindPopup("Your location :  " + marker.getLatLng().toString())
        .openPopup();
        return false;
    };

    map.on('click', function(e) {
        let latitude = e.latlng.lat.toString().substring(0, 15);
        let longitude = e.latlng.lng.toString().substring(0, 15);
        $('#latitude').val(latitude);
        $('#longitude').val(longitude);
        updateMarker(latitude, longitude);
    });

    var updateMarkerByInputs = function() {
        return updateMarker( $('#latitude').val() , $('#longitude').val());
    }
    $('#latitude').on('input', updateMarkerByInputs);
    $('#longitude').on('input', updateMarkerByInputs);
    
    L.control.locate({
        position: "bottomright"
    }).addTo(map);
</script>
@endpush
