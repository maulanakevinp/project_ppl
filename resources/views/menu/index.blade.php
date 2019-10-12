@extends('layouts.app')
@section('title')
{{ __('menu.menu_management') }} - {{ config('app.name') }}
@endsection
@section('content')

    @if ($errors->any())<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold float-left">{{ __('menu.menu_management') }}</h5>
                    <a href="" class="btn btn-sm btn-success float-right addMenu" data-toggle="modal" data-target="#newMenuModal">{{ __('menu.add') }}</a>
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
                                <form action="{{ route('menu.store') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="menu" name="menu" placeholder="Menu Name" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('menu.close')}}</button>
                                        <button type="Submit" class="btn btn-success">{{__('menu.add')}}</button>
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
                                    <th scope="col">{{ __('menu.number') }}</th>
                                    <th scope="col">{{ __('menu.menu') }}</th>
                                    <th scope="col">{{ __('menu.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach($user_menu as $menu)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $menu->menu }}</td>
                                        <td>
                                            <a href="" data-toggle="modal" data-target="{{'#editMenuModal'.$i}}" data-id="{{ $menu->id }}"><span class="badge badge-success">{{ __('menu.edit') }}</span></a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="{{'editMenuModal'.$i}}" tabindex="-1" role="dialog" aria-labelledby="{{'editMenuModalLabel'.$i}}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="{{'editMenuModalLabel'.$i}}">{{ __('menu.edit') }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('menu.update',$menu->id) }}" method="post">
                                                            @csrf
                                                            @method('patch')
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="menu">{{ __('menu.menu') }}</label>
                                                                    <input type="text" class="form-control" id="menu" name="menu" value="{{ $menu->menu }}" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('menu.close')}}</button>
                                                                <button type="submit" class="btn btn-success">{{__('menu.edit')}}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <form class="d-inline-block" action="{{ route('menu.destroy',$menu->id) }}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="badge badge-danger " onclick="return confirm('{{__('menu.delete_confirm',['menu' => $menu->menu])}}');">
                                                    {{ __('menu.delete') }}
                                                </button>
                                            </form>
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
