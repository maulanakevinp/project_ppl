@extends('layouts.app')

@section('title', __('forest.forest_management'))

@section('content')
<div class="mb-3">
    
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                {{-- <form method="GET" action="" accept-charset="UTF-8" class="form-inline">
                    <div class="form-group">
                        <label for="q" class="control-label">{{ __('forest.search') }}</label>
                        <input placeholder="{{ __('forest.search_text') }}" name="q" type="text" id="q" class="form-control mx-sm-2" value="{{ request('q') }}">
                    </div>
                    <input type="submit" value="{{ __('forest.search') }}" class="btn btn-secondary">
                    <a href="{{ route('forests.index') }}" class="btn btn-link">{{ __('app.reset') }}</a>
                </form> --}}
                <div class="float-right">
                    @can('create', new App\Forest)
                        <a href="{{ route('forests.create') }}" class="btn btn-success btn-sm">{{ __('forest.create') }}</a>
                    @endcan
                </div>
                <h5 class="page-title">
                    {{ __('forest.forest_management') }}
                    {{-- <small>{{ __('app.total') }} : {{ $forests->total() }} {{ __('forest.forest') }}</small> --}}
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
                                <th>{{ __('forest.creator') }}</th>
                                <th>{{ __('forest.created_at') }}</th>
                                <th class="text-center">{{ __('app.action') }}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                {{-- {{ $forests->appends(Request::except('page'))->render() }} --}}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
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
        { data: 'creator', name: 'creator' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action' },
    ],
});
</script>
@endpush