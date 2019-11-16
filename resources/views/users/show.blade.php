@extends('layouts.app')
@section('title')
{{ __('user.my_profile') }} - {{ config('app.name') }}
@endsection
@section('content')

    @if ($errors->any())<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold float-left">{{ __('user.detail') }}</h5>
                    <a href="{{url('/dashboard')}}" class="btn btn-success btn-sm float-right">{{__('user.back')}} </a>
                </div>
                <div class="card-body">
                    <img src="{{ asset('img/profile/' . $user->image) }}" class="card-img mb-3" alt="{{ $user->image }}">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                <tr><td>{{ __('user.nip') }}</td><td>:</td><td>{{ $user->nip }}</td></tr>
                                <tr><td>{{ __('user.name') }}</td><td>:</td><td>{{ $user->name }}</td></tr>
                                <tr><td>{{ __('user.role') }}</td><td>:</td><td>{{ $user->role->role }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @if ($user->role_id == 3)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Area Limit</div>
                    <div class="card-body" id="mapid"></div>
                </div>
            </div>
        @endif
    </div>

@endsection
@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
    integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
    crossorigin="" />

<style>
    #mapid {
        height: 400px;
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
    let midLat = (parseFloat(@json($user->latitude1)) + parseFloat(@json($user->latitude2)))/2;
    let midLong = (parseFloat(@json($user->longitude1)) + parseFloat(@json($user->longitude2)))/2;
    
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
    var marker = L.marker([@json($user->latitude1),@json($user->longitude1)],{
        icon: sW
    }).addTo(map).bindPopup('Point of SW : <br> LatLang('+ @json($user->latitude1) +', '+ @json($user->longitude1) +')');

    var marker2 = L.marker([@json($user->latitude2),@json($user->longitude2)],{
        icon: nE
    }).addTo(map).bindPopup('Point of NE : <br> LatLang('+ @json($user->latitude2) +', '+ @json($user->longitude2) +')');

    L.control.locate({
        position: "bottomright"
    }).addTo(map);
</script>
@endpush