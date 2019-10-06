<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/simple-line-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome5-overrides.min.css') }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}">
    @yield('styles')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @else
                            @php
                                $user_menu = \App\UserMenu::getMenuByRole(auth()->user()->role_id);                
                            @endphp
                            @foreach ($user_menu as $menu)

                                @if ($menu->menu == $title)
                                    <li class="nav-item active dropdown">
                                @else
                                    <li class="nav-item dropdown">
                                @endif
                                    <a id="{{ 'navbarDropdown'.$menu->id }}" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ $menu->menu }} <span class="caret"></span>
                                    </a>

                                    @php
                                        $user_submenu = \App\UserSubmenu::getSubmenuByMenu($menu->id);
                                    @endphp

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ 'navbarDropdown'.$menu->id }}">
                                        @foreach ($user_submenu as $submenu)
                                            <a class="dropdown-item" href="{{ url(''.$submenu->url) }}">
                                                <i class="{{ $submenu->icon }}"></i>
                                                <span>{{ $submenu->title }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </li>
                                @endforeach
                                @if ($title == Auth::user()->name)
                                <li class="nav-item active dropdown">
                                @else
                                <li class="nav-item dropdown">
                                @endif
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('my_profile') }}">
                                        <i class="fas fa-fw fa-user"></i>
                                        <span>{{ __('user.my_profile') }}</span>
                                    </a>
                                    <a class="dropdown-item" href="{{ route('edit_profile') }}">
                                        <i class="fas fa-fw fa-user-edit"></i>
                                        <span>{{ __('user.edit_profile') }}</span>
                                    </a>
                                    <a class="dropdown-item" href="{{ route('change_password') }}">
                                        <i class="fas fa-fw fa-key"></i>
                                        <span>{{ __('user.change_password') }}</span>
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        <span>{{ __('Logout') }}</span>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 container">
            @yield('content')
        </main>
    </div>

    <!-- provide the csrf token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    @stack('scripts')

    <script>
        $(document).ready(function(){
            $('#dataTable').DataTable();
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                readURL(this);
            });
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#image').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $('.accessMenu').on('click', function() {
                const menuId = $(this).data('menu');
                const roleId = $(this).data('role');
                const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('/change-access') }}",
                    type: 'post',
                    data: {
                        _token: CSRF_TOKEN,
                        menuId: menuId,
                        roleId: roleId
                    },
                    success: function() {
                        document.location.href = "{{ url('role') }}/" + roleId +"/edit";
                    }
                });
            });
            $('.editRole').on('click', function() {
                const id = $(this).data('id');
                const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $('#newRoleModalLabel').html('Edit Role');
                $('#submitRole').html('Edit');
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
                    success: function(data) {
                        $('#role').val(data.role);
                    }
                });
            });
            $('.addRole').on('click', function() {
                $('#newRoleModalLabel').html('Add New Role');
                $('#submitRole').html('Add');
                $('#postRole').attr('action', "{{ route('role.store') }}");
                $('#method-role').val('post');
                $('#role').val('');
            });
            $('.editMenu').on('click', function() {
                const id = $(this).data('id');
                const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $('#newMenuModalLabel').html('Edit Menu');
                $('#submitMenu').html('Edit');
                $('#postMenu').attr('action', "{{ url('menu') }}/" + id);
                $('#method-menu').val('patch');
                $.ajax({
                    url: "{{ url('/getMenu') }}",
                    method: 'post',
                    dataType: 'json',
                    data: {
                        _token: CSRF_TOKEN,
                        id: id
                    },
                    success: function(data) {
                        $('#menu').val(data.menu);
                    }
                });
            });
            $('.addMenu').on('click', function() {
                $('#newMenuModalLabel').html('Add New Menu');
                $('#submitMenu').html('Add');
                $('#postMenu').attr('action', "{{ route('menu.store') }}");
                $('#method-menu').val('post');
                $('#menu').val('');
            });
            $('.editSubMenu').on('click', function() {
                const id = $(this).data('id');
                const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $('#newSubMenuModalLabel').html('Edit Submenu');
                $('#submitSubMenu').html('Edit');
                $('#postSubMenu').attr('action', "{{ url('submenu') }}/" + id);
                $('#method-submenu').val('patch');
                $.ajax({
                    url: "{{ url('/getSubmenu') }}",
                    method: 'post',
                    dataType: 'json',
                    data: {
                        _token: CSRF_TOKEN,
                        id: id
                    },
                    success: function(data) {
                        $('#title').val(data.title);
                        $('#menu_id').val(data.menu_id);
                        $('#url').val(data.url);
                        $('#icon').val(data.icon);
                        if (data.is_active == 1) {
                            $('#is_active').attr('checked', true);
                        } else {
                            $('#is_active').attr('checked', false);
                        }
                    }
                });
            });
            $('.addSubMenu').on('click', function() {
                $('#newSubMenuModalLabel').html('Add New Submenu');
                $('#submitSubMenu').html('Add');
                $('#postSubMenu').attr('action', "{{ route('submenu.store') }}");
                $('#title').val('');
                $('#menu_id').val('');
                $('#url').val('');
                $('#icon').val('');
                $('#is_active').attr('checked', false);
                $('#method-submenu').val('post');
            });
        });
    </script>
</body>
</html>
