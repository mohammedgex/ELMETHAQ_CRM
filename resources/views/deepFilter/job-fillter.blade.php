@extends('adminlte::page')

@section('title', 'فلترة العملاء')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-filter text-primary"></i>
                        فلترة العملاء
                    </h1>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-lg p-4">
        <h4 class="mb-3">اختر وظيفة للفلترة</h4>
        <form id="filterForm" method="GET" action="{{ route('leads-customer.job.filter') }}">
            @csrf

            <!-- اختيار الوظيفة -->
            <div class="form-group">
                <label for="job_title_id" class="form-label">
                    <i class="fas fa-briefcase"></i> الوظيفة
                </label>
                <select name="job_title_id" id="job_title_id" class="form-control select2" required>
                    <option value="">-- اختر وظيفة --</option>
                    @foreach ($job_titles as $job)
                        <option value="{{ $job->id }}">{{ $job->title }}</option>
                    @endforeach
                </select>
            </div>

            <!-- مكان الأسئلة -->
            <div id="questionsContainer" class="mt-4"></div>

            <button type="submit" class="btn btn-primary mt-3 w-100">
                <i class="fas fa-search"></i> تنفيذ الفلترة
            </button>
        </form>
    </div>

    @if (isset($leads) && $leads->count() > 0)
        <div id="results-section" style="">
            <div class="table-responsive">
                <table class="table table-hover text-center" id="example">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th>رقم</th>
                            <th>
                                <input type="checkbox" class="width-input" id="select-all">
                            </th>
                            <th>كود</th>
                            <th>الاسم</th>
                            <th>صورة</th>
                            <th>السن</th>
                            <th>الهاتف</th>
                            <th>المحافظة</th>
                            <th>الحالة</th>
                            <th>المندوب</th>
                            <th>الاختبارات</th>
                            <th>الوظيفة</th>
                            <th>تاريخ التسجيل</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leads as $lead)
                            <tr class="{{ $lead->evaluation == 'جارى المعالجة' ? 'bg-warning text-dark' : '' }}">
                                <td>{{ $loop->index + 1 }}</td>
                                <td>
                                    <input type="checkbox" class="lead-checkbox width-input" name="lead_ids[]"
                                        value="{{ $lead->id }}">
                                </td>
                                <td>#{{ $lead->id }}</td>
                                <td>
                                    <a href="{{ route('leads-customers.show', $lead->id) }}" class="">
                                        {{ $lead->name }} </a>
                                </td>
                                <td>
                                    <a href="{{ asset('storage/' . $lead->image) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $lead->image) }}" width="40" height="40"
                                            class="img-circle" alt="صورة العميل" loading="lazy">
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
                                <td>
                                    @if ($lead->tests->count())
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                {{ $lead->tests->count() }}
                                            </a>
                                            <div class="dropdown-menu">
                                                @foreach ($lead->tests as $test)
                                                    <a class="dropdown-item" title="{{ $test->title }}"
                                                        href="{{ route('test.leads', $test->id) }}">
                                                        {{ $test->title }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $lead->jobTitle->title }}</td>
                                <td>{{ $lead->registration_date }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-1 flex-nowrap">
                                        <a href="{{ route('leads-customers.update', $lead->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if (auth()->user()->role == 'admin')
                                            <form id="delete" action="{{ route('leads-customers.delete', $lead->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @elseif (isset($leads) && $leads->count() == 0)
        <div id="results-section" style="">
            <h1>لا توجد بيانات</h1>
        </div>
    @endif
@stop
@section('css')
    <style>
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
    <script>
        $(document).ready(function() {

            // عند اختيار وظيفة
            $('#job_title_id').on('change', function() {
                let jobId = $(this).val();
                if (!jobId) return;

                // نجيب الأسئلة
                let url = "{{ route('job.questions', ':id') }}";
                url = url.replace(':id', jobId);
                $.get(url, function(res) {
                    let container = $('#questionsContainer');
                    container.empty();

                    if (res.questions.length === 0) {
                        container.append('<p class="text-muted">لا توجد أسئلة لهذه الوظيفة.</p>');
                        return;
                    }

                    res.questions.forEach(q => {
                        let field = '';
                        switch (q.type) {
                            case 'text':
                                field =
                                    `<input type="text" name="answers[${q.id}]" class="form-control" placeholder="${q.question}">`;
                                break;
                            case 'textarea':
                                field =
                                    `<textarea name="answers[${q.id}]" class="form-control" rows="3" placeholder="${q.question}"></textarea>`;
                                break;
                            case 'select':
                                let opts = JSON.parse(q.options || '[]');
                                field = `<select name="answers[${q.id}]" class="form-control">
                                <option value="">-- اختر --</option>`;
                                opts.forEach(o => {
                                    field += `<option value="${o}">${o}</option>`;
                                });
                                field += `</select>`;
                                break;
                            case 'radio':
                                let radioOpts = JSON.parse(q.options || '[]');
                                field = radioOpts.map(o => `
                                <label class="mr-3"><input type="radio" name="answers[${q.id}]" value="${o}"> ${o}</label>
                            `).join('');
                                break;
                            case 'checkbox':
                                let checkOpts = JSON.parse(q.options || '[]');
                                field = checkOpts.map(o => `
                                <label class="mr-3"><input type="checkbox" name="answers[${q.id}][]" value="${o}"> ${o}</label>
                            `).join('');
                                break;
                            case 'date':
                                field =
                                    `<input type="date" name="answers[${q.id}]" class="form-control">`;
                                break;
                            case 'number':
                                field =
                                    `<input type="number" name="answers[${q.id}]" class="form-control">`;
                                break;
                        }

                        container.append(`
                        <div class="form-group">
                            <label><i class="fas fa-question-circle"></i> ${q.question}</label>
                            ${field}
                        </div>
                    `);
                    });
                });
            });
        });
    </script>
@stop
