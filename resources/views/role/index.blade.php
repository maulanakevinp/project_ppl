@extends('layouts.app')
@section('title')
{{ __('role.role_management') }} - {{ config('app.name') }}
@endsection
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">
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
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold float-left">{{ __('role.role_management') }}</h5>
                    <a href="" class="btn btn-sm btn-success addRole float-right" data-toggle="modal" data-target="#newRoleModal">{{ __('role.add') }}</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('role.number') }}</th>
                                <th scope="col">{{ __('role.role') }}</th>
                                <th scope="col">{{ __('role.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user_role as $role)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $role->role }}</td>
                                    <td>
                                        <a href="{{ route('role.edit', $role->id)  }}"><span class="badge badge-warning">{{ __('access') }}</span></a>
                                        <a class="editRole" href="" data-toggle="modal" data-target="#newRoleModal" data-id="{{ $role->id }}"><span class="badge badge-success">{{ __('role.edit') }}</span></a>
                                        @if($role->id != 1)
                                            <form class="d-inline-block" action="{{ route('role.destroy',$role->id) }}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="badge badge-danger " onclick="return confirm('Are you sure want to DELETE this role ?');">
                                                    {{ __('role.delete') }}
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

<!-- Modal -->
<div class="modal fade" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleModalLabel">{{ __('role.add') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="postRole" action="{{ route('role.store') }}" method="post">
                @csrf
                <input id="method-role" type="hidden" name="_method" value="post">

                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="role" name="role" placeholder="Role Name" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('role.close') }}</button>
                    <button type="Submit" class="btn btn-success" id="submitRole">{{ __('role.add') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
