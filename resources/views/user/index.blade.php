@extends('layouts.app')
@section('title')
{{ __('user.user_management') }} - {{ config('app.name') }}
@endsection
@section('content')

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

    <div class="card shadow mb-4">
        <div class="card-header py-3 ">
            <h5 class="m-0 pt-1 font-weight-bold float-left">{{ __('user.user_management') }}</h5>
            <div class="btn-group float-right">
                <a href="{{route('users.trash')}}" class="btn btn-sm btn-warning">{{ __('user.user_deleted') }}</a>
                <a href="{{route('users.create')}}" class="btn btn-sm btn-success">{{ __('user.add') }}</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>{{__('user.nip')}}</th>
                            <th>{{__('user.name')}}</th>
                            <th>{{__('user.role')}}</th>
                            <th>{{__('user.action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->nip }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->role->role }}</td>
                            <td>
                                <a href="{{route('users.edit',$user->id)}}" class="badge badge-warning">{{__('user.edit')}}</a>
                                @if($user->id != Auth::user()->id)
                                    <a href="{{ route('users.delete',$user->id) }}" class="badge badge-danger d-inline-block" onclick="return confirm(&quot;{{__('user.delete_confirm')}}&quot;);">
                                        {{ __('user.delete') }}
                                    </a>
                                <form class="d-inline-block" action="{{ route('users.password_reset',$user->id) }}" method="POST">
                                    @method('patch')
                                    @csrf
                                    <button type="submit" class="badge badge-dark " onclick="return confirm(&quot;{{__('user.password_reset_confirm')}}&quot;);">
                                        {{ __('user.password_reset') }}
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
@endsection