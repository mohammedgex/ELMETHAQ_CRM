@extends('layouts.app')
@section('title', 'اتصل بنا')
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow-sm" style="border-radius:18px; border:1px solid #e5e7eb;">
                    <div class="card-header text-center"
                        style="background: linear-gradient(135deg, #174A7C 60%, #B89C5A 100%); color: #fff; border-radius: 18px 18px 0 0;">
                        <h4 class="mb-0 fw-bold" style="letter-spacing:1px;">تواصل معنا</h4>
                    </div>
                    <div class="card-body"
                        style="background: linear-gradient(135deg, #fff 85%, #f8fafc 100%); border-radius:0 0 18px 18px;">
                        @if (session('success'))
                            <div class="alert alert-success text-center">{{ session('success') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('contact.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold" style="color:#174A7C;">الاسم</label>
                                <input type="text" class="form-control" id="name" name="name" required
                                    value="{{ old('name') }}">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold" style="color:#174A7C;">البريد
                                    الإلكتروني</label>
                                <input type="email" class="form-control" id="email" name="email" required
                                    value="{{ old('email') }}">
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label fw-bold" style="color:#174A7C;">الموضوع</label>
                                <input type="text" class="form-control" id="subject" name="subject" required
                                    value="{{ old('subject') }}">
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label fw-bold" style="color:#174A7C;">رسالتك</label>
                                <textarea class="form-control" id="message" name="message" rows="4" required>{{ old('message') }}</textarea>
                            </div>
                            <button type="submit" class="btn w-100 fw-bold"
                                style="background: linear-gradient(135deg, #174A7C 60%, #B89C5A 100%); color: #fff; border-radius: 50px; font-size:1.1rem;">إرسال</button>
                        </form>
                    </div>
                    <div class="card-footer bg-white border-0 mt-3">
                        <div class="text-center">
                            <h5 class="fw-bold mb-3" style="color:#174A7C;"><i class="fas fa-headset me-2"></i>طرق التواصل
                                المباشر</h5>
                            <div class="mb-2">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                <a href="mailto:hr@elmethaq.com" class="text-decoration-none"
                                    style="color:#174A7C;">hr@elmethaq.com</a>
                            </div>
                            <div class="mb-2">
                                <i class="fas fa-phone-alt text-success me-2"></i> 01288000245
                            </div>
                            <div class="mb-2">
                                <i class="fas fa-phone-alt text-success me-2"></i> 01288000239
                            </div>
                            <div class="mb-2">
                                <i class="fas fa-phone-alt text-success me-2"></i> 01228384111
                            </div>
                            <div class="mb-2">
                                <i class="fas fa-phone-alt text-success me-2"></i> 0235681797
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
