<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Theme & Color Scheme -->
    <meta name="color-scheme" content="light dark">
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)">
    <meta name="language" content="{{ app()->getLocale() }}">
    <meta http-equiv="Content-Language" content="{{ app()->getLocale() }}">
    <meta name="supported-color-schemes" content="light dark">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" media="print"
        onload="this.media='all'">

    <!-- Overlay Scrollbars -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/adminlte.css') }}">

    <!-- Bangla Font -->
    <link rel="stylesheet" href="http://mdminhazulhaque.github.io/solaimanlipi/css/solaimanlipi.css" type="text/css">

    <!-- Page Specific Styles -->
    @stack('styles')
</head>


<body class="fixed-header sidebar-expand-lg sidebar-open bg-body-tertiary">
    <div class="app-wrapper">
        {{-- <nav class="app-header navbar navbar-expand bg-body"> --}}
        <nav class="app-header navbar navbar-expand bg-success-subtle" data-bs-theme="light">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
                    <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contact</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                            <i class="bi bi-search"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#">
                            <i class="bi bi-chat-text"></i>
                            <span class="navbar-badge badge text-bg-danger">3</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <img src="../assets/img/user1-128x128.jpg" alt="User Avatar"
                                            class="img-size-50 rounded-circle me-3" />
                                    </div>
                                    <div class="flex-grow-1">
                                        <h3 class="dropdown-item-title">
                                            Brad Diesel
                                            <span class="float-end fs-7 text-danger"><i
                                                    class="bi bi-star-fill"></i></span>
                                        </h3>
                                        <p class="fs-7">Call me whenever you can...</p>
                                        <p class="fs-7 text-secondary">
                                            <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                                        </p>
                                    </div>
                                </div>
                            </a>

                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#">
                            <i class="bi bi-bell-fill"></i>
                            <span class="navbar-badge badge text-bg-warning">15</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <span class="dropdown-item dropdown-header">15 Notifications</span>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="bi bi-envelope me-2"></i> 4 new messages
                                <span class="float-end text-secondary fs-7">3 mins</span>
                            </a>

                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item dropdown-footer"> See All Notifications </a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                            <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                            <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#">
                            <i class="bi bi-translate"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end p-2" style="min-width: 120px;">
                            @php $currentLocale = App::getLocale(); @endphp

                            <a href="{{ route('locale.set', ['locale' => 'en']) }}"
                                class="dropdown-item {{ $currentLocale === 'en' ? 'active' : '' }}">
                                English
                            </a>

                            <a href="{{ route('locale.set', ['locale' => 'bn']) }}"
                                class="dropdown-item {{ $currentLocale === 'bn' ? 'active' : '' }}">
                                বাংলা
                            </a>
                        </div>
                    </li>


                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center"
                            data-bs-toggle="dropdown">
                            <span
                                class="d-flex justify-content-center align-items-center rounded-circle bg-primary text-white"
                                style="width: 2.2rem; height: 2.2rem; font-size: 1.3rem;">
                                <i class="bi bi-person-fill"></i>
                            </span>
                            <span class="d-none d-md-inline fw-bold ms-2 mb-0" style="line-height: 1; color:#1f2937;">
                                {{ Auth::user()->name }}
                            </span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" style="min-width: 250px;">
                            <!-- User header -->
                            <li class="user-header bg-gradient-info text-white text-center p-3">
                                <span
                                    class="d-inline-flex justify-content-center align-items-center rounded-circle bg-primary mb-2"
                                    style="width: 4rem; height: 4rem; font-size: 2.5rem;">
                                    <i class="bi bi-person-fill"></i>
                                </span>
                                <p class="mb-1 fw-bold" style="font-size: 1.1rem;">{{ Auth::user()->name }}</p>
                                <small>Member since {{ Auth::user()->created_at->format('M d, Y') }}</small>
                            </li>

                            <!-- User info -->
                            <li class="user-body p-3" style="background-color: #f4f6f9;">
                                @if (Auth::user()->division)
                                    <p class="mb-1"><strong>Division:</strong> {{ Auth::user()->division->name_en }}
                                    </p>
                                @endif
                                @if (Auth::user()->district)
                                    <p class="mb-1"><strong>District:</strong> {{ Auth::user()->district->name_en }}
                                    </p>
                                @endif
                                @if (Auth::user()->court)
                                    <p class="mb-1"><strong>Court:</strong> {{ Auth::user()->court->name_en }}</p>
                                @endif
                                @if (Auth::user()->email)
                                    <p class="mb-1"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                                @endif
                                @if (Auth::user()->phone_number)
                                    <p class="mb-0"><strong>Phone:</strong> {{ Auth::user()->phone_number }}</p>
                                @endif
                            </li>

                            <!-- Footer -->
                            <li class="user-footer d-flex justify-content-between p-2"
                                style="background-color: #e9ecef;">
                                <a href="#" class="btn btn-sm btn-primary">Profile</a>
                                <a href="{{ route('logout') }}" class="btn btn-sm btn-danger"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Sign out
                                </a>
                            </li>
                        </ul>
                    </li>


                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>


                </ul>
            </div>
        </nav>
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <div class="sidebar-brand">
                <a href="" class="brand-link">
                    <img src="{{ asset('/assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                        class="brand-image opacity-75 shadow" />
                    <span class="brand-text fw-light"><strong>CourtSMS</strong></span>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <!--begin::Sidebar Menu-->
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                        aria-label="Main navigation" data-accordion="false" id="navigation">

                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                <i class="nav-icon bi bi-speedometer"></i>
                                <p>{{ __('messages.dashboard') }}</p>
                            </a>
                        </li>

                        <!-- User Management -->
                        @canany(['View Permission Group', 'View Permission', 'View Roles', 'View Users'])
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon bi bi-people"></i>
                                    <p>
                                        {{ __('messages.user_management') }}
                                        <i class="nav-arrow bi bi-chevron-right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('View Permission Group')
                                        <li class="nav-item">
                                            <a href="{{ route('admin.permission-groups.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-diagram-3"></i>
                                                <p>{{ __('messages.permission_groups') }}</p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('View Permission')
                                        <li class="nav-item">
                                            <a href="{{ route('admin.permissions.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-shield-lock"></i>
                                                <p>{{ __('messages.permissions') }}</p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('View Roles')
                                        <li class="nav-item">
                                            <a href="{{ route('admin.roles.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-person-badge"></i>
                                                <p>{{ __('messages.roles') }}</p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('View Users')
                                        <li class="nav-item">
                                            <a href="{{ route('admin.users.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-people"></i>
                                                <p>{{ __('messages.users') }}</p>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany

                        <!-- Master Data -->
                        @canany(['View Division', 'View District', 'View Court', 'View Message Template Category', 'View
                            Message Template'])
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon bi bi-building"></i>
                                    <p>
                                        {{ __('messages.master_data') }}
                                        <i class="nav-arrow bi bi-chevron-right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('View Division')
                                        <li class="nav-item">
                                            <a href="{{ route('admin.divisions.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-diagram-3-fill"></i>
                                                <p>{{ __('messages.divisions') }}</p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('View District')
                                        <li class="nav-item">
                                            <a href="{{ route('admin.districts.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-geo-alt-fill"></i>
                                                <p>{{ __('messages.districts') }}</p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('View Court')
                                        <li class="nav-item">
                                            <a href="{{ route('admin.courts.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-house"></i>
                                                <p>{{ __('messages.courts') }}</p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('View Message Template Category')
                                        <li class="nav-item">
                                            <a href="{{ route('admin.message-template-categories.index') }}"
                                                class="nav-link">
                                                <i class="nav-icon bi bi-list-columns"></i>
                                                <p>{{ __('messages.template_category') }}</p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('View Message Template')
                                        <li class="nav-item">
                                            <a href="{{ route('admin.message-templates.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-file-earmark-text"></i>
                                                <p>{{ __('messages.message_templates') }}</p>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany


                        @canany(['SMS Form'])
                            <li class="nav-item">
                                <a href="{{ route('admin.cases.create_send') }}" class="nav-link">
                                    <i class="nav-icon bi bi-chat-dots"></i>
                                    <p>{{ __('case.send_sms') }}</p>
                                </a>
                            </li>
                        @endcanany

                        <!-- Logout -->
                        @auth
                            <li class="nav-item">
                                <a href="#" class="nav-link"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="nav-icon bi bi-box-arrow-right"></i>
                                    <p>{{ __('messages.logout') }}</p>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @endauth
                    </ul>
                    <!--end::Sidebar Menu-->
                </nav>

            </div>



        </aside>
        <main class="app-main">
            @yield('content')
            <div class="app-content">
                <div class="container-fluid">
                </div>
            </div>
        </main>
        <footer class="app-footer">
            <div class="float-end d-none d-sm-inline">Anything you want</div>
            <strong>
                Copyright &copy; 2014-2025&nbsp;
                <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
            </strong>
            All rights reserved.
        </footer>
    </div>
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('dashboard/js/adminlte.js') }}"></script>
    @stack('scripts')

    <script>
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const currentUrl = window.location.href;
            const sidebarLinks = document.querySelectorAll('.sidebar-menu a.nav-link');

            sidebarLinks.forEach(link => {
                // Check if the current link matches the URL
                if (currentUrl.includes(link.href)) {
                    // Highlight the link itself
                    link.classList.add('active');

                    // Find the closest nav-treeview (submenu)
                    let parentTree = link.closest('.nav-treeview');
                    if (parentTree) {
                        // Expand this submenu
                        parentTree.style.display = 'block';

                        // Find the parent <li> with treeview
                        const parentItem = parentTree.closest('.nav-item');
                        if (parentItem) {
                            parentItem.classList.add('menu-open'); // keep it open
                            const parentLink = parentItem.querySelector(':scope > a.nav-link');
                            if (parentLink) parentLink.classList.add('active'); // highlight parent link
                        }

                        // Repeat for multi-level menus
                        let ancestorTree = parentItem ? parentItem.closest('.nav-treeview') : null;
                        while (ancestorTree) {
                            ancestorTree.style.display = 'block';
                            const ancestorItem = ancestorTree.closest('.nav-item');
                            if (ancestorItem) {
                                ancestorItem.classList.add('menu-open');
                                const ancestorLink = ancestorItem.querySelector(':scope > a.nav-link');
                                if (ancestorLink) ancestorLink.classList.add('active');
                            }
                            ancestorTree = ancestorItem ? ancestorItem.closest('.nav-treeview') : null;
                        }
                    }
                }
            });
        });
    </script>

</body>

</html>
