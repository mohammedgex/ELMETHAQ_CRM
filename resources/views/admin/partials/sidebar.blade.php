<nav id="sidebar" class="col-md-2 d-none d-md-block bg-dark sidebar" style="min-height: 100vh;">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column text-white">
            <li class="nav-item mb-3 text-center">
                <img src="{{ asset('images/logo-methaq.png') }}" alt="Methaq Logo"
                    style="width: 80px; border-radius: 16px; background: #fff; padding: 8px;">
                <div class="fw-bold mt-2" style="color: #B89C5A;">لوحة التحكم</div>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (Route::currentRouteName() == 'admin.dashboard') active @endif text-white"
                    href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i> الرئيسية
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (Route::currentRouteName() == 'admin.jobs') active @endif text-white"
                    href="{{ route('admin.jobs') }}">
                    <i class="fas fa-briefcase me-2"></i> فرص العمل بالخارج
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (Route::currentRouteName() == 'admin.registrations') active @endif text-white"
                    href="{{ route('admin.registrations') }}">
                    <i class="fas fa-users me-2"></i> طلبات تسجيل العمالة
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (Route::currentRouteName() == 'admin.companies.requests') active @endif text-white"
                    href="{{ route('admin.companies.requests') }}">
                    <i class="fas fa-building me-2"></i> طلبات تسجيل الشركات
                </a>
            </li>
            <li class="nav-item mt-4">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-sign-out-alt me-2"></i> تسجيل الخروج
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>
<style>
    #sidebar {
        background: linear-gradient(135deg, #174A7C 60%, #B89C5A 100%);
        min-height: 100vh;
        box-shadow: 2px 0 20px rgba(23, 74, 124, 0.08);
    }

    #sidebar .nav-link,
    #sidebar .nav-link * {
        color: #fff !important;
    }

    #sidebar .nav-link.active,
    #sidebar .nav-link:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #fff !important;
        border-radius: 8px;
        font-weight: bold;
    }

    #sidebar .nav-link.active i,
    #sidebar .nav-link:hover i {
        color: #fff !important;
    }

    #sidebar .nav-link i {
        color: #fff !important;
    }

    #sidebar .fw-bold {
        font-size: 1.1rem;
        letter-spacing: 1px;
        color: #fff !important;
    }

    @media (max-width: 767.98px) {
        #sidebar {
            display: none;
        }

        main.col-md-10 {
            width: 100% !important;
        }
    }
</style>
