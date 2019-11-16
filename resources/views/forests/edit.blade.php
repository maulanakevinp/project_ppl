@extends('layouts.app')

@section('title', __('forest.edit'))

@section('content')
<!-- Notification -->
@if($errors->any())<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<!-- /.Notification -->
@if (request('action') == 'delete' && $forest)
    @if (auth()->user()->id == $forest->creator_id)
        @can('delete', $forest)
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('forest.delete') }}</div>
                    <div class="card-body">
                        <label class="control-label text-primary">{{ __('forest.nik') }}</label>
                        <p>{{ $forest->nik }}</p>
                        <label class="control-label text-primary">{{ __('forest.name') }}</label>
                        <p>{{ $forest->name }}</p>
                        <label class="control-label text-primary">{{ __('forest.owner_address') }}</label>
                        <p>{{ $forest->owner_address }}</p>
                        <label class="control-label text-primary">{{ __('forest.address') }}</label>
                        <p>{{ $forest->address }}</p>
                        <label class="control-label text-primary">{{ __('forest.latitude') }}</label>
                        <p>{{ $forest->latitude }}</p>
                        <label class="control-label text-primary">{{ __('forest.longitude') }}</label>
                        <p>{{ $forest->longitude }}</p>
                        <a href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#fileDetail"><i class="fas fa-file-image"> File Detail</i></a>
                        {!! $errors->first('forest_id', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <hr style="margin:0">
                    <div class="card-body text-danger">{{ __('forest.delete_confirm') }}</div>
                    <div class="card-footer">
                        <form method="POST" action="{{ route('forests.destroy', $forest) }}" accept-charset="UTF-8" onsubmit="return confirm(&quot;{{ __('app.delete_confirm') }}&quot;)" class="del-form float-right" style="display: inline;">
                            @csrf @method('delete')
                            <button type="submit" class="btn btn-danger">{{ __('app.delete_confirm_button') }}</button>
                        </form>
                        <a href="{{ route('forests.edit', $forest) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div id="fileDetail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="detailNIK" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailNIK">File Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                            data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            KTP Scan
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body text-center">
                                        <div class="text-left">
                                            <select onchange="rotateImage('#nik_image',this.value)">
                                                <option value="">Putar</option>
                                                <option value="90">90</option>
                                                <option value="180">180</option>
                                                <option value="270">270</option>
                                                <option value="360">360</option>
                                            </select>
                                        </div>
                                        <img id="nik_image" class="mw-100" src="{{url('img/nik/'.$forest->nik_file) }}" alt="{{ $forest->nik_file }}">
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                            data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Photo
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#accordionExample">
                                    <div class="card-body text-center">
                                        <div class="text-left">
                                            <select onchange="rotateImage('#photo_image',this.value)">
                                                <option value="">Putar</option>
                                                <option value="90">90</option>
                                                <option value="180">180</option>
                                                <option value="270">270</option>
                                                <option value="360">360</option>
                                            </select>
                                        </div>
                                        <img id="photo_image" class="mw-100" src="{{url('img/photo/'.$forest->photo_file) }}" alt="{{ $forest->photo_file }}">
                                    </div>
                                </div>
                            </div>
                        </div>
        
                    </div>
                </div>
            </div>
        </div>
        @endcan
    @endif
@else
    <form method="POST" action="{{ route('forests.update', $forest) }}" accept-charset="UTF-8" enctype="multipart/form-data">
        @csrf @method('patch')
        <div class="row justify-content-center">
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header font-weight-bold">{{ __('forest.edit') }}</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nik" class="control-label">{{ __('forest.nik') }}</label>
                            <input id="nik" type="text" class="form-control{{ $errors->has('nik') ? ' is-invalid' : '' }}" name="nik" value="{{ old('nik', $forest->nik) }}" required>
                            {!! $errors->first('nik', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                        </div>
                        <div class="form-group">
                            <label for="name" class="control-label">{{ __('forest.name') }}</label>
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $forest->name) }}" required>
                            {!! $errors->first('name', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                        </div>
                        <div class="form-group">
                            <label for="owner_address" class="control-label">{{ __('forest.owner_address') }}</label>
                            <textarea id="owner_address" class="form-control{{ $errors->has('owner_address') ? ' is-invalid' : '' }}" name="owner_address" rows="4">{{ old('owner_address', $forest->owner_address) }}</textarea>
                            {!! $errors->first('owner_address', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                        </div>
                        <div class="form-group">
                            <label for="address" class="control-label">{{ __('forest.address') }}</label>
                            <textarea id="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" rows="4">{{ old('address', $forest->address) }}</textarea>
                            {!! $errors->first('address', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                        </div>
                        <div class="form-group">
                            <label for="ktp_scan" class="control-label">{{ __('user.nik_file') }}</label>
                            <div class="text-center">
                                <img id="nik_image" src="{{ asset('img/nik/'.$forest->nik_file) }}" alt="{{ $forest->nik_file }}" class="img-thumbnail">
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
                                <img id="photo_image" src="{{ asset('img/photo/'.$forest->photo_file) }}" alt="{{ $forest->photo_file }}" class="img-thumbnail">
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
                                        name="latitude" value="{{ old('latitude', $forest->latitude) }}" required>
                                    {!! $errors->first('latitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="longitude" class="control-label">{{ __('forest.longitude') }}</label>
                                    <input id="longitude" type="text" class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}"
                                        name="longitude" value="{{ old('longitude', $forest->longitude) }}" required>
                                    {!! $errors->first('longitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div id="mapid"></div>
                    </div>
                    <div class="card-footer">
                        <input type="submit" value="{{ __('forest.update') }}" class="btn btn-success float-right">
                        <a href="{{ route('forests.show', $forest) }}" class="btn btn-outline-secondary float-right">{{ __('app.cancel') }}</a>
                        @can('delete', $forest)
                            <a href="{{ route('forests.edit', [$forest, 'action' => 'delete']) }}" id="del-forest-{{ $forest->id }}" class="btn btn-danger">{{ __('app.delete') }}</a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </form>
@endif
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
function rotateImage(image,degree) {
    $(image).animate({
        transform: degree
    }, {
        step: function (now, fx) {
            $(this).css({
                '-webkit-transform': 'rotate(' + now + 'deg)',
                '-moz-transform': 'rotate(' + now + 'deg)',
                'transform': 'rotate(' + now + 'deg)',
                'margin': '0',
            });
        }
    });
}
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
    var mapCenter = [{{ $forest->latitude }}, {{ $forest->longitude }}];
    var map = L.map('mapid').setView(mapCenter, {{ config('leaflet.detail_zoom_level') }});

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
    }).addTo(map);

    var marker2 = L.marker([@json(auth()->user()->latitude2), @json(auth()->user()->longitude2)], {
        icon: nE
    }).addTo(map);

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
