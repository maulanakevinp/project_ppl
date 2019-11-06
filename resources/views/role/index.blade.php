@extends('layouts.app')
@section('title')
{{ __('role.role_management') }} - {{ config('app.name') }}
@endsection
@section('content')
    @if ($errors->any())<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <div class="row justify-content-center">
        <div class="col-lg-6">
        
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold text-dark float-left">{{ $title }}</h5>
                    <a href="" class="btn btn-sm btn-success addRole float-right" data-toggle="modal"
                        data-target="#newRoleModal">{{ __('role.add_role') }}</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('#') }}</th>
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
                                    <a href="{{ route('role.edit', $role->id)  }}" class="btn btn-success btn-sm"><i
                                            class="fas fa-universal-access"></i> Akses</a>
                                    <button class="editRole btn btn-warning btn-sm btn-circle" data-toggle="modal"
                                        data-target="#newRoleModal" data-id="{{ $role->id }}"><i
                                            class="fas fa-edit"></i></button>
                                    @if($role->id != 1)
                                    <form class="d-inline-block" action="{{ route('role.destroy',$role->id) }}" method="POST">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm btn-circle"
                                            onclick="return confirm('{{__('role.delete_confirm',['role' => $role->role])}}');">
                                            <i class="fas fa-trash"></i>
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
    <div class="modal fade" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newRoleModalLabel">{{ __('role.add_role') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="postRole" action="{{ route('role.store') }}" method="post">
                    @csrf
                    <input id="method-role" type="hidden" name="_method" value="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="role" name="role" placeholder="Role Name"
                                autocomplete="off">
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
@push('scripts')
    <script>
        $(document).ready(function () {
            $('.editRole').on('click', function () {
                const id = $(this).data('id');
                const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $('#newRoleModalLabel').html("{{__('role.edit_role')}}");
                $('#submitRole').html("{{__('role.edit')}}");
                $('#postRole').attr('action', "{{ url('role') }}/" + id);
                $('#method-role').val('patch');
                $.ajax({
                    url: "{{ url('getRole') }}/" + id,
                    method: 'post',
                    dataType: 'json',
                    data: {
                        _token: CSRF_TOKEN,
                        id: id
                    },
                    success: function (data) {
                        $('#role').val(data.role);
                    }
                });
            });
            $('.addRole').on('click', function () {
                $('#newRoleModalLabel').html("{{__('role.add_role')}}");
                $('#submitRole').html("{{__('role.add')}}");
                $('#postRole').attr('action', "{{ route('role.store') }}");
                $('#method-role').val('post');
                $('#role').val('');
            });
        });
    </script>
@endpush