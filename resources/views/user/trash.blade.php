@extends('layouts.master')
@section('title')
{{ $title }} - {{ config('app.name') }}
@endsection
@section('container')
<!-- Begin Page Content -->
<div class="container-fluid">
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

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 ">
            <h5 class="m-0 pt-1 font-weight-bold text-success float-left">{{ $subtitle }}</h5>
            <div class="btn-group float-right">
                <a href="{{route('users.restoreAll')}}" class="btn btn-sm btn-success">{{ __('Restore All') }}</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>{{__('NIP')}}</th>
                            <th>{{__('Name')}}</th>
                            <th>{{__('Role')}}</th>
                            <th>{{__('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->nip }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->role->role }}</td>
                            <td>
                                <a href="{{route('users.restore',$user->id)}}" class="badge badge-warning">{{__('restore')}}</a>
                                @if($user->id != Auth::user()->id)
                                <form class="d-inline-block" action="{{ route('users.destroy',$user->id) }}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="badge badge-danger " onclick="return confirm('Are you sure want to DELETE this user ?');">
                                        {{ __('delete') }}
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
</div>
<!-- /.container-fluid -->
@endsection