<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.seo')
    @stack('meta')

    <!-- fav icon -->
    <link rel="shortcut icon" href="{{ asset(get_frontend_settings('favicon')) }}" />

    <!-- owl carousel -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/owl.theme.default.min.css') }}">

    <!-- Jquery Ui Css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/jquery-ui.css') }}">

    <!-- Nice Select Css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/nice-select.css') }}">

    <!-- Fontawasome Css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/all.min.css') }}">

    {{-- New Css Link --}}
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/vendors/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/vendors/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/vendors/slick/slick-theme.css') }}">

    <!-- Flat Pickr -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/vendors/flatpickr/flatpickr.min.css') }}">

    <!-- FlatIcons Css -->
    <link rel="stylesheet" href="{{ asset('assets/global/icons/uicons-bold-rounded/css/uicons-bold-rounded.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/global/icons/uicons-regular-rounded/css/uicons-regular-rounded.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/global/icons/uicons-solid-rounded/css/uicons-solid-rounded.css') }}" />

    <!-- Custom Fonts -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/custome-front/custom-fronts.css') }}">

    <!-- Player Css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/plyr.css') }}">

    <!-- Bootstrap Css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/bootstrap.min.css') }}">

    <!-- Main Css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/responsive.css') }}">

    <!-- Yaireo Tagify -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/tagify-master/dist/tagify.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/custom_style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/new_responsive.css') }}">

    <!-- Jquery Js -->
    <script src="{{ asset('assets/frontend/default/js/jquery-3.7.1.min.js') }}"></script>
    @stack('css')

</head>

<body>
    @php $current_route_name = Route::currentRouteName(); @endphp
    @php
        if (session('home')) {
            $home_page = App\Models\Builder_page::where('id', session('home'))->firstOrNew();
        } else {
            $home_page = App\Models\Builder_page::where('status', 1)->firstOrNew();
        }
    @endphp

    @if ($home_page->is_permanent == 1)
        @include('components.home_made_by_developer.top_bar')
        @include('components.home_made_by_developer.header')
        <section>
            @yield('content')
        </section>
        @include('components.home_made_by_developer.footer')
    @else
        @if ($current_route_name == 'home' || $current_route_name == 'admin.page.preview')
            <section>
                @yield('content')
            </section>
        @else
            @php $builder_files = $home_page->html ? json_decode($home_page->html, true) : []; @endphp
            @if (in_array('top_bar', $builder_files))
                @include('components.home_made_by_builder.top_bar')
            @endif

            @if (in_array('header', $builder_files))
                @include('components.home_made_by_builder.header')
            @endif

            <section>
                @yield('content')
            </section>

            @if (in_array('footer', $builder_files))
                @include('components.home_made_by_builder.footer')
            @endif
        @endif
    @endif
    <a href="{{ route('courses') }}" class="floating-book-btn">
        <span class="text">{{ get_phrase('Get Started') }}</span>
    </a>

    <style>
        .floating-book-btn {
            display: none;
        }


        @media (max-width: 991.98px) {
            .floating-book-btn {
                display: flex;
                position: fixed;
                bottom: 20px;
                right: 20px;
                background-image: linear-gradient(to right, #2f57ef 0%, #c664ff 51%, #c664ff 100%);
                color: #fff;
                padding: 14px 18px;
                border-radius: 30px;
                align-items: center;
                gap: 10px;
                font-weight: 600;
                background-size: 200% auto;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
                text-decoration: none;
                z-index: 9999;
                transition: all 0.3s ease;
                animation: floatBtn 2s ease-in-out infinite;
                /* حركة تأرجح */
            }

            /* تأثير عند المرور بالماوس */
            .floating-book-btn:hover {
                transform: scale(1.1) rotate(-2deg);
                background-position: right center;
                /* تحريك التدرج */
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            }

            /* حركة التأرجح */
            @keyframes floatBtn {

                0%,
                100% {
                    transform: translateY(0px);
                }

                50% {
                    transform: translateY(-8px);
                }
            }
        }
    </style>


    <!-- Bootstrap Js -->
    <script src="{{ asset('assets/frontend/default/js/bootstrap.bundle.min.js') }}"></script>


    <!-- nice select js -->
    <script src="{{ asset('assets/frontend/default/js/jquery.nice-select.min.js') }}"></script>

    {{-- New Js Link  --}}
    <script src="{{ asset('assets/frontend/default/vendors/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/default/vendors/counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/default/vendors/counterup/jquery.waypoints.js') }}"></script>
    <script src="{{ asset('assets/frontend/default/vendors/slick/slick.min.js') }}"></script>

    <script src="{{ asset('assets/frontend/default/vendors/flatpickr/flatpickr.min.js') }}"></script>

    <!-- owl carousel js -->
    <script src="{{ asset('assets/frontend/default/js/owl.carousel.min.js') }}"></script>


    <!-- Player Js -->
    <script src="{{ asset('assets/frontend/default/js/plyr.js') }}"></script>


    <!-- Yaireo Tagify -->
    <script src="{{ asset('assets/global/tagify-master/dist/tagify.min.js') }}"></script>


    <!-- Jquery Ui Js -->
    <script src="{{ asset('assets/frontend/default/js/jquery-ui.min.js') }}"></script>


    <!-- price range Js -->
    <script src="{{ asset('assets/frontend/default/js/price_range_script.js') }}"></script>


    <!-- Main Js -->
    <script src="{{ asset('assets/frontend/default/js/script.js') }}"></script>

    @if (get_frontend_settings('cookie_status'))
        @include('frontend.default.cookie')
    @endif

    <!-- End Footer -->
    @include('frontend.default.modal')
    <!-- toster file -->
    @include('frontend.default.toaster')
    <!-- custom scripts -->
    @include('frontend.default.scripts')
    @stack('js')
</body>

</html>
