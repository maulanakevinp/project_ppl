@extends('layouts.master')
@section('title')
{{ $title }} - {{ config('app.name') }}
@endsection
@section('container')
<!-- Begin Page Content -->
<div class="container-fluid">
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
            <h5 class="m-0 pt-1 font-weight-bold text-success float-left">{{ $title }}</h5>
            <a href="{{route('forests.create')}}" class="btn btn-sm btn-success addRole float-right">{{ __('Add New forest') }}</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>{{__('#')}}</th>
                            <th>{{__('NIK')}}</th>
                            <th>{{__('Owner')}}</th>
                            <th>{{__('City')}}</th>
                            <th>{{__('District')}}</th>
                            <th>{{__('Address')}}</th>
                            <th>{{__('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($forests as $forest)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $forest->nik }}</td>
                            <td>{{ $forest->owner }}</td>
                            <td>{{ $forest->district->city->city }}</td>
                            <td>{{ $forest->district->district }}</td>
                            <td>{{ $forest->address }}</td>
                            <td>
                                <a href="{{route('forests.show',$forest->id)}}" class="badge badge-success">{{__('detail')}}</a>
                                <a href="{{route('forests.edit',$forest->id)}}" class="badge badge-warning">{{__('edit')}}</a>
                                <form class="d-inline-block" action="{{ route('forests.destroy',$forest->id) }}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="badge badge-danger " onclick="return confirm('Are you sure want to DELETE this forest ?');">
                                        {{ __('delete') }}
                                    </button>
                                </form>
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