<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
    @if (Auth::user()->level == 'admin')
    <li class="nav-item">
        <a href="{{route('indexadmin')}}" class="nav-link {{ Route::currentRouteName() == 'indexadmin' ? 'active':''}}">
          <i class="nav-icon fa fa-home"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>
    <li class="nav-item">
        <a href="{{route('usermgmt')}}" class="nav-link {{ Route::currentRouteName() == 'usermgmt' ? 'active':''}}">
          <i class="nav-icon fa fa-user"></i>
          <p>
            User Management
          </p>
        </a>
      </li>
    <li class="nav-item">
        <a href="{{route('groupmgmt')}}" class="nav-link {{ Route::currentRouteName() == 'groupmgmt' ? 'active':''}}">
          <i class="nav-icon fa fa-users"></i>
          <p>
            Kelas Management
          </p>
        </a>
      </li>
    <li class="nav-item">
        <a href="{{route('studentmgmt')}}" class="nav-link {{ Route::currentRouteName() == 'studentmgmt' ? 'active':''}}">
          <i class="nav-icon fa fa-graduation-cap"></i>
          <p>
            Siswa Management
          </p>
        </a>
      </li>
    <li class="nav-item">
        <a href="{{route('exammgmt')}}" class="nav-link {{ Route::currentRouteName() == 'exammgmt' ? 'active':''}}">
          <i class="nav-icon fa fa-paper-plane"></i>
          <p>
            Exam Management
          </p>
        </a>
      </li>
    <li class="nav-item">
        <a href="{{route('logujian')}}" class="nav-link {{ Route::currentRouteName() == 'logujian' ? 'active':''}}">
          <i class="nav-icon fa fa-superscript"></i>
          <p>
            Log Ujian
          </p>
        </a>
      </li>
    <li class="nav-item">
        <a href="{{route('logcurang')}}" class="nav-link {{ Route::currentRouteName() == 'logcurang' ? 'active':''}}">
          <i class="nav-icon fa fa-eye"></i>
          <p>
            Log Kecurangan
          </p>
        </a>
      </li>

    @endif
    @if (Auth::user()->level == 'petugas')
    <li class="nav-item">
        <a href="{{route('indexpetugas')}}" class="nav-link {{ Route::currentRouteName() == 'indexpetugas' ? 'active':''}}">
          <i class="nav-icon fa fa-home"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('groupmgmtpetugas')}}" class="nav-link {{ Route::currentRouteName() == 'groupmgmt' ? 'active':''}}">
          <i class="nav-icon fa fa-users"></i>
          <p>
            Kelas Management
          </p>
        </a>
      </li>
    <li class="nav-item">
        <a href="{{route('studentmgmtpetugas')}}" class="nav-link {{ Route::currentRouteName() == 'studentmgmt' ? 'active':''}}">
          <i class="nav-icon fa fa-graduation-cap"></i>
          <p>
            Siswa Management
          </p>
        </a>
      </li>
    <li class="nav-item">
        <a href="{{route('exammgmtpetugas')}}" class="nav-link {{ Route::currentRouteName() == 'exammgmt' ? 'active':''}}">
          <i class="nav-icon fa fa-paper-plane"></i>
          <p>
            Exam Management
          </p>
        </a>
      </li>
    <li class="nav-item">
        <a href="{{route('logujianpetugas')}}" class="nav-link {{ Route::currentRouteName() == 'logujian' ? 'active':''}}">
          <i class="nav-icon fa fa-superscript"></i>
          <p>
            Log Ujian
          </p>
        </a>
      </li>
    <li class="nav-item">
        <a href="{{route('logcurangpetugas')}}" class="nav-link {{ Route::currentRouteName() == 'logcurang' ? 'active':''}}">
          <i class="nav-icon fa fa-eye"></i>
          <p>
            Log Kecurangan
          </p>
        </a>
      </li>
    <li class="nav-item">
        <a href="{{route('graduationmgmt')}}" class="nav-link {{ Route::currentRouteName() == 'graduationmgmt' ? 'active':''}}">
          <i class="nav-icon fa fa-anchor"></i>
          <p>
            Kelulusan
          </p>
        </a>
      </li>
     
      @endif


    <li class="nav-item">
      <a href="{{route('logout')}}" class="nav-link">
        <i class="fa fa-sign-out"></i>
        <p>
          Logout
        </p>
      </a>
    </li>
  </ul>
</nav>
