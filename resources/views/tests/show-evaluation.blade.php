@extends('adminlte::page')

@section('title', 'العملاء المحتملون في الاختبار')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;">العملاء المحتملون في اختبار: {{ $test->title }}</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="إغلاق">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="card card-primary">
        <div class="card mt-4">
            <div class="card-header bg-dark d-flex align-items-center">
                <h3 class="card-title text-white mb-0">تقييمات العميل: {{ $lead->name }}</h3>

                @if ($evaluations->where('evaluation', '!=', null)->count() > 0)
                    <a href="#" class="btn btn-sm text-white fw-bold ml-auto" style="background-color: #28a745;"
                        title="إعادة اختبار لهذا العميل" data-toggle="modal" data-target="#evaluationModal">
                        <i class="fas fa-redo-alt"></i> إعادة اختبار
                    </a>
                @endif
            </div>

            <div class="card-body">
                @if ($evaluations->count() > 0)
                    <div class="row">
                        @foreach ($evaluations->sortByDesc('created_at') as $evaluation)
                            @if ($evaluation->evaluation)
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow border-0 rounded-lg position-relative">

                                        {{-- Ribbon أعلى الصورة --}}
                                        <div class="ribbon-wrapper ribbon-lg">
                                            <div
                                                class="ribbon
                                            bg-{{ $evaluation->evaluation === 'مقبول'
                                                ? 'success'
                                                : ($evaluation->evaluation === 'غير مقبول'
                                                    ? 'danger'
                                                    : 'warning') }}
                                            text-uppercase">
                                                {{ $evaluation->evaluation }} {{ $evaluation->score }}
                                            </div>
                                        </div>

                                        {{-- عرض صورة إذا كانت صورة --}}
                                        <img src="{{ asset('storage/' . $evaluation->attach) }}"
                                            class="card-img-top img-fluid" style="max-height: 200px; object-fit: cover;"
                                            alt="مرفق التقييم">

                                        <div class="card-body">

                                            <p class="mb-2">
                                                <i class="fas fa-barcode text-muted"></i>
                                                <strong>الكود:</strong> {{ $evaluation->code }}
                                            </p>

                                            @if ($evaluation->notes)
                                                <p class="mb-2">
                                                    <i class="fas fa-sticky-note text-info"></i>
                                                    <strong>ملاحظات:</strong> {{ $evaluation->notes }}
                                                </p>
                                            @endif

                                            @if ($evaluation->attach && !Str::endsWith($evaluation->attach, ['.jpg', '.jpeg', '.png', '.webp']))
                                                <p class="mb-2">
                                                    <i class="fas fa-paperclip text-secondary"></i>
                                                    <strong>مرفق:</strong>
                                                    <a href="{{ asset('storage/' . $evaluation->attach) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary ml-2">
                                                        <i class="fas fa-eye"></i> عرض الملف
                                                    </a>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-4">
                                    <form action="{{ route('evaluations.store', $evaluation->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div
                                            class="card border-left-{{ $evaluation->evaluation === 'مقبول' ? 'success' : ($evaluation->evaluation === 'غير مقبول' ? 'danger' : 'warning') }} shadow">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <i class="fas fa-clipboard-check"></i> اختبار
                                                    #{{ $evaluation->test_id }}
                                                </h5>

                                                <div class="form-group">
                                                    <label>الكود</label>
                                                    <input type="text" name="code" class="form-control"
                                                        value="{{ $evaluation->code }}" readonly>
                                                </div>

                                                <div class="form-group">
                                                    <label>التقييم</label>
                                                    <select name="evaluation" class="form-control" required>
                                                        <option value="">اختر التقييم</option>
                                                        <option value="مقبول"
                                                            {{ $evaluation->evaluation == 'مقبول' ? 'selected' : '' }}>
                                                            مقبول</option>
                                                        <option value="غير مقبول"
                                                            {{ $evaluation->evaluation == 'غير مقبول' ? 'selected' : '' }}>
                                                            غير مقبول</option>
                                                        <option value="احتياطي"
                                                            {{ $evaluation->evaluation == 'احتياطي' ? 'selected' : '' }}>
                                                            احتياطي</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="score" class="font-weight-bold">
                                                        <i class="fas fa-star text-warning"></i> الدرجة
                                                    </label>
                                                    <select name="score" id="score" class="form-control select2bs4"
                                                        style="width: 100%;" required>
                                                        <option disabled selected>اختر الدرجة من 1 إلى 10</option>
                                                        @for ($i = 1; $i <= 10; $i++)
                                                            <option value="{{ $i }}"
                                                                {{ isset($evaluation) && $evaluation->score == $i ? 'selected' : '' }}>
                                                                {{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>


                                                <div class="form-group">
                                                    <label>ملاحظات</label>
                                                    <textarea name="notes" class="form-control" rows="2">{{ $evaluation->notes }}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label>مرفق</label>
                                                    <div id="file-drop-zone" class="border rounded p-3 bg-light text-center"
                                                        style="min-height: 120px; cursor: pointer;">
                                                        <p class="text-muted mb-1">📎 اسحب الملف هنا أو اضغط للاختيار أو
                                                            الصق (Ctrl + V)</p>
                                                        <input type="file" name="attach" id="attachInput"
                                                            class="form-control d-none" required>
                                                        <p id="file-name" class="small text-primary mt-2"></p>
                                                    </div>
                                                    @if ($evaluation->attach)
                                                        <a href="{{ asset('storage/' . $evaluation->attach) }}"
                                                            target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                                            <i class="fas fa-paperclip"></i> عرض الملف الحالي
                                                        </a>
                                                    @endif
                                                </div>

                                                <button type="submit" class="btn btn-primary btn-block mt-3">
                                                    <i class="fas fa-save"></i> حفظ التعديل
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        لا توجد تقييمات حتى الآن لهذا العميل.
                    </div>
                @endif


            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="evaluationModal" tabindex="-1" role="dialog" aria-labelledby="evaluationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="evaluationModalLabel"><i class="fas fa-clipboard-check"></i> إعادة تقييم
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="إغلاق">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- هنا النموذج --}}
                    <form action="{{ route('evaluations.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                        <input type="hidden" name="test_id" value="{{ $test->id }}">
                        <div class="row">
                            <div class="col-md-12">


                                <div class="form-group">
                                    <label>التقييم</label>
                                    <select name="evaluation" class="form-control" required>
                                        <option value="">اختر التقييم</option>
                                        <option value="مقبول">مقبول</option>
                                        <option value="غير مقبول">غير مقبول</option>
                                        <option value="احتياطي">احتياطي</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><i class="fas fa-star text-warning"></i> الدرجة</label>
                                    <select name="score" class="form-control" required>
                                        <option disabled selected>اختر الدرجة من 1 إلى 10</option>
                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>ملاحظات</label>
                                    <textarea name="notes" class="form-control" rows="2"></textarea>
                                </div>

                                <div class="form-group p-3 mb-4 bg-white rounded border shadow-sm">
                                    <label for="image">المرفق</label>
                                    <div class="custom-file mb-2">
                                        <input type="file" name="attach"
                                            class="custom-file-input preview-image-input" data-preview="#preview_image"
                                            id="dd" required>
                                        <label class="custom-file-label">اختر صورة</label>
                                    </div>
                                    <div id="preview_image" class="border rounded p-2 text-center bg-light"
                                        style="min-height: 130px;">
                                        <img id="image_preview_tag"
                                            src="https://via.placeholder.com/100x100?text=No+Image" class="img-thumbnail"
                                            style="max-width: 100px; display: none;" alt="Preview">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-3">
                            <i class="fas fa-save"></i> حفظ التعديل
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop



@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <style>
        .loader {
            border: 5px solid #f3f3f3;
            /* لون الخلفية */
            border-top: 5px solid #4caf50;
            /* لون الدائرة المتحركة */
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1.5s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loading-text {
            font-size: 16px;
            text-align: center;
        }

        .ccccc::after {
            display: none;
        }
    </style>


@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery & DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.querySelector('.preview-image-input');
            const previewImg = document.getElementById('image_preview_tag');

            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        previewImg.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewImg.src = '';
                    previewImg.style.display = 'none';
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropZone = document.getElementById('file-drop-zone');
            const input = document.getElementById('attachInput');
            const fileName = document.getElementById('file-name');

            // ✅ عند الضغط على المربع افتح نافذة اختيار الملف
            dropZone.addEventListener('click', () => input.click());

            // ✅ تحديث اسم الملف عند الاختيار
            input.addEventListener('change', () => {
                if (input.files.length > 0) {
                    fileName.textContent = `تم اختيار: ${input.files[0].name}`;
                }
            });

            // ✅ منع السلوك الافتراضي للسحب
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(event => {
                dropZone.addEventListener(event, e => {
                    e.preventDefault();
                    e.stopPropagation();
                });
            });

            // ✅ تأثير عند السحب فوق المربع
            ['dragenter', 'dragover'].forEach(event => {
                dropZone.addEventListener(event, () => dropZone.classList.add('border-primary'));
            });
            ['dragleave', 'drop'].forEach(event => {
                dropZone.addEventListener(event, () => dropZone.classList.remove('border-primary'));
            });

            // ✅ عند إفلات الملف داخل المربع
            dropZone.addEventListener('drop', e => {
                const file = e.dataTransfer.files[0];
                if (file) setFileToInput(file);
            });

            // ✅ عند اللصق (Ctrl + V)
            document.addEventListener('paste', e => {
                const items = e.clipboardData.items;
                for (const item of items) {
                    if (item.kind === 'file') {
                        const file = item.getAsFile();
                        setFileToInput(file);
                        break;
                    }
                }
            });

            // ✅ دالة لتعيين الملف داخل input وتحديث الاسم
            function setFileToInput(file) {
                const dt = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;
                fileName.textContent = `تم اختيار: ${file.name}`;
            }
        });
    </script>
@stop
