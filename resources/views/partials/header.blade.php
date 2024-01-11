<header class="header header-sticky mb-4">
    <div class="container-fluid">
        <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <i class="fa-solid fa-bars"></i>
        </button><a class="header-brand d-md-none" href="#">
            <img src="https://www.cwstechnology.com/wp-content/uploads/2023/01/logo.png" width="46" height="46">

            <!-- <ul class="header-nav d-none d-md-flex">
            <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Users</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Settings</a></li>
        </ul> -->
            <ul class="header-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#">
                        <svg class="icon icon-lg">
                        </svg></a></li>
                <li class="nav-item"><a class="nav-link" href="#">
                        <svg class="icon icon-lg">
                        </svg></a></li>
                <li class="nav-item"><a class="nav-link" href="#">
                        <svg class="icon icon-lg">
                        </svg></a></li>
            </ul>
            <ul class="header-nav ms-3">
                <li class="nav-item dropdown"><a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        {{auth()->user()->name}}
                        <div class="avatar avatar-md"><i class="fa-solid fa-user-tie"></i></div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pt-0">
                        <div class="dropdown-header bg-light py-2">
                            <div class="fw-semibold"> {{ __( 'Settings') }}</div>
                        </div>
                        <a class="dropdown-item" href="{{route('profile.show')}}">
                        <i class="fa-solid fa-user"></i> {{ __( 'Profile') }}
                        </a>
                        <div class="dropdown-divider">
                        </div>
                        <form method="POST" action="/logout" id="logoutForm">
                            @csrf
                            <a class="dropdown-item" href="#" onclick="logout()">
                                <i class="fa-solid fa-right-from-bracket"></i> {{ __( 'Log Out') }}
                            </a>
                        </form>

                    </div>
                </li>
            </ul>
    </div>
    <div class="header-divider"></div>
    @stack('breadcrumb')
</header>
<script>
    function logout() {
        // Assuming you have a function to handle form submission
        document.getElementById('logoutForm').submit();
    }
</script>