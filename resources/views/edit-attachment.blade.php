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

                @csrf

                <!-- بداية حقل العنوان + رفع الملف + المعاينة -->
                <div class="form-group p-3 mb-4 bg-white rounded border shadow-sm">
                    <div class="row align-items-start">
                        <!-- الحقول على اليمين -->
                        <div class="col-md-8">
                            <!-- عنوان المرفق -->
                            <div class="form-group mb-3">
                                <label class="fw-bold" style="color: #343a40;">عنوان المرفق</label>
                                <select id="attachmentTitle" class="form-control fw-bold"
                                    style="height: 60px; border-color: #343a40;" name="document_type">
                                    <option value="">اختر نوع المستند</option>
                                    @foreach ($fileTitles as $fileTitle)
                                        <option value="{{ $fileTitle->title }}"
                                            {{ (old('document_type') ?? $edit->document_type) == $fileTitle->title ? 'selected' : '' }}>
                                            {{ $fileTitle->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- رفع المرفق -->
                            <div class="form-group mb-2">
                                <label class="fw-bold" for="attachmentFile" style="color: #343a40;">رفع المرفق</label>
                                <div class="custom-file">
                                    <input type="file" name="file" class="custom-file-input preview-image-input"
                                        data-preview="#preview_attachment_file" id="attachmentFile">
                                    <label class="custom-file-label">اختر ملف</label>
                                </div>

                            </div>
                        </div>

                        <!-- المعاينة على اليسار -->
                        <div class="col-md-4">
                            <label class="fw-bold d-block mb-2" style="color: #343a40;">معاينة</label>
                            <div id="preview_attachment_file" class="border rounded p-2 text-center bg-light"
                                style="min-height: 130px;">
                                @php
                                    $extension = pathinfo($edit->file, PATHINFO_EXTENSION);
                                @endphp
                                @if (!empty($edit->file))
                                    @if (strtolower($extension) === 'pdf')
                                        <img src="https://cdn-icons-png.freepik.com/512/4726/4726010.png"
                                            class="img-thumbnail" style="max-width: 100px;" alt="PDF">
                                    @else
                                        <img src="{{ asset('storage/' . $edit->file) }}" class="img-thumbnail"
                                            style="max-width: 100px;" alt="Preview">
                                    @endif
                                @else
                                    <img src="https://via.placeholder.com/100x100?text=No+File" class="img-thumbnail"
                                        style="max-width: 100px; display: none;" alt="Preview">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- نهاية حقل العنوان + رفع الملف + المعاينة -->

                <!-- صف حالة المرفق والحالة على التطبيق -->
                <div class="row">
                    <!-- حالة المرفق -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-bold" style="color: #343a40;">حالة المرفق</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #343a40;" name="status"
                                required>
                                <option value="">اختر حالة المرفق</option>
                                <option value="لا يوجد بالمكتب"
                                    {{ (old('status') ?? $edit->status) == 'لا يوجد بالمكتب' ? 'selected' : '' }}>لا يوجد
                                    بالمكتب</option>
                                <option value="موجود بالمكتب"
                                    {{ (old('status') ?? $edit->status) == 'موجود بالمكتب' ? 'selected' : '' }}>موجود
                                    بالمكتب</option>
                            </select>
                        </div>
                    </div>

                    <!-- الحالة على التطبيق -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-bold" style="color: #343a40;">الحالة على التطبيق</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #343a40;"
                                name="required" required>
                                <option value="true"
                                    {{ (old('required') ?? $edit->required) == 'true' ? 'selected' : '' }}>إجباري</option>
                                <option value="false"
                                    {{ (old('required') ?? $edit->required) == 'false' ? 'selected' : '' }}>اختياري
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- حقل الملحوظة -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="fw-bold" style="color: #343a40;">ملحوظة</label>
                            <input type="text" class="form-control fw-bold" name="note"
                                value="{{ old('note') ?? $edit->note }}" style="border-color: #343a40; height: 60px;"
                                id="note">
                        </div>
                    </div>
                </div>

                <!-- زر الحفظ -->
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.preview-image-input').forEach(function(input) {
                input.addEventListener('change', function(e) {
                    const previewSelector = this.dataset.preview;
                    const previewContainer = document.querySelector(previewSelector);
                    const img = previewContainer.querySelector('img');
                    const file = e.target.files[0];

                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            img.src = event.target.result;
                            img.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    } else {
                        img.src = 'https://via.placeholder.com/100x100?text=No+File';
                        img.style.display = 'none';
                    }
                });
            });
        });
    </script>

@stop
