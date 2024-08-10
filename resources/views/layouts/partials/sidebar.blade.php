<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar" style="position:fixed;">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        @if(!empty(Session::get('business.logo')))
            <img src="{{ asset( 'uploads/business_logos/' . Session::get('business.logo') ) }}" alt="Logo" style="width:100%;padding:10px;">
        @endif
        <a href="{{ route('home') }}" class="logo">
            <span class="logo-lg">{{ Session::get('business.name') }}</span>
        </a>

        <!-- Sidebar Menu -->
        {{-- @dd(Menu::render('admin-sidebar-menu', 'adminltecustom')) --}}
        {!! Menu::render('admin-sidebar-menu', 'adminltecustom') !!}
        <!-- /.sidebar-menu -->
        <img src="{{ asset('img/logoMRM-2.png') }}" alt="Logo" style="width:50%;margin-left:25%; position: absolute;bottom:10px;background:none;">
    </section>
    <!-- /.sidebar -->
</aside>
