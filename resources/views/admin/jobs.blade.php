@extends('layouts.app', ['hideHeaderFooter' => true])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-2 d-none d-md-block bg-dark sidebar" style="min-height: 100vh;">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column text-white">
                        <li class="nav-item mb-3 text-center">
                            <img src="{{ asset('images/logo-methaq.png') }}" alt="Methaq Logo"
                                style="width: 80px; border-radius: 16px; background: #fff; padding: 8px;">
                            <div class="fw-bold mt-2" style="color: #B89C5A;">لوحة التحكم</div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i> الرئيسية
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('admin.jobs') }}">
                                <i class="fas fa-briefcase me-2"></i> فرص العمل بالخارج
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
            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto px-md-4">
                <div class="pt-4">
                    <h2 class="mb-4">فرص العمل بالخارج</h2>
                    <table class="table table-bordered table-striped bg-white">
                        <thead class="table-dark">
                            <tr>
                                <th>عنوان الوظيفة</th>
                                <th>تفاصيل الوظيفة</th>
                                <th>شرح الوظيفة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>مهندس مدني</td>
                                <td>العمل في شركة مقاولات كبرى بالسعودية</td>
                                <td>إدارة المشاريع والإشراف على التنفيذ وضمان الجودة والتواصل مع فرق العمل.</td>
                            </tr>
                            <tr>
                                <td>محاسب مالي</td>
                                <td>شركة استثمارية في الإمارات</td>
                                <td>إعداد التقارير المالية، مراجعة الحسابات، وتحليل البيانات المالية.</td>
                            </tr>
                            <tr>
                                <td>ممرض/ة</td>
                                <td>مستشفى خاص في قطر</td>
                                <td>تقديم الرعاية الصحية للمرضى، متابعة الحالات، والمساعدة في الإجراءات الطبية.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
@endsection
