@extends('adminlte::page')

@section('title', 'أسئلة الوظائف')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;">أسئلة الوظائف</h1>
@stop

@section('content')
    <div class="row">
        <!-- ✅ قسم إضافة/تعديل سؤال -->
        <div class="col-md-12 mb-4">
            <div class="card shadow-lg p-4 border-0" style="border-radius: 15px; background-color: #f8f9fa;">
                <h4 class="mb-3 text-dark font-weight-bold">إضافة سؤال جديد</h4>
                <form action="{{ route('questions.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- اختيار الوظيفة -->
                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold">الوظيفة</label>
                            <select class="form-control" name="job_title_id" required>
                                <option value="">اختر وظيفة</option>
                                @foreach ($jobs as $job)
                                    <option value="{{ $job->id }}">{{ $job->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold">نص السؤال</label>
                            <input type="text" class="form-control" name="question" placeholder="أدخل نص السؤال"
                                required>
                        </div>
                        <!-- نص السؤال -->
                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold">اظهاره في كارت الاختبار</label>
                            <select class="form-control" name="show_in_report" required>
                                <option value="no">عدم إظهار</option>
                                <option value="yes">إظهار</option>
                            </select>
                        </div>

                        <!-- نوع السؤال -->
                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold">نوع السؤال</label>
                            <select class="form-control" name="type" id="questionType" onchange="toggleOptionsField()"
                                required>
                                <option value="text">نص</option>
                                <option value="textarea">نص طويل</option>
                                <option value="select">قائمة منسدلة</option>
                                <option value="radio">اختيار واحد (Radio)</option>
                                <option value="checkbox">اختيارات متعددة</option>
                                <option value="date">تاريخ</option>
                                <option value="number">رقم</option>
                            </select>
                        </div>

                        <!-- الخيارات -->
                        <div class="col-md-12 form-group d-none" id="optionsField">
                            <label class="font-weight-bold">الخيارات (افصل بينهم بفواصل)</label>
                            <input type="text" class="form-control" name="options" placeholder="مثال: نعم, لا, ربما">
                        </div>
                    </div>

                    <button type="submit" class="btn mt-3 px-4 shadow-sm w-100"
                        style="background-color: #28a745; color: white;">
                        إضافة سؤال جديد
                    </button>
                </form>
            </div>
        </div>

        <!-- ✅ قسم عرض الأسئلة -->
        <div class="col-md-12">
            <div class="card shadow-lg p-4 border-0" style="border-radius: 15px; background-color: #ccc;">
                <h4 class="mb-3" style="color: #343a40; font-weight: bold;">
                    قائمة الأسئلة <span class="text-success">({{ $questions->count() }})</span>
                </h4>

                <div class="table-responsive">
                    <table class="table table-hover text-center" id="questionsTable">
                        <thead style="background-color: #343a40; color: white;">
                            <tr>
                                <th>#</th>
                                <th>الوظيفة</th>
                                <th>نص السؤال</th>
                                <th>النوع</th>
                                <th>الخيارات</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($questions as $q)
                                <tr class="table-light">
                                    <td>#{{ $q->id }}</td>
                                    <td>{{ $q->jobTitle->title ?? '-' }}</td>
                                    <td>{{ $q->question }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $q->type }}</span>
                                    </td>
                                    <td>
                                        @if ($q->options)
                                            @foreach (json_decode($q->options) as $opt)
                                                <span class="badge bg-warning text-dark">{{ $opt }}</span>
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="d-flex justify-content-center gap-1">
                                        {{-- <a href="{{ route('questions.edit', $q->id) }}"
                                            class="btn btn-sm btn-outline-success shadow-sm" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a> --}}

                                        <form action="{{ route('questions.destroy', $q->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger shadow-sm" type="submit"
                                                title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        function toggleOptionsField() {
            let type = document.getElementById("questionType").value;
            let optionsField = document.getElementById("optionsField");
            optionsField.classList.toggle("d-none", !(type === "select" || type === "radio" || type === "checkbox"));
        }
    </script>
@stop
