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
{{-- 
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}
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
        <div class="col-lg-6">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold text-success">{{ $title }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update',$user->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="form-group row">
                            <label for="role" class="col-sm-2 col-form-label">{{__('Role')}}</label>
                            <div class="col-sm-10">
                                <select class="form-control @error('role') is-invalid @enderror" name="role" id="role">
                                    <option value="">Choose Role</option>
                                    @foreach ($user_role as $role)
                                        @if ($role->id == $user->role->id)
                                            <option selected="selected" value="{{$role->id}}">{{$role->role}}</option>                                            
                                        @elseif(old('role') == $role->id)
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
                                <input type="text" class="form-control" id="nrp" name="nrp" value="{{ $user->nrp }}" autocomplete="off">
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
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $user->name }}" autocomplete="off">
                                @error('name')
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
                                        <img src="{{ asset('img/profile/'.$user->image) }}" class="img-thumbnail">
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="image" name="image">
                                            <label class="custom-file-label" for="image">{{__('Choose file')}}</label>
                                        </div>
                                    </div>
                                </div>
                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-success btn-block">
                                    {{__('Edit user')}}
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
