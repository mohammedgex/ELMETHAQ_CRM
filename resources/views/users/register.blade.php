@extends('adminlte::page')

@section('title', 'إنشاء حساب جديد')

@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white text-center">
                <h4 class="mb-0 font-weight-bold">إنشاء حساب جديد</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        {{-- الاسم --}}
                        <div class="form-group col-md-6">
                            <label>الاسم الكامل</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="أدخل الاسم الكامل" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- البريد الإلكتروني --}}
                        <div class="form-group col-md-6">
                            <label>البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="أدخل البريد الإلكتروني" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- كلمة المرور --}}
                        <div class="form-group col-md-6">
                            <label>كلمة المرور</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="أدخل كلمة المرور"
                                required>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- تأكيد كلمة المرور --}}
                        <div class="form-group col-md-6">
                            <label>تأكيد كلمة المرور</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="أعد كتابة كلمة المرور" required>
                        </div>

                        {{-- الصلاحيات --}}
                        <div class="form-group col-md-12">
                            <label>الصلاحية</label>
                            <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                                <option value="">اختر الصلاحية</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>مشرف (Admin)</option>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>مستخدم (User)</option>
                            </select>
                            @error('role')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- زر الحفظ --}}
                    <div class="form-group mt-3 text-center">
                        <button type="submit" class="btn btn-primary px-5">
                            إنشاء الحساب
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
