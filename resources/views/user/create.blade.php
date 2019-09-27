@extends('layouts.master')
@section('title')
{{ $title }} - {{ config('app.name') }}
@endsection
@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ __('Users Management') }}</a></li>
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
                    <form action=" {{ route('users.store') }} " method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="role" class="col-sm-2 col-form-label">{{__('Role')}}</label>
                            <div class="col-sm-10">
                                <select class="form-control @error('role') is-invalid @enderror" name="role" id="role">
                                    <option value="">Choose Role</option>
                                    @foreach ($user_role as $role)
                                        @if(old('role') == $role->id)
                                        <option selected="selected" value="{{$role->id}}">{{$role->role}}</option>
                                        @else
                                        <option value="{{$role->id}}">{{$role->role}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nrp" class="col-sm-2 col-form-label">{{__('NRP')}}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('nrp') is-invalid @enderror" id="nrp" name="nrp" value="{{ old('nrp') }}" autocomplete="off">
                                @error('nrp')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">{{__('Full name')}}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" autocomplete="off">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-2 col-form-label">{{__('Password')}}</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" autocomplete="off">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="confirm_password" class="col-sm-2 col-form-label">{{__('Confirm Password')}}</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password" autocomplete="off">
                                @error('confirm_password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">
                                {{__('Picture')}}
                            </div>
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <img src="{{ asset('img/profile/default.jpg') }}" class="img-thumbnail">
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image">
                                            <label class="custom-file-label" for="image">{{__('Choose file')}}</label>
                                        </div>
                                        @error('image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-success btn-block">
                                    {{__('Add New user')}}
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
