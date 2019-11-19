@extends('layouts.app')

@section('title', __('forest.detail'))

@section('content')
<!-- Notification -->
@if ($errors->any())<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<!-- /.Notification -->
<div class="row justify-content-center">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header">{{ __('forest.detail') }}</div>
            <div class="card-body">
                <table class="table table-sm">
                    <tbody>
                        <tr>
                            <td>{{ __('forest.creator') }}</td>
                            <td>
                                @if (auth()->user() != null && auth()->user()->role_id == 2 )
                                    <a href="{{ route('users.show',$forest->creator_id) }}">{{ $forest->creator->name }}</a>
                                @else
                                    {{ $forest->creator->name }}
                                @endif
                            </td>
                        </tr>
                        <tr><td>{{ __('forest.nik') }}</td><td>{{ $forest->nik }}</td></tr>
                        <tr><td>{{ __('forest.name') }}</td><td>{{ $forest->name }}</td></tr>
                        <tr><td>{{ __('forest.owner_address') }}</td><td>{{ $forest->owner_address }}</td></tr>
                        <tr><td>{{ __('forest.address') }}</td><td>{{ $forest->address }}</td></tr>
                        <tr><td>{{ __('forest.latitude') }}</td><td>{{ $forest->latitude }}</td></tr>
                        <tr><td>{{ __('forest.longitude') }}</td><td>{{ $forest->longitude }}</td></tr>
                        @if (auth()->user() != null)
                            @if (auth()->user()->role_id == 2 || auth()->user()->role_id == 3)
                                <tr><td>{{ __('forest.file') }}</td><td><a href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#fileDetail"><i class="fas fa-file-image"> File Detail</i></a></td></tr>
                                <tr class="p-0">
                                    <td>Status</td>
                                    <td>
                                        @if($forest->verify == 1) <label class="text-success">Approved <i class="fas fa-check"></i></label> @elseif($forest->verify == -1 ) <label class="text-danger">Rejected <i class="fas fa-times"></i></label> @else <label class="text-dark">Not yet approved <i class="fas fa-info-circle"></i></label> @endif
                                    </td>
                                </tr>
                            @endif
                            @if (auth()->user()->role_id == 2)
                            <tr>
                                <td>Verification</td>
                                <td>
                                    <form class="float-left" action="{{ route('forest.approving', ['forest' => $forest->id]) }}" method="post">
                                        @csrf
                                        @method('put')
                                        <button class="btn btn-sm @if($forest->verify == 1) btn-success @else btn-outline-success @endif" type="submit">Approve</button>
                                    </form>
                                    <a class="btn btn-sm @if($forest->verify == -1) btn-danger @else btn-outline-danger @endif" data-toggle="collapse" href="#declineVerificationModal">Decline</a>
                                    <div class="collapse multi-collapse" id="declineVerificationModal">
                                        <form action="{{ route('forest.rejecting', ['forest' => $forest->id]) }}" method="post">
                                            @csrf
                                            @method('patch')
                                            <div class="form-group">
                                                <div class="col-form-label">Reason for rejection</div>
                                                <textarea class="form-control" name="reason" id="reason" rows="2">{{ old('reason', $forest->reason) }}</textarea>
                                            </div>
                                            <button class="btn btn-primary" type="submit">Verify</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        @endif
                    </tbody>
                </table>
                
            </div>
            <div class="card-footer">
                @can('update', $forest)
                    @if ($forest->creator_id == Auth::user()->id)
                        <a href="{{ route('forests.edit', $forest) }}" id="edit-forest-{{ $forest->id }}" class="btn btn-warning">{{ __('forest.edit') }}</a>
                    @endif
                @endcan
                <a href="{{ url('/') }}" class="btn btn-link">{{ __('forest.back_to_our_forest') }}</a>
                @if (Auth::user() != null)
                    @if (Auth::user()->role_id == 2)
                        <a href="{{ url('/dashboard') }}" class="btn btn-link">{{ __('forest.back_to_dashboard') }}</a>                    
                    @elseif(Auth::user()->role_id == 3)
                        <a href="{{ route('forests.index') }}" class="btn btn-link">{{ __('forest.back_to_index') }}</a>
                    @endif
                @endif
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
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne"
                                    aria-expanded="true" aria-controls="collapseOne">
                                    KTP Scan
                                </button>
                            </h2>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="text-left">
                                    <select onchange="rotateImage('#nik_image',this.value)">
                                        <option value="">Putar</option>
                                        <option value="90">90</option>
                                        <option value="180">180</option>
                                        <option value="270">270</option>
                                        <option value="360">360</option>
                                    </select>
                                </div>
                                <div class="text-center">
                                    <img id="nik_image" class="mw-100" src="{{url('img/nik/'.$forest->nik_file) }}" alt="{{ $forest->nik_file }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h2 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo"
                                    aria-expanded="false" aria-controls="collapseTwo">
                                    Photo
                                </button>
                            </h2>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="text-left">
                                    <select onchange="rotateImage('#photo_image',this.value)">
                                        <option value="">Putar</option>
                                        <option value="90">90</option>
                                        <option value="180">180</option>
                                        <option value="270">270</option>
                                        <option value="360">360</option>
                                    </select>
                                </div>
                                <div class="text-center">
                                    <img id="photo_image" class="mw-100" src="{{url('img/photo/'.$forest->photo_file) }}" alt="{{ $forest->photo_file }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
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
    var map = L.map('mapid').setView([{{ $forest->latitude }}, {{ $forest->longitude }}], {{ config('leaflet.detail_zoom_level') }});

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
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
    L.marker([{{ $forest->latitude }}, {{ $forest->longitude }}] ,{icon:greenIcon}).addTo(map)
        .bindPopup('{!! $forest->map_popup_content !!}');
</script>
@endpush
