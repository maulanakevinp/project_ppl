@extends('layouts.app')

@section('title', __('forest.edit'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        @if (request('action') == 'delete' && $forest)
        @can('delete', $forest)
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
                    {!! $errors->first('forest_id', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                </div>
                <hr style="margin:0">
                <div class="card-body text-danger">{{ __('forest.delete_confirm') }}</div>
                <div class="card-footer">
                    <form method="POST" action="{{ route('forests.destroy', $forest) }}" accept-charset="UTF-8" onsubmit="return confirm(&quot;{{ __('app.delete_confirm') }}&quot;)" class="del-form float-right" style="display: inline;">
                        {{ csrf_field() }} {{ method_field('delete') }}
                        <input name="forest_id" type="hidden" value="{{ $forest->id }}">
                        <button type="submit" class="btn btn-danger">{{ __('app.delete_confirm_button') }}</button>
                    </form>
                    <a href="{{ route('forests.edit', $forest) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                </div>
            </div>
        @endcan
        @else
        <div class="card">
            <div class="card-header">{{ __('forest.edit') }}</div>
            <form method="POST" action="{{ route('forests.update', $forest) }}" accept-charset="UTF-8">
                {{ csrf_field() }} {{ method_field('patch') }}
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude" class="control-label">{{ __('forest.latitude') }}</label>
                                <input id="latitude" type="text" class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}" name="latitude" value="{{ old('latitude', $forest->latitude) }}" required>
                                {!! $errors->first('latitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude" class="control-label">{{ __('forest.longitude') }}</label>
                                <input id="longitude" type="text" class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}" name="longitude" value="{{ old('longitude', $forest->longitude) }}" required>
                                {!! $errors->first('longitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div id="mapid"></div>
                </div>
                <div class="card-footer">
                    <input type="submit" value="{{ __('forest.update') }}" class="btn btn-success">
                    <a href="{{ route('forests.show', $forest) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                    @can('delete', $forest)
                        <a href="{{ route('forests.edit', [$forest, 'action' => 'delete']) }}" id="del-forest-{{ $forest->id }}" class="btn btn-danger float-right">{{ __('app.delete') }}</a>
                    @endcan
                </div>
            </form>
        </div>
    </div>
</div>
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
    var mapCenter = [{{ $forest->latitude }}, {{ $forest->longitude }}];
    var map = L.map('mapid').setView(mapCenter, {{ config('leaflet.detail_zoom_level') }});

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker = L.marker(mapCenter).addTo(map);
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