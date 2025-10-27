@extends('layouts.app', ['hideHeaderFooter' => true])

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('admin.partials.sidebar')
            <main class="col-md-10 ms-sm-auto px-md-4">
                <div class="pt-4">
                    <h2 class="mb-4">كل فرص العمل بالخارج</h2>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <a href="{{ route('admin.jobs') }}" class="btn btn-primary mb-3">إضافة فرصة عمل جديدة</a>
                    <table class="table table-bordered table-striped bg-white">
                        <thead class="table-dark">
                            <tr>
                                <th>الصورة</th>
                                <th>عنوان الوظيفة</th>
                                <th>تفاصيل الوظيفة</th>
                                <th>شرح الوظيفة</th>
                                <th>الإجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jobs as $job)
                                <tr>
                                    <td>
                                        @if ($job->image)
                                            <img src="{{ asset('job_images/' . $job->image) }}" alt="صورة الوظيفة"
                                                style="width:60px; height:60px; object-fit:cover; border-radius:8px;">
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>{{ $job->title }}</td>
                                    <td>{{ $job->details }}</td>
                                    <td>{{ $job->description }}</td>
                                    <td>
                                        <a href="{{ route('admin.jobs.edit', $job->id) }}"
                                            class="btn btn-warning btn-sm me-1">تعديل</a>
                                        <form method="POST" action="{{ route('admin.jobs.delete', $job->id) }}"
                                            style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('هل أنت متأكد من حذف هذه الوظيفة؟');">
                                                حذف
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">لا توجد فرص عمل بعد.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
@endsection
