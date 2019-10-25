@extends('layouts.app')
@section('title')
Dashboard - {{ config('app.name') }}
@endsection
@section('content')
<div class="container">
    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-6 mb-4 align-self-center">
            <h1>Dashboard</h1>
        </div>
        <!-- Jumlah Penduduk Card Example -->
        <div class="col-xl-3 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total User</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Jumlah Penduduk Card Example -->
        <div class="col-xl-3 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Forest
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $forests->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tree fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="page-title">
                        User List
                    </h5>
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
                                        <a href="{{route('users.show',$user->id)}}" class="badge badge-success">{{__('user.show')}}</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <h5 class="page-title">
                    Forest List
                </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable1" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('forest.nik') }}</th>
                                    <th>{{ __('forest.name') }}</th>
                                    <th>{{ __('forest.owner_address') }}</th>
                                    <th>{{ __('forest.address') }}</th>
                                    <th>{{ __('forest.created_at') }}</th>
                                    <th class="text-center">{{ __('app.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($forests as $forest)
                                <tr>
                                    <td>{{ $forest->nik }}</td>
                                    <td>{{ $forest->name }}</td>
                                    <td>{{ $forest->owner_address }}</td>
                                    <td>{{ $forest->address }}</td>
                                    <td>{{ $forest->created_at->format('d M Y - H:i:s') }}</td>
                                    <td class="text-center">
                                        <a class="badge badge-success" href="{{ route('forests.show', $forest) }}" id="show-forest-{{ $forest->id }}">detail</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
