@extends('adminlte::page')

@section('title', 'تعديل المرفق')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;">تعديل المرفق </h1>
@stop

@section('content')
    <div class="row">
        <!-- ✅ قسم إضافة مجموعة -->
        <div class="col-md-12 mb-4">
            <form action="{{ route('attachments.edit', $edit->id) }}" method="POST" enctype="multipart/form-data"
                id="attachments" class="tab-pane">
                <h4>تعديل المرفق</h4>
                @csrf

                <div class="row">
                    <!-- حقل عنوان المرفق -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-bold" style="color: #997a44;">عنوان المرفق</label>
                            <select id="attachmentTitle" class="form-control fw-bold"
                                style="height: 60px; border-color: #997a44;" name="document_type" required>
                                <option value="">اختر نوع المستند</option>
                                @foreach ($fileTitles as $fileTitle)
                                    <option value="{{ $fileTitle->title }}"
                                        {{ (old('document_type') ?? ($edit->document_type ?? '')) == $fileTitle->title ? 'selected' : '' }}>
                                        {{ $fileTitle->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- حقل رفع المرفق -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-bold" style="color: #997a44;">رفع المرفق</label>
                            <input type="file" class="form-control fw-bold" name="file"
                                style="border-color: #997a44; height: 60px;" id="attachmentFile">
                            @if (!empty($edit->file))
                                <small class="text-success">ملف حالي: <a href="{{ asset('storage/' . $edit->file) }}"
                                        target="_blank">عرض الملف</a></small>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- حالة المرفق -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-bold" style="color: #997a44;">حالة المرفق</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;" name="status"
                                required>
                                <option value="">اختر حالة المرفق</option>
                                <option value="لا يوجد بالمكتب"
                                    {{ (old('status') ?? ($edit->status ?? '')) == 'لا يوجد بالمكتب' ? 'selected' : '' }}>
                                    لا يوجد بالمكتب</option>
                                <option value="موجود بالمكتب"
                                    {{ (old('status') ?? ($edit->status ?? '')) == 'موجود بالمكتب' ? 'selected' : '' }}>
                                    موجود بالمكتب</option>
                            </select>
                        </div>
                    </div>

                    <!-- الحالة على التطبيق -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-bold" style="color: #997a44;">الحالة على التطبيق</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                name="required" required>
                                <option value="true"
                                    {{ (old('required') ?? ($edit->required ?? '')) == 'true' ? 'selected' : '' }}>
                                    إجباري</option>
                                <option value="false"
                                    {{ (old('required') ?? ($edit->required ?? '')) == 'false' ? 'selected' : '' }}>
                                    اختياري</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- الملحوظة -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="fw-bold" style="color: #997a44;">ملحوظة</label>
                            <input type="text" class="form-control fw-bold" name="note"
                                value="{{ old('note') ?? ($edit->note ?? '') }}"
                                style="border-color: #997a44; height: 60px;" id="note">
                        </div>
                    </div>
                </div>

                <!-- زر حفظ -->
                <button type="submit" class="btn text-white fw-bold my-4 w-100"
                    style="background-color:#28a745; padding:10px; font-size:20px;">
                    حفظ التعديلات (F2)
                </button>
            </form>

        </div>
    </div>
@stop

@section('css')
@stop

@section('js')

@stop
