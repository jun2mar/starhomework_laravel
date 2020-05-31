@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-md-center">
        <div class="col-md-3">

            <div class="card card-widget widget-user-2">
                <div class="widget-user-header bg-warning">
                    {{-- <div class="col-md-3"><qr-code text="{{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}" size="100"></qr-code></div> --}}
                    <div class="widget-user-image">
                        <img class="img-circle elevation-2" src="{{ asset('dist/img/user7-128x128.jpg') }}" alt="User Avatar">
                    </div>
                    <h4 class="widget-user-username"><strong>{{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}</strong></h4>
                    <p class="widget-user-desc">{{ (Auth::user()->is_also_teacher) ? 'Teacher' : 'Student' }}</p>

                </div>
                <div class="card-footer p-0">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('account_dashboard') }}" class="nav-link">
                                Dashboard
                                {{-- <span class="float-right badge bg-primary">31</span> --}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('account_profile') }}" class="nav-link">
                                Profile
                                {{-- <span class="float-right badge bg-info">5</span> --}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('account_homework_list') }}" class="nav-link">
                                Homeworks
                                {{-- <span class="float-right badge bg-success">12</span> --}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Projects
                                {{-- <span class="float-right badge bg-danger">842</span> --}}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
        <div class="col-md-8">
            @yield('pages')
        </div>
    </div>
</div>
@endsection
