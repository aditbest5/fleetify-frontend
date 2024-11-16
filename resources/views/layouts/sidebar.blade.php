<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">

        <div class="navbar-nav theme-brand flex-row  text-center">
            <div class="nav-logo">
                <div class="nav-item theme-logo">
                    <a href="./index.html">
                        {{-- <img src="{{ asset('template/assets/img/logo.svg') }}" class="navbar-logo" alt="logo"> --}}
                    </a>
                </div>
                <div class="nav-item theme-text">
                    <a href="./index.html" class="nav-link"> Fleetify </a>
                </div>
            </div>
            <div class="nav-item sidebar-toggle">
                <div class="btn-toggle sidebarCollapse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg>
                </div>
            </div>
        </div>

        <div class="profile-info">
            <div class="user-info">
                <div class="profile-img">
                    <img src="{{asset('template/assets/img/profile-30.png')}}" alt="avatar">
                </div>
                <div class="profile-content">
                    <h6 class="">{{ Session::get('user_data')['name'] }}</h6>
                    <p class="">{{ Session::get('user_data')['role_name'] }}</p>
                </div>
            </div>
        </div>
                        
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            @if(session('user_data')["role_name"] === 'admin')

            <li class="menu {{ in_array(Route::currentRouteName(), ['employee-list','department-list','list-absent']) ? 'active' : ''}}">
                <a href="#dashboard" data-bs-toggle="collapse" aria-expanded="true" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>Master</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ in_array(Route::currentRouteName(), ['employee-list','department-list','list-absent']) ? 'show' : ''}}" id="dashboard" data-bs-parent="#accordionExample">
                    <li class="{{ in_array(Route::currentRouteName(), ['employee-list']) ? 'active' : ''}}">
                        <a href="{{route('employee-list')}}"> Karyawan </a>
                    </li>
                    <li class="{{ in_array(Route::currentRouteName(), ['department-list']) ? 'active' : ''}}">
                        <a href="{{route('department-list')}}"> Departemen </a>
                    </li>
                    <li class="{{ in_array(Route::currentRouteName(), ['list-absent']) ? 'active' : ''}}">
                        <a href="{{route('list-absent')}}"> List Absen Karyawan </a>
                    </li>
                </ul>
            </li>
            @endif
            <li class="menu {{  in_array(Route::currentRouteName(), ['absent-in','absent-out','history-absent']) ? 'active' : '' }}">
                <a href="#absent" data-bs-toggle="collapse" aria-expanded="true" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>Absensi</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ in_array(Route::currentRouteName(), ['absent-in','absent-out','history-absent']) ? 'show' : ''}}" id="absent" data-bs-parent="#accordionExample">
                    <li class="{{ in_array(Route::currentRouteName(), ['absent-in']) ? 'active' : ''}}">
                        <a href="{{route('absent-in')}}"> Absen Masuk </a>
                    </li>
                    <li class="{{ in_array(Route::currentRouteName(), ['absent-out']) ? 'active' : ''}}">
                        <a href="{{route('absent-out')}}"> Absen Keluar </a>
                    </li>

                    <li class="{{ in_array(Route::currentRouteName(), ['history-absent']) ? 'active' : ''}}">
                        <a href="{{route('history-absent')}}"> History Absen Pribadi </a>
                    </li>
                </ul>
            </li>
            
        </ul>
        
    </nav>

</div>