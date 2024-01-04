<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title . ' | ' . config('app.name') ?? 'Infinitewellness' }}</title>
    <meta name="google" content="notranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="/manifest.json">
    <link href="{{ route('inventory.products.index') }}" rel="canonical">
    <meta content="{{ config('app.name') }}" property="og:site_name">
    <meta content="Dashboard" property="og:title">
    <meta content="website" property="og:type">
    <meta content="{{ route('inventory.products.index') }}" property="og:url">
    <meta content="{{ asset('logo.png') }}" property="og:image">
    <meta content="Hospital Management System" property="og:description">
    <meta name="description" content="Hospital Management System">
    <meta name="keywords" content="hospital management system, hms, hospital">
    <meta name="theme-color" content="#fff">
    <link rel="shortcut icon" type="image/ico" href="{{ asset('logo.png') }}" />
    <link rel="stylesheet"  nonce="{{ csp_nonce() }}" href="{{ asset('inventory/css/style.min.css') }}" />
    <link rel="stylesheet" nonce="{{ csp_nonce() }}"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    @stack('styles')
</head>

<body>
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-row flex-column-fluid">
            <div class="aside-menu-container" id="sidebar">
                <div class="aside-menu-container__aside-logo flex-column-auto mb-5">
                    <a href="{{route('dashboard') }}" class="text-decoration-none sidebar-logo"
                        title="{{ config('app.name') }}">
                        <img src="{{ asset('logo.png') }}" alt="Logo" class="img-fluid" width="50"
                            height="50" class="image" loading="eager" />
                        <span
                            class="navbar-brand-name text-dark text-decoration-none logo ps-2">{{ getAppName() }}</span>
                    </a>
                    <button type="button" onclick="toggle()"
                        class="btn px-0 aside-menu-container__aside-menubar d-lg-block d-none sidebar-btn"
                        aria-label="Toggle Sidebar">
                        <i class="fa-solid fa-bars fs-1"></i>
                    </button>
                </div>
                <div class="sidebar-scrolling overflow-auto mt-5">
                    <ul class="aside-menu-container__aside-menu nav flex-column">
                        @if (request()->route()->named('inventory.*'))
                            <x-layouts.inventory-menu />
                        @elseif(request()->route()->named('purchase.*'))
                            <x-layouts.purchase-menu />
                        @elseif(request()->route()->named('shift.*'))
                            <x-layouts.shift-menu />
                        @endif
                    </ul>
                </div>
            </div>
            <div class="bg-overlay" id="sidebar-overly"></div>
            <div class="wrapper d-flex flex-column flex-row-fluid">
                <div class='container-fluid d-flex align-items-stretch justify-content-between px-0'>
                    <header class='d-flex align-items-center justify-content-between flex-grow-1 header px-3 px-xl-0'>
                        <nav class="navbar navbar-expand-xl navbar-light top-navbar d-xl-flex d-block px-3 px-xl-0 py-4 py-xl-0"
                            id="nav-header">
                            <div class="container-fluid pe-0">
                                <div class="navbar-collapse">
                                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                        {{-- <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                                            <a class="nav-link p-0"
                                               href="{{ route('dashboard') }}">
                                                Dashboard
                                            </a>
                                        </li> --}}
                                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                                            <a class="nav-link p-0 {{ request()->route()->named('inventory.*')? 'active': '' }}"
                                                href="{{ route('inventory.products.index') }}">
                                                Inventory
                                            </a>
                                        </li>
                                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                                            <a class="nav-link p-0 {{ request()->route()->named('purchase.*')? 'active': '' }}"
                                                href="{{ route('purchase.requistions.index') }}">
                                                Purchase
                                            </a>
                                        </li>
                                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                                            <a class="nav-link p-0 {{ request()->route()->named('shift.*')? 'active': '' }}"
                                                href="{{ route('shift.transfers.index') }}">
                                                Transfer
                                            </a>
                                        </li>
                                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                                            <a class="nav-link p-0 {{ request()->route()->named('logs.*')? 'active': '' }}"
                                                href="{{ route('logs.index') }}">
                                                Logs
                                            </a>
                                        </li>
                                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                                            <a class="nav-link p-0 {{ request()->route()->named('products.products_report.*')? 'active': '' }}"
                                                href="{{ route('inventory.products.products_report') }}">
                                                Products Report
                                            </a>
                                        </li>
                                        @role('Admin|Pharmacist')
                                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                                            <a class="nav-link p-0 {{ request()->route()->named('inventory.recalculation')? 'active': '' }}"
                                                href="{{ route('inventory.recalculation') }}">
                                                Recalculation
                                            </a>
                                        </li>
                                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                                            <a class="nav-link p-0 {{ request()->route()->named('products.adjustment')? 'active': '' }}"
                                                href="{{ route('inventory.products.adjustment') }}">
                                                Adjustment Products
                                            </a>
                                        </li>
                                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                                            <a class="nav-link p-0 {{ request()->route()->named('products.batch-pos-report')? 'active': '' }}"
                                                href="{{ route('inventory.products.batch-pos-report') }}">
                                                Batch Report
                                            </a>
                                        </li>
                                        @endrole                                
                                    </ul>
                                </div>
                            </div>
                        </nav>
                        <ul class="nav align-items-center flex-nowrap">
                            <li class="px-xxl-3 px-2">
                                <div class="dropdown d-flex align-items-center py-4">
                                    <div class="image image-circle image-mini">
                                        <img nonce="{{ csp_nonce() }}" src="{{ auth()->user()->image_url }}"
                                            class="img-fluid" width="50" height="50" loading="eager"
                                            alt="profile image">
                                    </div>
                                    <button class="btn ps-2 pe-0 text-gray-600" type="button" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" onclick="dropdown()">
                                        {{ auth()->user()->full_name ?? '' }}
                                        <i class="fa-solid fa-angle-down"></i>
                                    </button>
                                    <div class="dropdown-menu py-7 pb-4 my-2" aria-labelledby="dropdownMenuButton1" id="profile-dropdown">
                                        <div class="text-center border-bottom pb-5">
                                            <div class="image image-circle image-tiny mb-5">
                                                <img alt="profile image" nonce="{{ csp_nonce() }}"
                                                    src="{{ auth()->user()->image_url }}" class="img-fluid"
                                                    alt="profile image" width="50" height="50" loading="eager"
                                                    id="loginUserImage">
                                            </div>
                                            <h3 class="text-gray-900">{{ auth()->user()->full_name ?? '' }}</h3>
                                            <div class="mb-0 fw-400 fs-6 text-decoration-none text-dark">
                                                {{ auth()->user()->email ?? '' }}</div>
                                        </div>
                                        <ul class="pt-4">
                                            <li>
                                                <a class="dropdown-item text-gray-900"
                                                    href="{{ route('logout.user') }}"
                                                    onclick="event.preventDefault(); localStorage.clear();  document.getElementById('logout-form').submit();">
                                                    <span class="dropdown-icon me-4 text-gray-600">
                                                        <i class="fa-solid fa-right-from-bracket"></i>
                                                    </span>
                                                    Logout
                                                    <form id="logout-form" action="{{ route('logout.user') }}"
                                                        method="POST" class="d-none">
                                                        {{ csrf_field() }}
                                                    </form>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <button type="button" class="btn px-0 d-block d-xl-none header-btn pb-2">
                                    <i class="fa-solid fa-bars fs-1"></i>
                                </button>
                            </li>
                        </ul>
                    </header>
                    <div class="bg-overlay" id="nav-overly"></div>
                </div>
                <main class='content d-flex flex-column flex-column-fluid pt-7'>
                    <div class='d-flex flex-column-fluid'>
                        @if (session('success'))
                            <x-success-alert />
                        @elseif(session('errors'))
                            <x-error-alert />
                        @endif
                        {{ $slot }}
                    </div>
                </main>
                <footer class='container-fluid'>
                    <div class="footer py-4 d-flex flex-lg-column position-sticky bottom-0">
                        <div
                            class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                            <div class="text-dark">
                                <span>Designed & Developed By <a class="text-primary"
                                        href="https://searchmarketingservice.com/" target="__blank">Search Marketing
                                        Services</a>.</span>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    {{-- <script src="{{ asset('inventory/js/third-party.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/third-party.js') }}"></script> --}}
    <script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js">
    </script>
    <script nonce="{{ csp_nonce() }}" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @stack('scripts')
    <script nonce="{{ csp_nonce() }}">
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js');
        }

        function toggle() {
            var sidebar = $("#sidebar");
            var body = $("body");

            if (sidebar.hasClass('collapsed-menu')) {
                sidebar.removeClass('collapsed-menu');
                body.removeClass('collapsed-menu');
                
            } else {
                sidebar.addClass('collapsed-menu');
                body.addClass('collapsed-menu');
            }
        }
        function dropdown() {
            $("#profile-dropdown").toggle();
        }
    </script>
</body>

</html>
