@extends('layouts.app')

@section('title', __('forest.detail'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('forest.detail') }}</div>
            <div class="card-body">
                <table class="table table-sm">
                    <tbody>
                        <tr><td>{{ __('forest.nik') }}</td><td>{{ $forest->nik }}</td></tr>
                        <tr><td>{{ __('forest.name') }}</td><td>{{ $forest->name }}</td></tr>
                        <tr><td>{{ __('forest.owner_address') }}</td><td>{{ $forest->owner_address }}</td></tr>
                        <tr><td>{{ __('forest.address') }}</td><td>{{ $forest->address }}</td></tr>
                        <tr><td>{{ __('forest.latitude') }}</td><td>{{ $forest->latitude }}</td></tr>
                        <tr><td>{{ __('forest.longitude') }}</td><td>{{ $forest->longitude }}</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                @can('update', $forest)
                    <a href="{{ route('forests.edit', $forest) }}" id="edit-forest-{{ $forest->id }}" class="btn btn-warning">{{ __('forest.edit') }}</a>
                    <a href="{{ route('forests.index') }}" class="btn btn-link">{{ __('forest.back_to_index') }}</a>
                @endcan
                <a href="{{ route('forest_map.index') }}" class="btn btn-link">{{ __('forest.back_to_our_forest') }}</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ trans('forest.location') }}</div>
            @if ($forest->coordinate)
            <div class="card-body" id="mapid"></div>
            @else
            <div class="card-body">{{ __('forest.no_coordinate') }}</div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
    integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
    crossorigin=""/>

<style>
    #mapid { height: 400px; }
</style>
@endsection
@push('scripts')
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
    crossorigin=""></script>

<script>
    var map = L.map('mapid').setView([{{ $forest->latitude }}, {{ $forest->longitude }}], {{ config('leaflet.detail_zoom_level') }});

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([{{ $forest->latitude }}, {{ $forest->longitude }}]).addTo(map)
        .bindPopup('{!! $forest->map_popup_content !!}');
</script>
@endpush
