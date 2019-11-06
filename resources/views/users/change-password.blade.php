@extends('layouts.app')
@section('title')
{{ __('user.change_password') }} - {{ config('app.name') }}
@endsection
@section('content')

<!-- Begin Page Content -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold">{{ __('user.change_password') }}</h5>
                </div>
                <div class="card-body">
                    <form action=" {{ route('update_password', [ 'id' => Auth::user()->id ]) }} " method="post">
                        @method('patch')
                        @csrf
                        <div class="form-group">
                            <label for="current_password">{{__('user.current_password')}}</label>
                            <input type="password" class="form-control {{ $errors->has('current_password') ? ' is-invalid' : '' }}" id="current_password" name="current_password">
                            {!! $errors->first('current_password', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                        </div>
                        <div class="form-group">
                            <label for="new_password">{{__('user.new_password')}}</label>
                            <input type="password" class="form-control {{ $errors->has('new_password') ? ' is-invalid' : '' }}" id="new_password" name="new_password">
                            {!! $errors->first('new_password', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">{{__('user.confirm_password')}}</label>
                            <input type="password" class="form-control {{ $errors->has('confirm_password') ? ' is-invalid' : '' }}" id="confirm_password" name="confirm_password">
                            {!! $errors->first('confirm_password', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block">{{__('user.change_password')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- /.container-fluid -->

@endsection
