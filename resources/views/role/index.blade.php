@extends('layouts.app')
@section('title')
{{ __('role.role_management') }} - {{ config('app.name') }}
@endsection
@section('content')
    @if ($errors->any())<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold float-left">{{ __('role.role_management') }}</h5>
                    <a href="" class="btn btn-sm btn-success addRole float-right" data-toggle="modal" data-target="#newRoleModal">{{ __('role.add') }}</a>
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
                                <form  action="{{ route('role.store') }}" method="post">
                                    @csrf
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
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('role.number') }}</th>
                                    <th scope="col">{{ __('role.role') }}</th>
                                    <th scope="col">{{ __('role.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($user_role as $role)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $role->role }}</td>
                                        <td>
                                            <a href="{{ route('role.edit', $role->id)  }}"><span class="badge badge-warning">{{ __('access') }}</span></a>
                                            <a href="" data-toggle="modal" data-target="{{'#editRoleModal'.$i}}" data-id="{{ $role->id }}"><span class="badge badge-success">{{ __('role.edit') }}</span></a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="{{'editRoleModal'.$i}}" tabindex="-1" role="dialog" aria-labelledby="{{'editRoleModalLabel'.$i}}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="{{'editRoleModalLabel'.$i}}">{{ __('role.edit') }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form id="postRole" action="{{ route('role.update',$role->id) }}" method="post">
                                                            @csrf
                                                            @method('patch')
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="role">{{ __('role.role') }}</label>
                                                                    <input type="text" class="form-control" id="role" name="role" value="{{ $role->role }}" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('role.close') }}</button>
                                                                <button type="Submit" class="btn btn-success" id="submitRole">{{ __('role.edit') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($role->id != 1)
                                                <form class="d-inline-block" action="{{ route('role.destroy',$role->id) }}" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="badge badge-danger " onclick="return confirm('{{__('role.delete_confirm',['role' => $role->role])}}');">
                                                        {{ __('role.delete') }}
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
