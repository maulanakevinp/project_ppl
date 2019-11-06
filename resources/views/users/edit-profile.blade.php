@extends('layouts.app')
@section('title')
{{ __('user.edit_profile') }} - {{ config('app.name') }}
@endsection
@section('content')

    @if ($errors->any())<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold">{{ __('user.edit_profile') }}</h5>
                </div>
                <div class="card-body">
                    <form action=" {{ route('update_profile', ['id' => Auth::user()->id]) }} " method="post" enctype="multipart/form-data">
                        @method('patch')
                        @csrf
                        <div class="text-center mb-3">
                            <img id="image" src="{{ asset('img/profile/' . Auth::user()->image) }}" class="img-thumbnail mb-1">
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
                            <label for="nip" class="col-sm-3 col-form-label">{{__('NIP')}}</label>
                            <div class="col-sm-9">
                                <input disabled type="text" class="form-control" id="nip" name="nip" value="{{ Auth::user()->nip }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">{{__('Full name')}}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" value="{{ Auth::user()->name }}">
                                {!! $errors->first('name', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-success btn-block">
                                    {{__('Edit')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
    var mapCenter = [{{ request('latitude', config('leaflet.map_center_latitude')) }}, {{ request('longitude', config('leaflet.map_center_longitude')) }}];
    var map = L.map('mapid',{drawControl: true}).setView(mapCenter, {{ config('leaflet.zoom_level') }});

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    function locateMarker1() {
        if ({!! json_encode(Auth::user()->latitude1) !!} != null && {!! json_encode(Auth::user()->longitude1) !!} != null ) {
            return [{!! json_encode(Auth::user()->latitude1) !!},{!! json_encode(Auth::user()->longitude1) !!}];
        } else{
            return mapCenter;
        }
    }

    function locateMarker2() {
        if ({!! json_encode(Auth::user()->latitude2) !!} != null && {!! json_encode(Auth::user()->longitude2) !!} != null) {
            return [{!! json_encode(Auth::user()->latitude2) !!},{!! json_encode(Auth::user()->longitude2) !!}];
        } else {
            return ['-8.137279','113.772697'];
        }
    }

    var marker = L.marker(locateMarker1(),{
        draggable: true
    }).addTo(map);

    var marker2 = L.marker(locateMarker2(),{
        draggable: true
    }).addTo(map);

    L.control.locate({
        position: "bottomright"
    }).addTo(map);
</script>
@endpush