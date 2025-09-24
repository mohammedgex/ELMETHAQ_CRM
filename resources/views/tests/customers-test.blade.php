@extends('adminlte::page')

@section('title', 'العملاء المحتملون في الاختبار')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;">العملاء المحتملون في اختبار: {{ $test->title }}</h1>
@stop

@section('content')
    <!-- نموذج إضافة عميل محتمل -->

    <div class="card card-primary ">
        <!-- جدول عرض العملاء المحتملين -->
        <div class="card mt-4">
            <div
                class="card-header d-flex justify-content-between align-items-center 
                        bg-dark text-white dark:bg-dark dark:text-white bg-light text-dark">
                <h3 class="card-title mb-0">
                    العملاء المحتملين
                </h3>
                <a href="{{ route('sign.lead.in.test', $test->id) }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-user-plus"></i> إضافة مختبر
                </a>
            </div>

            <div class="card">
                @auth
                    <div class="card-header d-flex justify-content-between align-items-center ccccc" style="">
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <select id="filter-age" class="form-control">
                                    <option value="">كل الأعمار</option>
                                    @foreach ($leads->pluck('age')->unique() as $age)
                                        <option value="{{ $age }}">{{ $age }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="filter-governorate" class="form-control">
                                    <option value="">كل المحافظات</option>
                                    @foreach ($leads->pluck('governorate')->unique() as $gov)
                                        <option value="{{ $gov }}">{{ $gov }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="filter-status" class="form-control">
                                    <option value="">كل الحالات</option>
                                    @foreach ($leads->pluck('status')->unique() as $status)
                                        <option value="{{ $status }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            عدد المحددين: <span id="selected-count">0</span>
                        </div>
                        <div>
                            عدد التقييمات: <span
                                id="selected-count">{{ $test->evaluations()->whereNotNull('evaluation')->count() }}</span>
                        </div>

                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="operationsDropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                العمليات
                            </button>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="operationsDropdown">
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#groupModal">
                                    <i class="fas fa-plus text-success"></i> تحويل كعميل أساسي
                                </button>
                            </div>
                        </div>

                    </div>
                @endauth

                <div class="card-body table-responsive p-0">
                    <table id="example" class="table table-hover text-center">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th>
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th>كود</th>
                                <th>الاسم</th>
                                <th>صورة</th>
                                <th>السن</th>
                                <th>الهاتف</th>
                                <th>المحافظة</th>
                                <th>الحالة</th>
                                <th>المندوب</th>
                                <th>عدد التقييمات</th>
                                <th>التقييم</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($leads as $lead)
                                <tr class="{{ $lead->evaluation == 'جارى المعالجة' ? 'bg-warning text-dark' : '' }}">
                                    <td>
                                        <input type="checkbox" class="lead-checkbox" name="lead_ids[]"
                                            value="{{ $lead->id }}">
                                    </td>
                                    <td>#{{ $lead->evaluations()->latest()->first()->code }}
                                    </td>
                                    <td>
                                        <a href="{{ route('leads-customers.update', $lead->id) }}" class="">
                                            {{ $lead->name }} </a>
                                    </td>
                                    <td>
                                        <a href="{{ asset('storage/' . $lead->image) }}" target="blank">
                                            <img src="{{ asset('storage/' . $lead->image) }}" width="40" height="40"
                                                class="img-circle" alt="صورة">
                                        </a>
                                    </td>
                                    <td>{{ $lead->age }}</td>
                                    <td>{{ $lead->phone }}</td>
                                    <td>{{ $lead->governorate }}</td>
                                    <td data-status="{{ $lead->status }}" class="lead-status">
                                        <span
                                            class="badge
                                        @if ($lead->status == 'عميل محتمل') bg-secondary
                                        @elseif ($lead->status == 'عميل اساسي') bg-success @endif">
                                            {{ $lead->status }}
                                        </span>
                                    </td>
                                    <td>{{ $lead->delegate->name ?? '-' }}</td>
                                    @php
                                        $evaluationCount = $lead
                                            ->evaluations()
                                            ->where('test_id', $test->id) // تأكد أن $test موجود في الـ View
                                            ->whereNotNull('evaluation') // لو كنت تريد فقط التقييمات التي لها نتيجة
                                            ->count();
                                    @endphp

                                    <td>{{ $evaluationCount }}</td> @php
                                        $lastEvaluation = $lead
                                            ->evaluations()
                                            ->whereNotNull('evaluation')
                                            ->latest()
                                            ->first();

                                        $evaluationText = $lastEvaluation->evaluation ?? 'لا يوجد تقييم';
                                        $colorClass = match ($evaluationText) {
                                            'مقبول' => 'text-success',
                                            'غير مقبول' => 'text-danger',
                                            'احتياطي' => 'text-primary',
                                            default => 'text-muted',
                                        };
                                    @endphp
                                    <td>
                                        <span class="{{ $colorClass }}">
                                            {{ $evaluationText }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1 flex-nowrap">
                                            <a href="{{ route('reports.test_card', [$lead->id, $test->id]) }}"
                                                target="_blank" class="btn btn-sm btn-info ">
                                                <i class="fas fa-file-alt"></i>
                                            </a>
                                            <a href="{{ route('leads-customers.show', $lead->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('tests.showEvaluation', [$test->id, $lead->id]) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="fas fa-chart-bar"></i>
                                            </a>
                                            <form action="{{ route('tests.removeLead', [$test->id, $lead->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                {{-- <tr>
                                    <td colspan="12">لا يوجد بيانات حالياً.</td>
                                </tr> --}}
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="modal fade" id="evaluationModal" tabindex="-1" role="dialog" aria-labelledby="evaluationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content"> <!-- استخدم modal-content بدلاً من card -->
                    <div class="modal-header">
                        <h5 class="modal-title">إضافة تقييم جديد</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="lead_id" id="modal-lead-id"> <!-- ID العميل هنا -->

                        <div class="card-body">
                            <div class="form-group">
                                <label>الكود</label>
                                <input type="text" name="code" class="form-control" readonly>
                            </div>

                            <div class="form-group">
                                <label>التقييم</label>
                                <select name="evaluation" class="form-control">
                                    <option value="مقبول">مقبول</option>
                                    <option value="غير مقبول">غير مقبول</option>
                                    <option value="احتياطي">احتياطي</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>الدرجة</label>
                                <select name="score" class="form-control">
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="form-group">
                                <label>إرفاق ملف</label>
                                <input type="file" name="attach" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>ملاحظات</label>
                                <textarea name="notes" class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @auth
            <!-- Modal لتعيين مجموعة -->
            <div class="modal fade" id="groupModal" tabindex="-1" aria-labelledby="groupModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">
                                <i class="fas fa-users mr-2"></i> تعيين مجموعة للعملاء المحددين
                            </h5>
                            <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="إغلاق">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form id="assignGroupForm" action="{{ route('customer.leadToCustomer') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="leads" id="selectedLeadsInput">

                                <div class="form-group">
                                    <label for="groupSelect">اختر المجموعة</label>
                                    <select class="form-control" id="groupSelect" name="group_id" required>
                                        <option value="" disabled selected>-- اختر المجموعة --</option>
                                        @foreach ($groups as $group)
                                            <option value="{{ $group->id }}">{{ $group->id }}: {{ $group->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times-circle mr-1"></i> إلغاء
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save mr-1"></i> حفظ التغييرات
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endauth

        <!-- Loading Overlay -->
        <div id="loading-overlay"
            style="display: none; position: fixed; z-index: 9999; top:0; left:0; width:100%; height:100%; background: rgba(255,255,255,0.8);">
            <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                <div class="spinner-border text-primary" role="status" style="width: 4rem; height: 4rem;">
                    <span class="sr-only">جارٍ التحميل...</span>
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

            /* Warning Row Styling - Light Mode */
            .table tbody tr.bg-warning {
                background: linear-gradient(135deg, #f2db89 0%, #f0ca30 100%) !important;
                color: #b7950b !important;
                border-left: 4px solid #f39c12;
                box-shadow: 0 2px 4px rgba(243, 156, 18, 0.1);
            }

            .table tbody tr.bg-warning td {
                color: #000000 !important;
            }

            .table tbody tr.bg-warning:hover {
                background: linear-gradient(135deg, #f3d56a 0%, #eeca37 100%) !important;
                box-shadow: 0 4px 8px rgba(243, 156, 18, 0.15);
            }

            /* Warning Row Styling - Dark Mode */
            body.dark-mode .table tbody tr.bg-warning {
                background: linear-gradient(135deg, #3e2723 0%, #4e342e 100%) !important;
                color: #ffb74d !important;
                border-left: 4px solid #ff9800;
                box-shadow: 0 2px 4px rgba(255, 152, 0, 0.2);
            }

            body.dark-mode .table tbody tr.bg-warning td {
                color: #ffb74d !important;
            }

            body.dark-mode .table tbody tr.bg-warning:hover {
                background: linear-gradient(135deg, #4e342e 0%, #5d4037 100%) !important;
                box-shadow: 0 4px 8px rgba(255, 152, 0, 0.25);
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
            $(document).on('click', '.open-evaluation-modal', function() {
                var leadId = $(this).data('lead-id');
                $('#modal-lead-id').val(leadId);
            });
            ['assignGroupForm', 'leadForm', "delete", "add"].forEach(function(formId) {
                var form = document.getElementById(formId);
                if (form) {
                    form.addEventListener('submit', function() {
                        document.getElementById('loading-overlay').style.display = 'block';
                    });
                }
            });
            // تحديث العداد
            function updateSelectedCount() {
                let count = document.querySelectorAll('.lead-checkbox:checked').length;
                document.getElementById('selected-count').textContent = count;
            }

            // تحديد الكل
            document.getElementById('select-all').addEventListener('change', function() {
                let checkboxes = document.querySelectorAll('.lead-checkbox');
                checkboxes.forEach(cb => cb.checked = this.checked);
                updateSelectedCount(); // تحديث العداد بعد التحديد الكلي
            });

            // عند تغيير أي checkbox فرعي
            document.querySelectorAll('.lead-checkbox').forEach(cb => {
                cb.addEventListener('change', updateSelectedCount);
            });
            $('#example').DataTable({
                dom: 'ltp', // l = lengthMenu (قائمة تغيير عدد الصفوف), t = الجدول, p = ترقيم الصفحات
                pageLength: 20, // القيمة الافتراضية
                lengthMenu: [
                    [10, 20, 50, -1],
                    [10, 25, 50, 100, 250, 500, 'الكل']
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
                },
                searching: false,
                ordering: true
            });
        </script>



        <script type="module">
            document.getElementById('assignGroupForm').addEventListener('submit', function(e) {
                e.preventDefault(); // منع الريفريش

                // جلب كل الـ checkboxes المختارة
                const checkboxes = Array.from(document.querySelectorAll('.lead-checkbox:checked'));
                if (checkboxes.length === 0) {
                    document.getElementById('loading-overlay').style.display = 'none';
                    Swal.fire({
                        title: "الرجاء اختيار عميل واحد على الأقل.",
                        icon: "error",
                        draggable: true
                    });
                    return;
                }

                const selectedIds = [];
                let hasExistingCustomer = false;

                // فحص كل تشيك بوكس
                checkboxes.forEach(cb => {
                    const leadId = parseInt(cb.value);
                    const row = cb.closest('tr');
                    const status = row.querySelector('.lead-status')?.dataset.status;
                    if (status === 'عميل اساسي') {
                        hasExistingCustomer = true;
                    }

                    selectedIds.push(leadId);
                });

                if (hasExistingCustomer) {
                    document.getElementById('loading-overlay').style.display = 'none';
                    Swal.fire({
                        title: "يوجد عميل أساسي بالفعل في الاختيارات.",
                        icon: "error",
                        draggable: true
                    });
                    return;
                }

                // تعبئة hidden input بقائمة الـ IDs
                document.getElementById('selectedLeadsInput').value = JSON.stringify(selectedIds);

                // إرسال الفورم
                this.submit();
            });

            document.addEventListener('DOMContentLoaded', function() {
                const ageFilter = document.getElementById('filter-age');
                const govFilter = document.getElementById('filter-governorate');
                const statusFilter = document.getElementById('filter-status');
                const dateFilter = document.getElementById('filter-date');
                const tableRows = document.querySelectorAll('tbody tr');

                function filterTable() {
                    const selectedAge = ageFilter.value;
                    const selectedGov = govFilter.value.toLowerCase();
                    const selectedStatus = statusFilter.value.toLowerCase();
                    const selectedDate = dateFilter.value;

                    tableRows.forEach(row => {
                        const age = row.cells[4]?.textContent.trim(); // السن
                        const gov = row.cells[6]?.textContent.trim().toLowerCase(); // المحافظة
                        const status = row.cells[7]?.textContent.trim().toLowerCase(); // الحالة
                        const date = row.cells[9]?.textContent.trim(); // تاريخ التسجيل

                        const matchesAge = !selectedAge || age === selectedAge;
                        const matchesGov = !selectedGov || gov === selectedGov;
                        const matchesStatus = !selectedStatus || status === selectedStatus;
                        const matchesDate = !selectedDate || date === selectedDate;

                        if (matchesAge && matchesGov && matchesStatus && matchesDate) {
                            row.style.display = "";
                        } else {
                            row.style.display = "none";
                        }
                    });
                }

                ageFilter.addEventListener('change', filterTable);
                govFilter.addEventListener('change', filterTable);
                statusFilter.addEventListener('change', filterTable);
                dateFilter.addEventListener('change', filterTable);
            });
        </script>


    @stop
