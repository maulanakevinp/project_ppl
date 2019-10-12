@extends('layouts.app')
@section('title')
{{ __('user.add') }} - {{ config('app.name') }}
@endsection
@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ $title }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('user.add') }}</li>
        </ol>
    </nav>
    <!-- /.Breadcrumb -->

    <!-- Notification -->
    @if ($errors->any())<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <!-- /.Notification -->

    <!-- row -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold">{{ __('user.add') }}</h5>
                </div>
                <div class="card-body">
                    <form action=" {{ route('users.store') }} " method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group text-center">
                            <img id="image" src="{{ asset('img/profile/default.jpg') }}" class="img-thumbnail mb-1">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input {{ $errors->has('image') ? ' is-invalid' : '' }}" id="image" name="image">
                                <label class="custom-file-label" for="image">{{__('Choose file')}}</label>
                            </div>
                            {!! $errors->first('image', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                        </div>
                        <div class="form-group row">
                            <label for="role" class="col-sm-3 col-form-label">{{__('user.role')}}</label>
                            <div class="col-sm-9">
                                <select class="form-control {{ $errors->has('role') ? ' is-invalid' : '' }}" name="role" id="role">
                                    <option value="">{{__('user.choose_role')}}</option>
                                    @foreach ($user_role as $role)
                                        @if(old('role') == $role->id)
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
                            <label for="nip" class="col-sm-3 col-form-label">{{__('user.nip')}}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control {{ $errors->has('nip') ? ' is-invalid' : '' }}" id="nip" name="nip" value="{{ old('nip') }}" autocomplete="off">
                                {!! $errors->first('nip', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">{{__('user.name')}}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" value="{{ old('name') }}" autocomplete="off">
                                {!! $errors->first('name', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-success btn-block">
                                    {{__('user.add')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->

@endsection
