@extends('layouts.app')

@section('title', __('forest.list'))

@section('content')
<div class="mb-3">
    <div class="float-right">
        @can('create', new App\Forest)
            <a href="{{ route('forests.create') }}" class="btn btn-success">{{ __('forest.create') }}</a>
        @endcan
    </div>
    <h1 class="page-title">{{ __('forest.list') }} <small>{{ __('app.total') }} : {{ $forests->total() }} {{ __('forest.forest') }}</small></h1>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <form method="GET" action="" accept-charset="UTF-8" class="form-inline">
                    <div class="form-group">
                        <label for="q" class="control-label">{{ __('forest.search') }}</label>
                        <input placeholder="{{ __('forest.search_text') }}" name="q" type="text" id="q" class="form-control mx-sm-2" value="{{ request('q') }}">
                    </div>
                    <input type="submit" value="{{ __('forest.search') }}" class="btn btn-secondary">
                    <a href="{{ route('forests.index') }}" class="btn btn-link">{{ __('app.reset') }}</a>
                </form>
            </div>
            <table class="table table-sm table-responsive-sm">
                <thead>
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
                    @foreach($forests as $key => $forest)
                    <tr>
                        <td class="text-center">{{ $forests->firstItem() + $key }}</td>
                        <td>{{ $forest->nik }}</td>
                        <td>{!! $forest->name_link !!}</td>
                        <td>{{ $forest->owner_address }}</td>
                        <td>{{ $forest->address }}</td>
                        <td>{{ $forest->latitude }}</td>
                        <td>{{ $forest->longitude }}</td>
                        <td class="text-center">
                            <a href="{{ route('forests.show', $forest) }}" id="show-forest-{{ $forest->id }}">{{ __('app.show') }}</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-body">{{ $forests->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
</div>
@endsection
