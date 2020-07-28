  <header class="main-header">
    <!-- Logo -->
    <a href="@if(Session::get('level')=='sekolah') {{url('sekolah')}} @endif @if(Session::get('level')=='guru') {{url('guru')}} @endif @if(Session::get('level')=='siswa') {{url('siswa')}} @endif" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>EL</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>E-LEARNING</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        E-LEARNING Cabang Dinas Pendidikan Sunggal
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle">
            <i class="fa  fa-calendar"> <b id="tgl_waktu"></b></i>
            </a>
          </li>
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{url('adminlte/dist/img/user2-160x160.jpg')}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{Session::get('name')}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{url('adminlte/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">

                <p>
                {{Session::get('name')}} - {{Session::get('level')}}
                  <small>Member since {{Session::get('created_at')}}</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <!--div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div-->
                <div class="pull-right">
                  <a href="{{url('logout')}}" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>