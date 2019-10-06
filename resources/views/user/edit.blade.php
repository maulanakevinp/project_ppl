@extends('layouts.app')
@section('title')
{{ $subtitle }} - {{ config('app.name') }}
@endsection
@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ $title }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $subtitle }}</li>
        </ol>
    </nav>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
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
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold">{{ $subtitle }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update',$user->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <img id="image" src="{{ asset('img/profile/' . $user->image) }}" class="img-thumbnail mb-1">
                        <div class="custom-file mb-3">
                            <input type="file" class="custom-file-input" id="image" name="image">
                            <label class="custom-file-label" for="image">{{__('Choose file')}}</label>
                        </div>
                        <div class="form-group row">
                            <label for="role" class="col-sm-3 col-form-label">{{__('Role')}}</label>
                            <div class="col-sm-9">
                                <select class="form-control {{ $errors->has('role') ? ' is-invalid' : '' }}" name="role" id="role">
                                    <option value="">{{__('user.choose_role')}}</option>
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
                                {!! $errors->first('role', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nip" class="col-sm-3 col-form-label">{{__('NIP')}}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nip" name="nip" value="{{ $user->nip }}">
                                {!! $errors->first('nip', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">{{__('Full name')}}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" value="{{ $user->name }}">
                                {!! $errors->first('name', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-success btn-block">
                                    {{__('user.edit')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
