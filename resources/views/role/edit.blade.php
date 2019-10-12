@extends('layouts.app')
@section('title')
{{ $subtitle }} - {{ config('app.name') }}
@endsection
@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('role.index') }}">{{ $title }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $subtitle }}</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 id="judul" class="m-0 pt-1 font-weight-bold">
                        {{ __('Role :')}} {{ $role->role }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('#') }}</th>
                                    <th scope="col">{{ _('Menu') }}</th>
                                    <th scope="col">{{ __('Access') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menu as $m)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $m->menu }}</td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input accessMenu" type="checkbox" {{ \App\UserAccessMenu::checkAccess($role->id, $m->id) }} data-role="{{ $role->id }}" data-menu="{{ $m->id }}">
                                            </div>
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

@endsection
