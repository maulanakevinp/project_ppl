@extends('layouts.app')
@section('title')
{{ __('user.my_profile') }} - {{ config('app.name') }}
@endsection
@section('content')

    @if ($errors->any())<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold float-left">{{ __('user.detail') }}</h5>
                    <a href="{{url('/dashboard')}}" class="btn btn-success btn-sm float-right">{{__('user.back')}} </a>
                </div>
                <div class="card-body">
                    <img src="{{ asset('img/profile/' . $user->image) }}" class="card-img mb-3" alt="{{ $user->image }}">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                <tr><td>{{ __('user.nip') }}</td><td>:</td><td>{{ $user->nip }}</td></tr>
                                <tr><td>{{ __('user.name') }}</td><td>:</td><td>{{ $user->name }}</td></tr>
                                <tr><td>{{ __('user.role') }}</td><td>:</td><td>{{ $user->role->role }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
