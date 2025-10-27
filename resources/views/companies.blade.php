@extends('layouts.app')
@section('title', 'تسجيل الشركات')
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow-sm" style="border-radius:18px; border:1px solid #e5e7eb;">
                    <div class="card-header text-center"
                        style="background: linear-gradient(135deg, #174A7C 60%, #B89C5A 100%); color: #fff; border-radius: 18px 18px 0 0;">
                        <h4 class="mb-0 fw-bold" style="letter-spacing:1px;">تسجيل الشركات</h4>
                    </div>
                    <div class="card-body"
                        style="background: linear-gradient(135deg, #fff 85%, #f8fafc 100%); border-radius:0 0 18px 18px;">
                        @if (session('success'))
                            <div class="alert alert-success text-center">{{ session('success') }}</div>
                        @endif
                        <form method="POST" action="{{ route('companies.apply') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="company_name" class="form-label fw-bold" style="color:#174A7C;">اسم
                                    الشركة</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold" style="color:#174A7C;">البريد
                                    الإلكتروني</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="job_title" class="form-label fw-bold" style="color:#174A7C;">الوظيفة
                                    المطلوبة</label>
                                <input type="text" class="form-control" id="job_title" name="job_title" required>
                            </div>
                            <div class="mb-3">
                                <label for="workers_count" class="form-label fw-bold" style="color:#174A7C;">عدد العمالة
                                    المطلوبة</label>
                                <input type="number" class="form-control" id="workers_count" name="workers_count"
                                    min="1" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label fw-bold" style="color:#174A7C;">رقم الهاتف</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label fw-bold" style="color:#174A7C;">ملاحظات أو رسالة
                                    إضافية</label>
                                <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn w-100 fw-bold"
                                style="background: linear-gradient(135deg, #174A7C 60%, #B89C5A 100%); color: #fff; border-radius: 50px; font-size:1.1rem;">تسجيل</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
