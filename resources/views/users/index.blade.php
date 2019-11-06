@extends('layouts.app')
@section('title')
{{ __('user.user_management') }} - {{ config('app.name') }}
@endsection
@section('content')

    @if ($errors->any())<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 ">
            <h5 class="m-0 pt-1 font-weight-bold float-left">{{ __('user.user_management') }}</h5>
            <div class="btn-group float-right">
                <a href="{{route('users.deleted')}}" class="btn btn-sm btn-warning">{{ __('user.user_deleted') }}</a>
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
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
$(document).ready(function(){
    $('#dataTable').DataTable({
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
});
</script>
@endpush