@extends('adminlte::page')

@section('title', 'تعديل العميل المحتمل')

@section('content_header')
    <h1 class="text-center font-weight-bold d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-user-edit ml-2"></i>
            تعديل العميل ({{ $lead->name }})
        </div>
        <div>
            <a href="{{ route('leads-customers.index') }}">
                <button type="submit" class="btn btn-success btn-block font-weight-bold">
                    رجوع الي العملاء المحتملون
                </button>
            </a>
        </div>
    </h1>
@stop

@section('content')
    <div class="card card-primary card-outline shadow">
        <div class="card-body">
            <form action="{{ route('leads-customers.edit', $lead->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    {{-- معلومات أساسية --}}
                    <div class="col-md-12">
                        <div class="card bg-light mb-4">
                            <div class="card-header bg-primary text-white">
                                <strong><i class="fas fa-id-card-alt ml-2"></i> بيانات العميل</strong>
                            </div>
                            <div class="card-body row">
                                <div class="form-group col-md-6">
                                    <label>الاسم الكامل</label>
                                    <input type="text" class="form-control" name="name" value="{{ $lead->name }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label>الوظيفة المقدم عليها</label>
                                    <select class="form-control" name="job_title_id">
                                        <option value="">اختر الوظيفة</option>
                                        @foreach ($jobs as $job)
                                            <option value="{{ $job->id }}"
                                                {{ $lead->job_title_id == $job->id ? 'selected' : '' }}>
                                                {{ $job->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>السن</label>
                                    <input type="number" class="form-control" name="age" value="{{ $lead->age }}">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>رقم الهاتف</label>
                                    <input type="text" class="form-control" name="phone" value="{{ $lead->phone }}">
                                    @if ($errors->has('phone'))
                                        <div class="text-danger">
                                            {{ $errors->first('phone') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label>رقم هاتف اخر</label>
                                    <input type="text" class="form-control" name="phone_two"
                                        value="{{ $lead->phone_two }}">
                                    @if ($errors->has('phone_two'))
                                        <div class="text-danger">
                                            {{ $errors->first('phone_two') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group col-md-4">
                                    <label>الرقم القومي</label>
                                    <input type="text" class="form-control" name="card_id" value="{{ $lead->card_id }}">
                                    @if ($errors->has('card_id'))
                                        <div class="text-danger">
                                            {{ $errors->first('card_id') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- معلومات إضافية --}}
                    <div class="col-md-12">
                        <div class="card bg-light mb-4">
                            <div class="card-header bg-info text-white">
                                <strong><i class="fas fa-info-circle ml-2"></i> تفاصيل إضافية</strong>
                            </div>
                            <div class="card-body row">
                                <div class="form-group col-md-6">
                                    <label>المندوب</label>
                                    <select class="form-control" name="delegate_id">
                                        <option value="">اختر المندوب</option>
                                        @foreach ($delegates as $delegate)
                                            <option value="{{ $delegate->id }}"
                                                {{ $lead->delegate_id == $delegate->id ? 'selected' : '' }}>
                                                {{ $delegate->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>نوع الاختبار</label>
                                    <select class="form-control" name="test_type">
                                        <option value="">اختر النوع</option>
                                        @foreach (['اول اختبار', 'اعادة اختبار', 'قيادة امنة'] as $type)
                                            <option value="{{ $type }}"
                                                {{ $lead->test_type == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>التقييم</label>
                                    <select class="form-control" name="evaluation">
                                        <option value="">اختر التقييم</option>
                                        @foreach (['جارى المعالجة', 'مقبول', 'احتياطي', 'غير مقبول'] as $eval)
                                            <option value="{{ $eval }}"
                                                {{ $lead->evaluation == $eval ? 'selected' : '' }}>
                                                {{ $eval }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>المحافظة</label>
                                    <select class="form-control" name="governorate">
                                        <option value="">اختر المحافظة</option>
                                        @foreach ($governorates as $gov)
                                            <option value="{{ $gov }}"
                                                {{ $lead->governorate == $gov ? 'selected' : '' }}>
                                                {{ $gov }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>موعد التسجيل</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="date" class="form-control" name="registration_date"
                                            value="{{ $lead->registration_date }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- تحميل الملفات --}}
                    <div class="col-md-12">
                        <div class="card bg-light mb-4">
                            <div class="card-header bg-warning text-dark">
                                <strong><i class="fas fa-upload ml-2"></i> تحميل الملفات</strong>
                            </div>
                            <div class="card-body row">
                                @foreach ([
            'image' => 'الصورة الشخصية',
            'passport_photo' => 'جواز السفر',
            'img_national_id_card' => 'الرقم القومي من الامام',
            'img_national_id_card_back' => 'الرقم القومي من الخلف',
            'license_photo' => 'صورة اثبات المهنة',
        ] as $field => $label)
                                    <div class="form-group col-md-6">
                                        <label>{{ $label }}</label>

                                        {{-- المعاينة الحالية (من قاعدة البيانات) --}}
                                        @if (!empty($lead->$field))
                                            <div class="mb-2">
                                                <img src="{{ asset('storage/' . $lead->$field) }}"
                                                    id="preview-{{ $field }}" class="img-thumbnail"
                                                    style="max-height: 100px;">
                                            </div>
                                        @else
                                            <div class="mb-2">
                                                <img src="#" id="preview-{{ $field }}"
                                                    class="img-thumbnail d-none" style="max-height: 100px;">
                                            </div>
                                        @endif

                                        {{-- حقل اختيار الصورة --}}
                                        <input type="file" class="form-control" name="{{ $field }}"
                                            onchange="previewImage(this, 'preview-{{ $field }}')">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>


                    {{-- زر الحفظ --}}
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success btn-block font-weight-bold">
                            <i class="fas fa-save ml-2"></i> حفظ التعديلات
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function previewImage(input, previewId) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById(previewId);
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@stop
