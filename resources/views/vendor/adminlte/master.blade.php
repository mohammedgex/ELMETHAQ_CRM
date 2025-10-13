<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>

    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Custom Meta Tags --}}
    @yield('meta_tags')

    {{-- Title --}}
    <title>
        @yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'AdminLTE 3'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))
    </title>

    {{-- Custom stylesheets (pre AdminLTE) --}}
    @yield('adminlte_css_pre')

    {{-- Base Stylesheets (depends on Laravel asset bundling tool) --}}
    @if (config('adminlte.enabled_laravel_mix', false))
        <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_mix_css_path', 'css/app.css')) }}">
    @else
        @switch(config('adminlte.laravel_asset_bundling', false))
            @case('mix')
                <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_css_path', 'css/app.css')) }}">
            @break

            @case('vite')
                @vite([config('adminlte.laravel_css_path', 'resources/css/app.css'), config('adminlte.laravel_js_path', 'resources/js/app.js')])
            @break

            @case('vite_js_only')
                @vite(config('adminlte.laravel_js_path', 'resources/js/app.js'))
            @break

            @default
                <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
                <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
                <!-- <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}"> -->
                @if (app()->getLocale() == 'ar')
                    @vite ( ['resources/css/adminlte-rtl.css'])
                @else
                    @vite ( ['resources/css/adminlte.css'])
                @endif

                @vite(['resources/css/admin_custom.css'])

                <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @endswitch
    @endif

    {{-- Extra Configured Plugins Stylesheets --}}
    @include('adminlte::plugins', ['type' => 'css'])

    {{-- Livewire Styles --}}
    @if (config('adminlte.livewire'))
        @if (intval(app()->version()) >= 7)
            @livewireStyles
        @else
            <livewire:styles />
        @endif
    @endif

    {{-- Custom Stylesheets (post AdminLTE) --}}
    @yield('adminlte_css')

    {{-- Favicon --}}
    @if (config('adminlte.use_ico_only'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
    @elseif(config('adminlte.use_full_favicon'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicons/android-icon-192x192.png') }}">
        <link rel="manifest" crossorigin="use-credentials" href="{{ asset('favicons/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    @endif


    <style>
        .dark-mode {
            background-color: #121212 !important;
            color: #f1f1f1 !important;
        }

        /* لتعديل خلفيات الأقسام */
        .dark-mode .section-container {
            background-color: #2c2c2c !important;
            color: #f1f1f1 !important;
        }

        /* بطاقات */
        .dark-mode .card {
            background-color: #343a40 !important;
            color: #fff !important;
        }

        /* ترويسة */
        .dark-mode .main-header,
        .dark-mode .main-footer,
        .dark-mode .main-sidebar {
            background-color: #1e1e1e !important;
            color: #fff !important;
        }

        /* المحتوى */
        .dark-mode .content-wrapper {
            background-color: #1f1f1f !important;
            color: #fff !important;
        }

        /* نماذج */
        .dark-mode .form-control,
        .dark-mode input,
        .dark-mode select,
        .dark-mode textarea {
            background-color: #2e2e2e !important;
            color: #fff !important;
            border-color: #555 !important;
        }

        /* الروابط */
        .dark-mode a {
            color: #90caf9 !important;
        }

        /* جداول
        .dark-mode .table,
        .dark-mode .table th,
        .dark-mode .table td {
            background-color: #2c2c2c;
            color: #fff !important;
            border-color: #444 !important;
        } */

        /* قوائم جانبية */
        .dark-mode .nav-sidebar>.nav-item>.nav-link {
            background-color: transparent !important;
            color: #ccc !important;
        }

        .dark-mode .nav-sidebar>.nav-item>.nav-link.active {
            background-color: #3a3a3a !important;
            color: #fff !important;
        }

        .dark-mode label:not(.form-check-label):not(.custom-file-label),
        .dark-mode label.fw-bold {
            color: #f1f1f1 !important;
        }

        .dark-mode .bg-white {
            background-color: #1e1e1e !important;
            color: #f1f1f1 !important;
        }

        .dark-mode .bg-white>a {
            color: #f1f1f1 !important;
        }

        .width-input {
            width: 20px !important;
            height: 20px !important;
        }

        /* تحسين الجدول في الوضع الداكن */
        .dark-mode .table th,
        .dark-mode .table td {
            border-top-color: #6c757d !important;
            color: #f1f1f1 !important;
            /* نص فاتح */
        }

        .dark-mode .table-light th,
        .dark-mode .table-light td,
        .dark-mode .table-light thead th,
        .dark-mode .table-light tbody+tbody {
            border-color: #3a4b5c !important;
        }

        .dark-mode .table-light,
        .dark-mode .table-light>th,
        .dark-mode .table-light>td {
            background-color: #2c3b4c !important;
            /* لون الصفوف في الداكن */
            color: #fff !important;
        }

        /* لون الهيدر */
        .dark-mode #delegatesTable thead {
            background-color: #1f2d3d !important;
            color: #ffffff !important;
        }

        /* لون الهوفر على الصف */
        .dark-mode #delegatesTable tbody tr:hover {
            background-color: #3a4b5c !important;
        }

        /* البادجات في الوضع الداكن */
        .dark-mode .badge.bg-success {
            background-color: #28a745 !important;
            color: #fff !important;
        }

        .dark-mode .badge.bg-info {
            background-color: #17a2b8 !important;
            color: #fff !important;
        }

        .table-warning,
        .table-warning>th,
        .table-warning>td {
            /* background-color: #ffeeba; */
            color: #121212 !important;
        }
    </style>
</head>

<body class="@yield('classes_body')" @yield('body_data') style="font-family: 'Cairo'; padding-bottom: 20px ">
    <button id="toggle-dark-mode" class="btn btn-dark"
        style="position: fixed; bottom: 20px; right: 20px; z-index: 10000; border-radius: 50%; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
        🌙
    </button>


    {{-- Body Content --}}
    @yield('body')

    {{-- Base Scripts (depends on Laravel asset bundling tool) --}}
    @if (config('adminlte.enabled_laravel_mix', false))
        <script src="{{ mix(config('adminlte.laravel_mix_js_path', 'js/app.js')) }}"></script>
    @else
        @switch(config('adminlte.laravel_asset_bundling', false))
            @case('mix')
                <script src="{{ mix(config('adminlte.laravel_js_path', 'js/app.js')) }}"></script>
            @break

            @case('vite')
            @case('vite_js_only')
            @break

            @default
                <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
                <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
                <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
                <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
        @endswitch
    @endif

    {{-- Extra Configured Plugins Scripts --}}
    @include('adminlte::plugins', ['type' => 'js'])

    {{-- Livewire Script --}}
    @if (config('adminlte.livewire'))
        @if (intval(app()->version()) >= 7)
            @livewireScripts
        @else
            <livewire:scripts />
        @endif
    @endif

    {{-- Custom Scripts --}}
    @yield('adminlte_js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <footer
        style="
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: #007bff;
    color: white;
    font-size: 12px;
    text-align: center;
    padding: 5px 0;
    z-index: 9999;
">
        <p style="margin: 0;">جميع الحقوق محفوظة &copy; {{ date('Y') }} <a href="https://www.elmethaq.com"
                target="_blank" style="color: white; text-decoration: underline;">الميثاق</a>
            <span style="margin-right: 50px;">نسخة تجريبية</س>
        </p>
    </footer>
    <!-- القائمة المخصصة -->
    <style>
        #custom-menu {
            display: none;
            position: absolute;
            padding: 10px 20px;
            border-radius: 8px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            user-select: none;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
            transition: background-color 0.3s, color 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 10000;
            min-width: 160px;
        }

        /* الوضع الفاتح */
        @media (prefers-color-scheme: light) {
            #custom-menu {
                background-color: #ffffff;
                color: #222222;
                border: 1px solid #ddd;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            #custom-menu:hover {
                background-color: #f0f4ff;
                color: #1a3dff;
            }
        }

        /* الوضع الداكن */
        @media (prefers-color-scheme: dark) {
            #custom-menu {
                background-color: #2a2a2a;
                color: #eeeeee;
                border: 1px solid #444444;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.8);
            }

            #custom-menu:hover {
                background-color: #3a4a7f;
                color: #c0d1ff;
            }
        }

        /* أيقونة */
        #custom-menu svg {
            width: 18px;
            height: 18px;
            fill: currentColor;
            flex-shrink: 0;
        }
    </style>

    <div id="custom-menu" role="menu" tabindex="0" aria-label="قائمة الخيارات">
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <path
                d="M14 3h7v7h-2V6.41l-9.29 9.3-1.42-1.42 9.3-9.29H14V3zM5 5h5v2H7.41L17 16.59 15.59 18 6 8.41V11H4V5z" />
        </svg>
        فتح في تاب جديدة
    </div>


    <script>
        const menu = document.getElementById('custom-menu');
        let currentLink = null;

        document.addEventListener('contextmenu', function(e) {
            const link = e.target.closest('a');
            if (link) {
                e.preventDefault();
                currentLink = link.href;
                menu.style.top = e.pageY + 'px';
                menu.style.left = e.pageX + 'px';
                menu.style.display = 'block';
            } else {
                menu.style.display = 'none';
                currentLink = null;
            }
        });

        menu.addEventListener('click', function() {
            if (currentLink) {
                window.open(currentLink, '_blank');
                menu.style.display = 'none';
                currentLink = null;
            }
        });

        document.addEventListener('click', function() {
            menu.style.display = 'none';
            currentLink = null;
        });

        // منع كليك يمين فقط في أماكن غير روابط
        // document.addEventListener('contextmenu', function(e) {
        //     if (!e.target.closest('a')) {
        //         e.preventDefault();
        //     }
        // });
        document.addEventListener("keydown", function(event) {
            if (event.key === "F12" ||
                (event.ctrlKey && event.shiftKey && (event.key === "I" || event.key === "J" || event.key ===
                    "C")) ||
                (event.ctrlKey && event.key === "U")) {
                event.preventDefault();
                return false;
            }
        });
    </script>


    <script>
        // منع اختصارات DevTools مثل F12 و Ctrl+Shift+I/J و Ctrl+U
        document.addEventListener('keydown', function(e) {
            // F12
            if (e.key === 'F12') {
                e.preventDefault();
                return false;
            }
            // Ctrl+Shift+I
            if (e.ctrlKey && e.shiftKey && e.key === 'I') {
                e.preventDefault();
                return false;
            }
            // Ctrl+Shift+J
            if (e.ctrlKey && e.shiftKey && e.key === 'J') {
                e.preventDefault();
                return false;
            }
            // Ctrl+U
            if (e.ctrlKey && e.key === 'u') {
                e.preventDefault();
                return false;
            }
            // Ctrl+Shift+C (أداة تحديد العناصر)
            if (e.ctrlKey && e.shiftKey && e.key === 'C') {
                e.preventDefault();
                return false;
            }
        });

        // منع كليك يمين
        // document.addEventListener('contextmenu', function(e) {
        //     e.preventDefault();
        // });

        // كشف فتح أدوات المطور عن طريق console.log + Object.defineProperty
        (function devtoolsDetector() {
            const element = new Image();
            Object.defineProperty(element, 'id', {
                get: function() {
                    // تم فتح أدوات المطور
                    alert('تم اكتشاف فتح أدوات المطور!');
                    window.location.href = '/'; // يمكنك تغيير الإجراء هنا
                }
            });
            console.log(element);
        })();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const body = document.body;
            const toggleBtn = document.getElementById('toggle-dark-mode');

            // عند التحميل: فحص الوضع من localStorage
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            if (isDarkMode) {
                body.classList.add('dark-mode');
                toggleBtn.textContent = '☀️';
            }

            // عند الضغط على الزر
            toggleBtn.addEventListener('click', function() {
                const dark = body.classList.toggle('dark-mode');
                localStorage.setItem('darkMode', dark);
                toggleBtn.textContent = dark ? '☀️' : '🌙';
            });
        });

        // document.addEventListener("keydown", function(e) {
        //     // السماح فقط بالاختصارات المسموح بها (Ctrl+P, Ctrl+C, Ctrl+S)
        //     if (
        //         e.ctrlKey && ["p", "c", "s", "r", "a", "z", "x", "v"].includes(e.key.toLowerCase())
        //     ) {
        //         return true; // السماح
        //     }

        //     // منع أي اختصار آخر
        //     if (e.ctrlKey || e.metaKey || e.key === "F12") {
        //         e.preventDefault();
        //         e.stopImmediatePropagation(); // يوقف الاختصار تمامًا
        //         return false; // يمنع أي تنفيذ إضافي
        //     }
        // });


        // function detectDevTools() {
        //     const start = performance.now();
        //     debugger; // لو DevTools مفتوح هيتأخر هنا
        //     const end = performance.now();

        //     if (end - start > 100) { // فرق زمني كبير يعني DevTools مفتوح
        //         document.body.innerHTML = `
    //     <h1 style="color:red; text-align:center; margin-top:20%; font-size:50px;">
    //         🚨 تم كشف فتح أدوات المطور 🚨
    //     </h1>
    //     <h2 style="text-align:center; font-size:30px;">
    //         لا تحاول العبث في الكود، هذا قد يؤدي إلى حظر حسابك!
    //     </h2>
    //     @if (auth()->user())
    //         <h3 style="text-align:center; font-size:20px;">
    //         من فضلك يا {{ auth()->user()->name }} اغلق وضع المطور وقم بعمل ريفريش
    //     </h3>
    //     @endif
    //     `;
        //     }
        // }

        // setInterval(detectDevTools, 1000);
    </script>

</body>

</html>
