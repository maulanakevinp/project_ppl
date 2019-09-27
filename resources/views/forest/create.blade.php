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
    <div class="row">
        <div class="col-lg-10">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold text-success">{{ $title }}</h5>
                </div>
                <div class="card-body">
                    <form action=" {{ route('forests.store') }} " method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="nik" class="col-sm-2 col-form-label">{{__('NIK')}}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik') }}" autocomplete="off">
                                @error('nik')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="owner" class="col-sm-2 col-form-label">{{__('Full name')}}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('owner') is-invalid @enderror" id="owner" name="owner" value="{{ old('owner') }}" autocomplete="off">
                                @error('owner')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="city" class="col-sm-2 col-form-label">{{__('City')}}</label>
                            <div class="col-sm-10">
                                <select class="form-control @error('city') is-invalid @enderror" name="city" id="city">
                                    <option value="">Choose City</option>
                                </select>
                                @error('city')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="village" class="col-sm-2 col-form-label">{{__('Village')}}</label>
                            <div class="col-sm-10">
                                <select class="form-control @error('village') is-invalid @enderror" name="village" id="village">
                                    <option value="">Choose Village</option>
                                </select>
                                @error('village')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-sm-2 col-form-label">{{__('Address')}}</label>
                            <div class="col-sm-10">
                                <textarea rows="5" class="form-control @error('address') is-invalid @enderror" id="address" name="address"  autocomplete="off">
                                    {{ old('address') }}
                                </textarea>
                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-success btn-block">
                                    {{__('Add New Forest')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->


@endsection
