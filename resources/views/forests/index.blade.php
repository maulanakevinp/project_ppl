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
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center">{{ __('app.table_no') }}</th>
                                <th>{{ __('forest.nik') }}</th>
                                <th>{{ __('forest.name') }}</th>
                                <th>{{ __('forest.owner_address') }}</th>
                                <th>{{ __('forest.address') }}</th>
                                <th>{{ __('forest.latitude') }}</th>
                                <th>{{ __('forest.longitude') }}</th>
                                <th class="text-center">{{ __('app.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($forests as $forest)
                                @if ($forest->creator_id == Auth::user()->id)
                                    <tr>
                                        <th class="text-center">{{ $loop->iteration }}</th>
                                        <td>{{ $forest->nik }}</td>
                                        <td>{{ $forest->name }}</td>
                                        <td>{{ $forest->owner_address }}</td>
                                        <td>{{ $forest->address }}</td>
                                        <td>{{ $forest->latitude }}</td>
                                        <td>{{ $forest->longitude }}</td>
                                        <td class="text-center">
                                            <a class="badge badge-success" href="{{ route('forests.show', $forest) }}" id="show-forest-{{ $forest->id }}">detail</a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- {{ $forests->appends(Request::except('page'))->render() }} --}}
            </div>
        </div>
    </div>
</div>
@endsection
