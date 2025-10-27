@extends('layouts.app', ['hideHeaderFooter' => true])

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('admin.partials.sidebar')
            <main class="col-md-10 ms-sm-auto px-md-4">
                <div class="pt-4">
                    <h2 class="mb-4">إضافة فرصة عمل جديدة</h2>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('admin.jobs.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">عنوان الوظيفة</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="details" class="form-label">تفاصيل الوظيفة</label>
                            <input type="text" class="form-control" id="details" name="details" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">شرح الوظيفة</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">صورة الوظيفة (اختياري)</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-success">إضافة</button>
                    </form>
                </div>
            </main>
        </div>
    </div>
@endsection
