@extends('layouts.master')
@section('title')
{{ $title }} - {{ config('app.name') }}
@endsection
@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    
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
</div>

    <div class="card mb-3 col-lg-8 p-0">
        <div class="row">
            <div class="col-md-4">
                <img src="{{ asset('img/profile/' . Auth::user()->image) }}" class="card-img" alt="{{ Auth::user()->image }}">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-sm-3 mb-1" for="">{{__('Full Name :')}}</label>
                        <div class="col-sm-9">
                            <h5 class="card-title">{{  Auth::user()->name }}</h5>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 mb-1" for="">{{__('NIP :')}}</label>
                        <div class="col-sm-9">
                            <p class="card-text">{{ Auth::user()->nip }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 mb-1" for="">{{__('Position : ')}}</label>
                        <div class="col-sm-9">
                            <p class="card-text">{{ Auth::user()->role->role }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

@endsection
