<div class="container-xxl position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
        <a href="" class="navbar-brand p-0">
            <img src="{{asset('/img/logo_hibah.png')}}" alt="">
            <!-- <img src="img/logo.png" alt="Logo"> -->
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="{{env('APP_URL')}}/" class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }}">Home</a>
                <a href="{{env('APP_URL')}}/proposal" class="nav-item nav-link {{ Request::is('proposal') ? 'active' : '' }}">Proposal</a>
                <a href="{{env('APP_URL')}}/about" class="nav-item nav-link {{ Request::is('about') ? 'active' : '' }}">Tentang</a>
                <a href="{{env('APP_URL')}}/peraturan" class="nav-item nav-link {{ Request::is('peraturan') ? 'active' : '' }}">Peraturan</a>
                <a href="{{env('APP_URL')}}/pengumuman" class="nav-item nav-link {{ Request::is('pengumuman') ? 'active' : '' }}">Pengumuman</a>
                <a href="{{env('APP_URL')}}/manualbook" class="nav-item nav-link {{ Request::is('manualbook') ? 'active' : '' }}">Manual Book</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Account</a>
                    <div class="dropdown-menu m-0">
                        <a href="{{env('APP_URL')}}/login" class="dropdown-item">Login Operator</a>
                        <a href="team.html" class="dropdown-item">Login</a>
                        <a href="{{env('APP_URL')}}/register" class="dropdown-item">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </nav> 
</div>