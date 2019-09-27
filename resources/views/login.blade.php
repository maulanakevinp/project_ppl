@extends('layouts.app')
@section('title','Login')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card o-hidden border-0 shadow-lg my-5" style="background: rgba(255,255,255,0.7)">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">{{ __('Login') }} {{ config('app.name') }}</h1>
                                </div>
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
                                <form class="user" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group row">
                                        <input id="nrp" type="text" class="form-control form-control-user @error('nrp') is-invalid @enderror" name="nrp" value="{{ old('nrp') }}" autofocus placeholder="Enter NRP...">
                                        @error('nrp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <input id="password" type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" placeholder="Password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-success btn-user btn-block">
                                        {{ __('Login') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
