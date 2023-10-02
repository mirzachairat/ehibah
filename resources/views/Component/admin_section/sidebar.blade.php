<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('img/logo_hibah.png')}}" alt="AdminLTE Logo" class="brand-image elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Ehibahbansos</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('/img/user1-128x128.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Super Administrator</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        
          <li class="nav-header">ADMIN DASHBOARD</li>
          <li class="nav-item">
            <a href="{{route('adminHome')}}" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('proposals')}}" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                Proposal
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                SKPD
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('skpd')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data SKPD</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('sub')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sub SKPD</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Workflow
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('Workflow')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Workflows</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('State')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>State List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('Transition')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Transition List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('Guard')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Workflow Guard</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('Notification')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Workflow Notification</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link">
              <i class="nav-icon far fa-plus-square"></i>
              <p>
                Users
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('User')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    User List
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('Permission')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Permission
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('Role')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Role</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>
                Setting
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('DataTentang')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tentang</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('DataPeraturan')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Peraturan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('DataPengumuman')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengumuman</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('Checklist')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Checklist</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/search/enhanced.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Banner</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/search/enhanced.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Video</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/search/enhanced.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sossial Media</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/search/enhanced.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>SKPD</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/search/enhanced.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Api Manager</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/search/enhanced.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Host key</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/search/enhanced.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lock Proposal</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/search/enhanced.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Update Proposal</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>