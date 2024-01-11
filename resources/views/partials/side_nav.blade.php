<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
    <img src="https://www.cwstechnology.com/wp-content/uploads/2023/01/logo.png" width="46" height="46">
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item">
            <a class="nav-link" href="{{route('dashboard')}}">
                Dashboard <span class="ms-auto"><i class="fa-solid fa-gauge"></i></span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('applicants.index')}}">
                Applicants <span class="ms-auto"><i class="fas fa-users"></i></span>
            </a>
        </li>
        <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>