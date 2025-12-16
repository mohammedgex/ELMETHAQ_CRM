@extends('adminlte::page')

@section('title', 'تغيير كلمة المرور للمستخدم')

@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white text-center">
                <h4 class="mb-0 font-weight-bold">تغيير كلمة مرور المستخدم</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('user.changePassword', $user->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        {{-- الاسم --}}
                        <div class="form-group col-md-6">
                            <label>الاسم الكامل</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ $user->name }}" placeholder="أدخل الاسم الكامل" readonly>
                        </div>

                        {{-- كلمة المرور --}}
                        <div class="form-group col-md-6">
                            <label>كلمة المرور</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="أدخل كلمة المرور الجديدة" required>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- زر الحفظ --}}
                    <div class="form-group mt-3 text-center">
                        <button type="submit" class="btn btn-primary px-5">
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @if (session('success'))
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'تم بنجاح',
                    text: "{{ session('success') }}",
                    confirmButtonText: 'حسناً'
                });
            </script>
        @endif

    </div>
@endsection
