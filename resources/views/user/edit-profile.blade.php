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
                    <form action=" {{ route('update-profile', ['id' => Auth::user()->id]) }} " method="post" enctype="multipart/form-data">
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
