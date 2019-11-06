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

        <div id="buttonShowUser" class="col-xl-3 mb-4" onclick="showUser()">
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
    
        <div id="buttonShowForest" class="col-xl-3 mb-4" onclick="showForest()">
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
        <div id="UserList" class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="page-title">
                        User List
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="userTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{__('user.nip')}}</th>
                                    <th>{{__('user.name')}}</th>
                                    <th>{{__('user.role')}}</th>
                                    <th>{{__('user.action')}}</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12" id="ForestList">
            <div class="card">
                <div class="card-header">
                <h5 class="page-title">
                    Forest List
                </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="forestTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('forest.nik') }}</th>
                                    <th>{{ __('forest.name') }}</th>
                                    <th>{{ __('forest.owner_address') }}</th>
                                    <th>{{ __('forest.address') }}</th>
                                    <th>{{ __('forest.status') }}</th>
                                    <th>{{ __('forest.created_at') }}</th>
                                    <th class="text-center">{{ __('app.action') }}</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $('#UserList').show();
    $('#ForestList').hide();
    $('#buttonShowUser').css('cursor','pointer');
    $('#buttonShowForest').css('cursor','pointer');
    function showUser() {
        $('#UserList').show();
        $('#ForestList').hide();
    }
    function showForest() {
        $('#UserList').hide();
        $('#ForestList').show();
    }

    $(document).ready(function(){
        $('#userTable').DataTable({
            processing: true,
            serverside: true,
            ajax: "{{ route('ajax.get_user') }}",
            columns: [
                { data: 'nip', name: 'nip' },
                { data: 'name', name: 'name' },
                { data: 'role.role', name: 'role.role' },
                { data: 'action', name: 'action' },
            ],
        });
        $('#forestTable').DataTable({
            processing: true,
            serverside: true,
            ajax: "{{ route('ajax.get_forest') }}",
            columns: [
                { data: 'nik', name: 'nik' },
                { data: 'name', name: 'name' },
                { data: 'owner_address', name: 'owner_address' },
                { data: 'address', name: 'address' },
                { data: 'status', name: 'status' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action' },
            ],
        });
    });
</script>
@endpush