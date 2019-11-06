@extends('layouts.app')
@section('title')
{{ $subtitle }} - {{ config('app.name') }}
@endsection
@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ $title }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $subtitle }}</li>
        </ol>
    </nav>
    @if ($errors->any())<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <form action="{{ route('users.update',$user->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="row justify-content-center">
            <div class="col-md-6 mb-3">
                <div class="card shadow h-100">
                    <div class="card-header">
                        <h5 class="m-0 pt-1 font-weight-bold">{{ $subtitle }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <img id="image" src="{{ asset('img/profile/' . $user->image) }}" class="img-thumbnail mb-1">
                        </div>
                        <div class="form-group row">
                            <label for="image" class="col-sm-3 col-form-label">{{ __('user.image') }}</label>
                            <div class="col-sm-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image" name="image">
                                    <label class="custom-file-label" for="image">{{__('Choose file')}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="role" class="col-sm-3 col-form-label">{{__('role.role')}}</label>
                            <div class="col-sm-9">
                                <select class="form-control {{ $errors->has('role') ? ' is-invalid' : '' }}" name="role" id="role">
                                    <option value="">{{__('user.choose_role')}}</option>
                                    @foreach ($user_role as $role)
                                        @if (old('role',$role->id) == $user->role->id)
                                            <option selected="selected" value="{{$role->id}}">{{$role->role}}</option>                                         
                                        @else
                                            <option value="{{$role->id}}">{{$role->role}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                {!! $errors->first('role', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nip" class="col-sm-3 col-form-label">{{__('NIP')}}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nip" name="nip" value="{{ old('nip',$user->nip) }}">
                                {!! $errors->first('nip', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">{{__('Full name')}}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" value="{{ old('name',$user->name) }}">
                                {!! $errors->first('name', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                        <div class="float-right">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">{{ __('user.back') }}</a>
                            <button type="submit" class="btn btn-success">{{__('user.edit')}}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6" id="area">
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-0 pt-1 font-weight-bold">Area Limit</h5>                        
                    </div>
                    <div class="card-body">
                        <div class="form-group" >
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="latitude1" class="control-label">Latitude 1</label>
                                        <input id="latitude1" type="text"
                                            class="form-control{{ $errors->has('latitude1') ? ' is-invalid' : '' }}" name="latitude1"
                                            value="{{ old('latitude1', $user->latitude1) }}" required>
                                        {!! $errors->first('latitude1', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="longitude1" class="control-label">Longitude 1</label>
                                        <input id="longitude1" type="text"
                                            class="form-control{{ $errors->has('longitude1') ? ' is-invalid' : '' }}" name="longitude1"
                                            value="{{ old('longitude1', $user->longitude1) }}" required>
                                        {!! $errors->first('longitude1', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="latitude2" class="control-label">Latitude 2</label>
                                        <input id="latitude2" type="text"
                                            class="form-control{{ $errors->has('latitude2') ? ' is-invalid' : '' }}" name="latitude2"
                                            value="{{ old('latitude2', $user->latitude2) }}" required>
                                        {!! $errors->first('latitude2', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="longitude2" class="control-label">Longitude 2</label>
                                        <input id="longitude2" type="text"
                                            class="form-control{{ $errors->has('longitude2') ? ' is-invalid' : '' }}" name="longitude2"
                                            value="{{ old('longitude2', $user->longitude2) }}" required>
                                        {!! $errors->first('longitude2', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                            <p class="text-danger"><small>*Drag the marker and place the Point of SW in the lower left of Point of NE and the
                                    Point of NE in the upper right of Point of SW</small></p>
                            <div id="mapid"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
    integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
    crossorigin="" />

<style>
    #mapid {
        height: 300px;
    }

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
$('document').ready(function(){
    if ($('#role').val() == 3) {
        $('#area').show();
    } else {
        $('#area').hide();
    }
    $('#role').on('change',function(){
        const role = $(this).val();
        if(role == 3){
            $('#area').show();
        }else{
            $('#area').hide();  
        }
    });
    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
});
</script>
<script>
    let midLat = (parseFloat($('#latitude1').val()) + parseFloat($('#latitude2').val()))/2;
    let midLong = (parseFloat($('#longitude1').val()) + parseFloat($('#longitude2').val()))/2;
    
    var mapCenter = [midLat,midLong];
    var map = L.map('mapid',{drawControl: true}).setView(mapCenter, {{ config('leaflet.zoom_level') }});

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var sW = L.icon({
        iconUrl: "{{asset('img/icon/point-sw.png')}}",

        iconSize:     [25, 35], // size of the icon
        iconAnchor:   [0, 35], // point of the icon which will correspond to marker's location
        popupAnchor:  [13, -35] // point from which the popup should open relative to the iconAnchor
    });
    var nE = L.icon({
        iconUrl: "{{asset('img/icon/point-ne.png')}}",

        iconSize:     [25, 35], // size of the icon
        iconAnchor:   [25, 0], // point of the icon which will correspond to marker's location
        popupAnchor:  [0, 0] // point from which the popup should open relative to the iconAnchor
    });
    var marker = L.marker([$('#latitude1').val(),$('#longitude1').val()],{
        draggable: true,
        icon: sW
    }).addTo(map);

    var marker2 = L.marker([$('#latitude2').val(),$('#longitude2').val()],{
        draggable: true,
        icon: nE
    }).addTo(map);

    marker.on('dragend', function (e) {
        $('#latitude1').val(marker.getLatLng().lat.toString().substring(0, 15));
        $('#longitude1').val(marker.getLatLng().lng.toString().substring(0, 15));
    });
    marker2.on('dragend', function (e) {
        $('#latitude2').val(marker2.getLatLng().lat.toString().substring(0, 15));
        $('#longitude2').val(marker2.getLatLng().lng.toString().substring(0, 15));
    });
    marker.on('click',function(e){
        marker.bindPopup("Point of SW : "+String(marker.getLatLng()));
    });
    marker2.on('click',function(e){
        marker2.bindPopup("Point of NE : "+String(marker2.getLatLng()));
    });

    function updateMarker1(lat, lng) {
        marker.setLatLng([lat, lng]);
        return false;
    };
    var updateMarkerByInputs1 = function() {
        return updateMarker1( $('#latitude1').val() , $('#longitude1').val());
    }
    $('#latitude1').on('keyup', updateMarkerByInputs1);
    $('#longitude1').on('keyup', updateMarkerByInputs1);

    function updateMarker2(lat, lng) {
        marker2.setLatLng([lat, lng]);
        return false;
    };
    var updateMarkerByInputs2 = function() {
        return updateMarker2( $('#latitude2').val() , $('#longitude2').val());
    }
    $('#latitude2').on('keyup', updateMarkerByInputs2);
    $('#longitude2').on('keyup', updateMarkerByInputs2);

    L.control.locate({
        position: "bottomright"
    }).addTo(map);
</script>
@endpush