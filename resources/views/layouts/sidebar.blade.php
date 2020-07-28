  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{url('adminlte/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p> {{Session::get('name')}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> @if(Session::get('login')==TRUE) {{Session::get('level')}} @endif</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU UTAMA</li>
        @if(!empty(Session::get('level')))
        <li><a href="{{url('sekolah')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Kelola Data</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @if(Session::get('level')=="admin" or Session::get('level')=="superadmin")
            <li><a href="{{url('daftarsekolah')}}"><i class="fa fa-home"></i> Data Sekolah</a></li>
            @elseif(Session::get('level')=="sekolah")
            <li><a href="/sikupas/public/daftarsekolah/tampil/{{Session::get('id_sekolah')}}"><i class="fa fa-home"></i> Data Sekolah</a></li>
            @endif
            @if(Session::get('level')=="sekolah")
            <li><a href="{{url('daftarguru')}}"><i class="fa fa-user"></i> Data Guru</a></li>
            @elseif(Session::get('level')=="guru")
            <li><a href="/sikupas/public/daftarguru/tampil/{{Session::get('id')}}"><i class="fa fa-user"></i> Data Guru</a></li>
            @endif
            @if(Session::get('level')=="sekolah")
            <li><a href="{{url('daftarsiswa')}}"><i class="fa fa-user"></i> Data Siswa</a></li>
            @elseif(Session::get('level')=="siswa")
            <li><a href="/sikupas/public/daftarsiswa/tampil/{{Session::get('id')}}"><i class="fa fa-user"></i> Data Siswa</a></li>
            @endif
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-bank"></i> <span>Kelola Kelas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @if(Session::get('level')=="sekolah")
            <li><a href="{{url('daftarpelajaran')}}"><i class="fa fa-book"></i> Mata Pelajaran</a></li>
            <li><a href="{{url('daftarkelas')}}"><i class="fa fa-bank"></i> Data Kelas</a></li>
            @endif
            @if(Session::get('level')=="guru" or Session::get('level')=="siswa" or Session::get('level')=="sekolah" or Session::get('level')=="admin")
            <li><a href="{{url('daftarpertemuan')}}"><i class="fa fa-book"></i> Data Pertemuan</a></li>
            <!--li><a href="{{url('daftartugas')}}"><i class="fa fa-circle-o"></i> Data Tugas</a></li>
            <li><a href="{{url('daftarabsensi')}}"><i class="fa fa-circle-o"></i> Data Absensi</a></li>
            <li><a href="{{url('daftarnilai')}}"><i class="fa fa-circle-o"></i> Data Nilai</a></li-->
            @endif
          </ul>
        </li>
        @endif
        <li><a href="{{url('logout')}}"><i class="fa fa-power-off"></i> <span>Logout</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>