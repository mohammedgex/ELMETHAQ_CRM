@extends('layouts.app')

@section('content')
    <div class="container mt-5" style="max-width: 400px;">
        <div class="card">
            <div class="card-header text-center">
                <h4>تسجيل دخول الأدمن</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger text-center">
                        {{ $errors->first() }}
                    </div>
                @endif
                <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">اسم المستخدم</label>
                        <input type="text" class="form-control" id="username" name="username" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">كلمة المرور</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">دخول</button>
                </form>
            </div>
        </div>
    </div>
@endsection
