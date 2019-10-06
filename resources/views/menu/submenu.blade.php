@extends('layouts.app')
@section('title')
{{ __('menu.submenu_management') }} - {{ config('app.name') }}
@endsection
@section('content')

    <div class="row justify-content-center">
        <div class="col-lg">
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
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 pt-1 font-weight-bold float-left">{{ __('menu.submenu_management') }}</h5>
                    <a href="" class="btn btn-sm btn-success float-right addSubMenu" data-toggle="modal" data-target="#newSubMenuModal">{{ __('menu.add_submenu') }}</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('menu.number') }}</th>
                                    <th>{{ __('menu.title') }}</th>
                                    <th>{{ __('menu.menu') }}</th>
                                    <th>{{ __('menu.url') }}</th>
                                    <th>{{ __('menu.icon') }}</th>
                                    <th>{{ __('menu.active') }}</th>
                                    <th>{{ __('menu.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user_submenu as $submenu)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $submenu->title }}</td>
                                    <td>{{ $submenu->menu->menu }}</td>
                                    <td>{{ $submenu->url }}</td>
                                    <td>{{ $submenu->icon }}</td>
                                    <td>{{ $submenu->is_active }}</td>
                                    <td>
                                        <a class="editSubMenu" href="" data-toggle="modal" data-target="#newSubMenuModal" data-id="{{ $submenu->id }}"><span class="badge badge-success">{{ __('menu.edit') }}</span></a>
                                        <form class="d-inline-block" action="{{ route('submenu.destroy',$submenu->id) }}" method="POST">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="badge badge-danger " onclick="return confirm(&quot;{{__('menu.delete_confirm_submenu')}}&quot;);">
                                                {{ __('menu.delete') }}
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
    </div>

    <!-- Modal -->
    <div class="modal fade" id="newSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newSubMenuModalLabel">{{ __('menu.add_submenu') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="postSubMenu" action="{{ route('submenu.store') }}" method="post">
                    @csrf
                    <input id="method-submenu" type="hidden" name="_method" value="post">

                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Submenu title" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <select name="menu_id" id="menu_id" class="form-control">
                                <option value="">{{ __('menu.select_menu') }}</option>
                                @foreach ($user_menu as $menu)
                                <option value="{{ $menu->id }}">{{ $menu->menu }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="url" name="url" placeholder="Submenu url">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="icon" name="icon" placeholder="Submenu icon">
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active">
                                <label class="form-check-label" for="is_active">
                                    {{ __('Active?') }}
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('menu.close')}}</button>
                            <button type="Submit" class="btn btn-success" id="submitMenu">{{__('menu.add')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
