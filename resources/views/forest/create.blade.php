@extends('layouts.master')
@section('title')
{{ $title }} - {{ config('app.name') }}
@endsection
@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('forests.index') }}">{{ __('Forests Management') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
        </ol>
    </nav>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if (session('failed'))
    <div class="alert alert-danger">
        {{ session('failed') }}
    </div>
    @endif
    <div class="row mb-5">
        <div class="col-lg-6 mb-3">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold text-success">{{ $title }}</h5>
                </div>
                <div class="card-body">
                    <form action=" {{ route('forests.store') }} " method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="nik" class="col-sm-3 col-form-label">{{__('NIK')}}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik') }}" autocomplete="off">
                                @error('nik')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="owner" class="col-sm-3 col-form-label">{{__('Full name')}}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('owner') is-invalid @enderror" id="owner" name="owner" value="{{ old('owner') }}" autocomplete="off">
                                @error('owner')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="city" class="col-sm-3 col-form-label">{{__('City')}}</label>
                            <div class="col-sm-9">
                                <select class="form-control @error('city') is-invalid @enderror" name="city" id="city">
                                    <option value="">{{__('Choose city')}}</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->city }}</option>
                                    @endforeach
                                </select>
                                @error('city')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="district" class="col-sm-3 col-form-label">{{__('District')}}</label>
                            <div class="col-sm-9">
                                <select class="form-control @error('district') is-invalid @enderror" name="district" id="district">
                                    <option value="">{{__('Choose district')}}</option>
                                </select>
                                @error('district')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-sm-3 col-form-label">{{__('Address')}}</label>
                            <div class="col-sm-9">
                                <textarea rows="5" class="form-control @error('address') is-invalid @enderror" id="address" name="address"  autocomplete="off">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-success btn-block">
                                    {{__('Add New Forest')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header text-success">
                    <h5 class="m-0 pt-1 font-weight-bold text-success">{{__('Maps')}}</h5>
                </div>
                <div class="card-body">
                    <div id='map' style="width: 100%; height: 400px;"></div>
                </div>
            </div>
            <script type="text/javascript" src="https://leafletjs-cdn.s3.amazonaws.com/content/leaflet/master/leaflet.js"></script>
            <script type="text/javascript" src="https://tiles.unwiredmaps.com/js/leaflet-unwired.js"></script>
            <script type="text/javascript">
                // Maps access token goes here
                var key = 'pk.a5c3fbf2119bfb2275b62eddbccd76b3';

                // Add layers that we need to the map
                var streets = L.tileLayer.Unwired({key: key, scheme: "streets"});

                // Initialize the map
                var map = L.map('map', {
                    center: [-8.1688563, 113.7021772], // Map loads with this location as center
                    zoom: 14,
                    scrollWheelZoom: false,
                    layers: [streets] // Show 'streets' by default
                });

                // Add the 'scale' control
                L.control.scale().addTo(map);

                // Add the 'layers' control
                L.control.layers({
                    "Streets": streets
                }).addTo(map);

            </script>

        </div>
    </div>

</div>
<!-- /.container-fluid -->

@endsection
