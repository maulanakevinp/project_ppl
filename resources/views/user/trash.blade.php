@extends('layouts.app')
@section('title')
{{ __('user.user_deleted') }} - {{ config('app.name') }}
@endsection
@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ $title }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('user.user_deleted') }}</li>
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

    <div class="card shadow mb-4">
        <div class="card-header py-3 ">
            <h5 class="m-0 pt-1 font-weight-bold float-left">{{ __('user.user_deleted') }}</h5>
            <div class="btn-group float-right">
                <a href="{{route('users.restore_all')}}" class="btn btn-sm btn-success">{{ __('user.restore_all') }}</a>
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
                                <a href="{{route('users.restore',$user->id)}}" class="badge badge-warning">{{__('user.restore')}}</a>
                                @if($user->id != Auth::user()->id)
                                <form class="d-inline-block" action="{{ route('users.destroy',$user->id) }}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="badge badge-danger " onclick="return confirm(&quot;{{__('user.delete_confirm')}}&quot;);">
                                        {{ __('user.delete') }}
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