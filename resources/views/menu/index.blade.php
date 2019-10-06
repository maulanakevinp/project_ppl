@extends('layouts.app')
@section('title')
{{ __('menu.menu_management') }} - {{ config('app.name') }}
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
                    <h5 class="m-0 pt-1 font-weight-bold float-left">{{ __('menu.menu_management') }}</h5>
                    <a href="" class="btn btn-sm btn-success float-right addMenu" data-toggle="modal" data-target="#newMenuModal">{{ __('menu.add') }}</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('menu.number') }}</th>
                                <th scope="col">{{ __('menu.menu') }}</th>
                                <th scope="col">{{ __('menu.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user_menu as $menu)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $menu->menu }}</td>
                                    <td>
                                        <a class="editMenu" href="" data-toggle="modal" data-target="#newMenuModal" data-id="{{ $menu->id }}"><span class="badge badge-success">{{ __('menu.edit') }}</span></a>
                                        <form class="d-inline-block" action="{{ route('menu.destroy',$menu->id) }}" method="POST">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="badge badge-danger " onclick="return confirm(&quot;{{__('menu.delete_confirm')}}&quot;);">
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

    <!-- Modal -->
    <div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newMenuModalLabel">{{ __('menu.add') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('menu.store') }}" method="post" id="postMenu">
                    @csrf
                    <input id="method-menu" type="hidden" name="_method" value="post">

                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="menu" name="menu" placeholder="Menu Name" autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('menu.close')}}</button>
                        <button type="Submit" class="btn btn-success" id="submitMenu">{{__('menu.add')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
