@extends('adminlte::page')

@section('title', 'أنواع التأشيرات')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;"> تعريف التأشيرات</h1>
@stop

@section('content')
    <div class="row">
        <!-- ✅ قسم إضافة مجموعة -->
        <div class="col-md-12 mb-4">
            @if ($visaTypeEdit->outgoing_number === '')
                <div class="card shadow-sm p-4 border-0 animate__animated animate__fadeIn visa-card-container">

                    <form action="{{ route('visa-type.create') }}" method="POST" id="visa-type">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="custom-label">نوع التأشيرة</label>
                                <select class="form-control custom-input" name="visa_peroid" required>
                                    <option value="">اختر النوع</option>
                                    <option value='تأشيرة العمل المؤقت لخدمات الحج والعمرة'>تأشيرة العمل المؤقت لخدمات الحج
                                        والعمرة</option>
                                    <option value='عمل'>عمل</option>
                                    <option value="عمل مؤقت">عمل مؤقت</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="custom-label">اسم التأشيرة</label>
                                <input type="text" class="form-control custom-input" name="name"
                                    placeholder="أدخل اسم التأشيرة" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="custom-label">رقم السجل</label>
                                <input type="number" class="form-control custom-input" name="registration_number"
                                    placeholder="أدخل رقم السجل" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="custom-label">رقم الصادر</label>
                                <input type="number" class="form-control custom-input" name="outgoing_number"
                                    placeholder="أدخل رقم الصادر" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="custom-label">القنصلية</label>
                                <select class="form-control custom-input" name="embassy_id" required>
                                    <option value="">اختر القنصلية</option>
                                    @foreach ($embassions as $embassy)
                                        <option value="{{ $embassy->id }}">{{ $embassy->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="custom-label">الكفيل</label>
                                <select class="form-control custom-input" name="sponser_id" required>
                                    <option value="">اختر الكفيل</option>
                                    @foreach ($sponsers as $sponser)
                                        <option value="{{ $sponser->id }}">{{ $sponser->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="custom-label">الغرض</label>
                                <input type="text" class="form-control custom-input" name="porpose"
                                    value="{{ old('porpose', $visaTypeEdit->porpose ?? '') }}" placeholder="أدخل الغرض"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="custom-label">تاريخ اصدار التاشيرة</label>
                                <input type="date" class="form-control custom-input" name="issuing_visa"
                                    value="{{ old('issuing_visa') }}" required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success btn-lg w-100 shadow-sm main-btn">
                                <i class="fas fa-save ml-2"></i> حفظ بيانات التأشيرة
                            </button>
                        </div>
                    </form>

                    <style>
                        /* --- التصميم الموحد والحل لمشكلة اللون الأسود --- */

                        .visa-card-container {
                            background-color: #ffffff !important;
                            border-radius: 15px;
                            border: 1px solid #edf2f7;
                        }

                        .card-title-text {
                            color: #2c3e50 !important;
                            /* لون هيدر الصفحة الموحد */
                            font-weight: 700 !important;
                        }

                        .border-bottom-custom {
                            border-bottom: 2px solid #f4f7f6;
                        }

                        .custom-label {
                            color: #000 !important;
                            /* لون رمادي غامق وواضح جداً في اللايت مود */
                            font-weight: 600;
                            font-size: 0.92rem;
                            margin-bottom: 8px;
                            display: block;
                        }

                        .custom-input {
                            background-color: #ffffff !important;
                            border: 1px solid #dce1e7 !important;
                            color: #2d3436 !important;
                            /* لون النص داخل المدخل */
                            border-radius: 8px !important;
                            height: 45px !important;
                        }

                        .badge-soft-success {
                            background-color: rgba(39, 174, 96, 0.1);
                            color: #27ae60;
                            font-weight: 600;
                        }

                        /* --- دعم الدارك مود (بناءً على تفضيلات النظام) --- */
                        @media (prefers-color-scheme: dark) {
                            .visa-card-container {}

                            .card-title-text {
                                color: #ffffff !important;
                            }

                            .custom-label {
                                color: #000 !important;
                            }

                            .custom-input {
                                /* background-color: #2b2b40 !important; */
                                border-color: #3f3f5f !important;
                                color: #000 !important;
                            }

                            .border-bottom-custom {
                                border-bottom-color: #2b2b40;
                            }

                            input[type="date"]::-webkit-calendar-picker-indicator {
                                filter: invert(1);
                            }
                        }

                        .main-btn {
                            background-color: #27ae60 !important;
                            /* تطابق مع accent-color */
                            border: none;
                            font-weight: bold;
                            transition: all 0.3s ease;
                        }

                        .main-btn:hover {
                            background-color: #219150 !important;
                            transform: translateY(-2px);
                            box-shadow: 0 4px 12px rgba(39, 174, 96, 0.2);
                        }
                    </style>
                </div>
            @else
                <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn visa-card-custom">
                    <h4 class="mb-4 card-main-title">إضافة تأشيرة جديدة</h4>

                    <form action="{{ route('visa-type.edit', $visaTypeEdit->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="custom-field-label">نوع التأشيرة</label>
                                <select class="form-control custom-field-input fw-bold" name="visa_peroid" required>
                                    <option value="">اختر النوع</option>
                                    <option value="تأشيرة العمل المؤقت لخدمات الحج والعمرة"
                                        {{ old('visa_peroid', $visaTypeEdit->visa_peroid) == 'تأشيرة العمل المؤقت لخدمات الحج والعمرة' ? 'selected' : '' }}>
                                        تأشيرة العمل المؤقت لخدمات الحج والعمرة
                                    </option>
                                    <option value="عمل"
                                        {{ old('visa_peroid', $visaTypeEdit->visa_peroid) == 'عمل' ? 'selected' : '' }}>عمل
                                    </option>
                                    <option value="عمل مؤقت"
                                        {{ old('visa_peroid', $visaTypeEdit->visa_peroid) == 'عمل مؤقت' ? 'selected' : '' }}>
                                        عمل مؤقت</option>
                                </select>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label class="custom-field-label">اسم التأشيرة</label>
                                <input type="text" class="form-control custom-field-input" name="name"
                                    value="{{ $visaTypeEdit->name }}" placeholder="أدخل اسم التأشيرة" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="custom-field-label">رقم السجل</label>
                                <input type="number" class="form-control custom-field-input"
                                    value="{{ $visaTypeEdit->registration_number }}" name="registration_number"
                                    placeholder="أدخل رقم السجل" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="custom-field-label">رقم الصادر</label>
                                <input type="number" class="form-control custom-field-input" name="outgoing_number"
                                    placeholder="أدخل رقم الصادر" required value="{{ $visaTypeEdit->outgoing_number }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="custom-field-label">القنصلية</label>
                                <select class="form-control custom-field-input fw-bold" name="embassy_id" required>
                                    <option value="">اختر القنصلية</option>
                                    @foreach ($embassions as $embassy)
                                        <option value="{{ $embassy->id }}"
                                            {{ old('embassy_id', $visaTypeEdit->embassy_id ?? '') == $embassy->id ? 'selected' : '' }}>
                                            {{ $embassy->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="custom-field-label">الكفيل</label>
                                <select class="form-control custom-field-input fw-bold" name="sponser_id" required>
                                    <option value="">اختر الكفيل</option>
                                    @foreach ($sponsers as $sponser)
                                        <option value="{{ $sponser->id }}"
                                            {{ old('sponser_id', $visaTypeEdit->sponser_id ?? '') == $sponser->id ? 'selected' : '' }}>
                                            {{ $sponser->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="custom-field-label">الغرض</label>
                                <input type="text" class="form-control custom-field-input" name="porpose"
                                    value="{{ old('porpose', $visaTypeEdit->porpose ?? '') }}" placeholder="أدخل الغرض"
                                    required>
                            </div>
                            <div class="col-md-6 form-group mb-4">
                                <label class="custom-field-label">تاريخ إصدار التأشيرة</label>
                                <input type="date" class="form-control custom-field-input" name="issuing_visa"
                                    value="{{ old('issuing_visa', $visaTypeEdit->issuing_visa ?? '') }}" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg w-100 shadow-sm main-btn">
                            <i class="fas fa-check-circle ml-2"></i> حفظ التعديلات
                        </button>
                    </form>


                    <style>
                        /* --- التصميم الموحد والحل لمشكلة اللون الأسود --- */

                        .visa-card-container {
                            background-color: #ffffff !important;
                            border-radius: 15px;
                            border: 1px solid #edf2f7;
                        }

                        .card-title-text {
                            color: #2c3e50 !important;
                            /* لون هيدر الصفحة الموحد */
                            font-weight: 700 !important;
                        }

                        .border-bottom-custom {
                            border-bottom: 2px solid #f4f7f6;
                        }

                        .custom-label {
                            color: #000 !important;
                            /* لون رمادي غامق وواضح جداً في اللايت مود */
                            font-weight: 600;
                            font-size: 0.92rem;
                            margin-bottom: 8px;
                            display: block;
                        }

                        .custom-input {
                            background-color: #ffffff !important;
                            border: 1px solid #dce1e7 !important;
                            color: #2d3436 !important;
                            /* لون النص داخل المدخل */
                            border-radius: 8px !important;
                            height: 45px !important;
                        }

                        .badge-soft-success {
                            background-color: rgba(39, 174, 96, 0.1);
                            color: #27ae60;
                            font-weight: 600;
                        }

                        /* --- دعم الدارك مود (بناءً على تفضيلات النظام) --- */
                        @media (prefers-color-scheme: dark) {
                            .visa-card-container {}

                            .card-title-text {
                                color: #ffffff !important;
                            }

                            .custom-label {
                                color: #000 !important;
                            }

                            .custom-input {
                                /* background-color: #2b2b40 !important; */
                                border-color: #3f3f5f !important;
                                color: #000 !important;
                            }

                            .border-bottom-custom {
                                border-bottom-color: #2b2b40;
                            }

                            input[type="date"]::-webkit-calendar-picker-indicator {
                                filter: invert(1);
                            }
                        }

                        .main-btn {
                            background-color: #27ae60 !important;
                            /* تطابق مع accent-color */
                            border: none;
                            font-weight: bold;
                            transition: all 0.3s ease;
                        }

                        .main-btn:hover {
                            background-color: #219150 !important;
                            transform: translateY(-2px);
                            box-shadow: 0 4px 12px rgba(39, 174, 96, 0.2);
                        }
                    </style>
                </div>
            @endif
        </div>

        <div class="col-md-12">
            <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn visa-list-card">
                <h4 class="mb-4 list-title">
                    <i class="fas fa-list-ul ml-2"></i> قائمة التأشيرات
                </h4>

                <div class="table-responsive">
                    <table class="table custom-table text-center id="delegatesTable">
                        <thead>
                            <tr>
                                <th>كود التأشيرة</th>
                                <th>الاسم</th>
                                <th>نوع التاشيرة</th>
                                <th>رقم السجل</th>
                                <th>رقم الصادر</th>
                                <th>الغرض</th>
                                <th>أجمالي العدد</th>
                                <th>الكفيل</th>
                                <th>القنصلية</th>
                                <th>عدد المهن</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visa_types as $visa_type)
                                <tr>
                                    <td class="id-column">#{{ $visa_type->id }}</td>
                                    <td class="name-column">{{ $visa_type->name }}</td>
                                    <td>{{ $visa_type->visa_peroid }}</td>
                                    <td><span class="reg-number">{{ $visa_type->registration_number }}</span></td>
                                    <td>{{ $visa_type->outgoing_number }}</td>
                                    <td>{{ $visa_type->porpose }}</td>
                                    <td>
                                        <span class="badge-count-custom">
                                            {{ $visa_type->count }} عميل
                                        </span>
                                    </td>
                                    <td>{{ $visa_type->sponser->name }}</td>
                                    <td>{{ $visa_type->embassy->title }}</td>
                                    <td>
                                        <span class="badge-profession-custom">
                                            {{ count($visa_type->visa_professions) }} مهن
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <a href="{{ route('visa-type.index', $visa_type->id) }}"
                                                class="btn-edit-action" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <div class="dropdown">
                                                <button class="btn-more-action dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                                    <li>
                                                        <a data-embassy="{{ $visa_type->embassy->title }}"
                                                            data-outgoing_number="{{ $visa_type->outgoing_number }}"
                                                            data-registration_number="{{ $visa_type->registration_number }}"
                                                            data-visa="{{ $visa_type->id }}"
                                                            class="dropdown-item text-success profession-outomation"
                                                            id="profession">
                                                            <i class="fas fa-sync-alt ml-2"></i> جلب المهن
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-primary"
                                                            href="{{ route('visa-profession.index', $visa_type->id) }}">
                                                            <i class="fas fa-briefcase ml-2"></i> عرض المهن
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <style>
                /* --- الأساسيات (اللايت مود - أسود صريح) --- */
                .visa-list-card {
                    background-color: #ffffff !important;
                    border-radius: 12px;
                }

                .table-responsive {
                    overflow-x: inherit !important;
                }

                .list-title {
                    color: #000000 !important;
                    /* أسود صريح */
                    font-weight: 800 !important;
                    border-right: 5px solid #28a745;
                    padding-right: 15px;
                }

                .custom-table {
                    width: 100%;
                    border-collapse: collapse;
                }

                /* الهيدر دائماً داكن ليعطي فخامة */
                .custom-table thead th {
                    background-color: #1e1e2d !important;
                    color: #ffffff !important;
                    padding: 15px;
                    font-weight: 600;
                    border: none;
                }

                .custom-table tbody tr {
                    border-bottom: 1px solid #ebebeb;
                    background-color: #ffffff !important;
                }

                .custom-table td {
                    color: #000000 !important;
                    /* نصوص الجداول سوداء تماماً في اللايت مود */
                    padding: 14px 10px !important;
                    vertical-align: middle;
                    font-weight: 500;
                }

                /* تمييز الأعمدة */
                .id-column {
                    color: #28a745 !important;
                    font-weight: bold !important;
                }

                .reg-number {
                    background: #f1f2f6;
                    padding: 4px 8px;
                    border-radius: 5px;
                    color: #000;
                    font-family: monospace;
                }

                /* البادجات */
                .badge-count-custom {
                    background: #e8f5e9;
                    color: #2e7d32;
                    padding: 5px 10px;
                    border-radius: 6px;
                    font-weight: 700;
                }

                .badge-profession-custom {
                    background: #e3f2fd;
                    color: #1565c0;
                    padding: 5px 10px;
                    border-radius: 6px;
                    font-weight: 700;
                }

                /* أزرار الإجراءات */
                .btn-edit-action {
                    color: #28a745;
                    background: #e8f5e9;
                    border: none;
                    padding: 6px 10px;
                    border-radius: 6px;
                    transition: 0.3s;
                }

                .btn-more-action {
                    color: #5f6368;
                    background: #f1f3f4;
                    border: none;
                    padding: 6px 10px;
                    border-radius: 6px;
                }

                /* --- الدارك مود (أبيض صريح) --- */
                @media (prefers-color-scheme: dark) {
                    .visa-list-card {
                        background-color: #1a1a27 !important;
                    }

                    .list-title {
                        color: #ffffff !important;
                    }

                    .custom-table tbody tr {
                        background-color: #212130 !important;
                        border-bottom: 1px solid #2b2b40;
                    }

                    .custom-table td {
                        color: #ffffff !important;
                        /* نصوص الجداول بيضاء تماماً في الدارك مود */
                    }

                    .reg-number {
                        background: #2b2b40;
                        color: #ffffff;
                    }

                    .badge-count-custom {
                        background: rgba(40, 167, 69, 0.2);
                        color: #81c784;
                    }

                    .badge-profession-custom {
                        background: rgba(33, 150, 243, 0.2);
                        color: #90caf9;
                    }

                    .btn-more-action {
                        background: #2b2b40;
                        color: #b5b5c3;
                    }

                    .dropdown-menu {
                        background: #1e1e2d;
                        border: 1px solid #323248;
                    }

                    .dropdown-item {
                        color: #b5b5c3;
                    }
                }
            </style>
        </div>

    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    This is a Bootstrap modal.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <style>
        :root {
            --primary-color: #2c3e50;
            --accent-color: #27ae60;
            --bg-light: #f4f7f6;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Cairo', sans-serif;
        }

        /* ✅ تحسين الكروت */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        .card-header-custom {
            background: var(--primary-color);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 15px 20px;
        }

        /* ✅ تحسين المدخلات */
        .form-control,
        .select2-container .select2-selection--single {
            border-radius: 8px !important;
            border: 1px solid #dce1e7 !important;
            height: 45px !important;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--accent-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(39, 174, 96, 0.15);
        }

        /* ✅ تحسين الجدول */
        .table {
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .table thead th {
            background-color: var(--primary-color) !important;
            color: white !important;
            border: none;
            padding: 15px;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        .table tbody tr {
            background-color: white !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s;
        }

        /* .table tbody tr:hover {
                                    transform: scale(1.005);
                                    background-color: #f9f9f9 !important;
                                } */

        .table td {
            vertical-align: middle !important;
            border: none;
            padding: 15px !important;
        }

        /* ✅ البادجات (Badges) */
        .badge-custom {
            padding: 6px 12px;
            border-radius: 50px;
            font-weight: 500;
        }

        /* ✅ الأزرار */
        .btn-action {
            width: 35px;
            height: 35px;
            padding: 0;
            line-height: 35px;
            border-radius: 8px;
            margin: 0 2px;
        }

        /* تحسين البحث */
        .search-section {
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
        }
    </style>
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        $(document).on('DOMContentLoaded', function() {
            $('.select2').select2();
        });
        // ✅ كود البحث داخل الجدول
        function searchTable() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let table = document.getElementById("delegatesTable");
            let rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) {
                let rowData = rows[i].getElementsByTagName("td");
                let found = false;
                for (let j = 0; j < rowData.length - 1; j++) {
                    if (rowData[j].textContent.toLowerCase().includes(input)) {
                        found = true;
                        break;
                    }
                }
                rows[i].style.display = found ? "" : "none";
            }
        }

        document.querySelectorAll('.profession-outomation').forEach(function(element) {
            element.addEventListener('click', function(e) {
                const element = e.currentTarget;

                const visaType = {
                    VisaNumber: element.dataset.outgoing_number,
                    Embassy: element.dataset.embassy,
                    SponserID: element.dataset.registration_number
                };


                // إذا كنت تريد إرسال الطلب لجلب المهن مثلاً:
                fetch('http://localhost:3000/getVisaInfo', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(visaType)
                    })
                    .then(response => response.json())
                    .then(data => {
                        data.visa_id = element.dataset.visa;

                        fetch("{{ route('profession') }}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "Accept": "application/json",
                                    "X-CSRF-TOKEN": document.querySelector(
                                            'meta[name="csrf-token"]')
                                        .getAttribute('content')
                                },
                                body: JSON.stringify(data)
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('خطأ في الاستجابة من السيرفر');
                                }
                                return response.json();
                            })
                            .then(data => {
                                Swal.fire({
                                    title: "نجحت العملية!",
                                    icon: "success"
                                });

                                setTimeout(() => {
                                    location.reload();
                                }, 3000);
                            })
                            .catch(error => {
                                console.error("حدث خطأ أثناء جلب المهن:", error);
                            });

                    })
                    .catch(error => {
                        console.error('حدث خطأ أثناء جلب المهن:', error);
                    });
            });
        })

        // document.getElementById('profession').addEventListener('click', function(e) {
        //     const element = e.currentTarget;

        //     const visaType = {
        //         VisaNumber: element.dataset.outgoing_number,
        //         Embassy: element.dataset.embassy,
        //         SponserID: element.dataset.registration_number
        //     };


        //     // إذا كنت تريد إرسال الطلب لجلب المهن مثلاً:
        //     fetch('http://localhost:3000/getVisaInfo', {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/json'
        //             },
        //             body: JSON.stringify(visaType)
        //         })
        //         .then(response => response.json())
        //         .then(data => {
        //             data.visa_id = element.dataset.visa;

        //             fetch("{{ route('profession') }}", {
        //                     method: "POST",
        //                     headers: {
        //                         "Content-Type": "application/json",
        //                         "Accept": "application/json",
        //                         "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
        //                             .getAttribute('content')
        //                     },
        //                     body: JSON.stringify(data)
        //                 })
        //                 .then(response => {
        //                     if (!response.ok) {
        //                         throw new Error('خطأ في الاستجابة من السيرفر');
        //                     }
        //                     return response.json();
        //                 })
        //                 .then(data => {
        //                     Swal.fire({
        //                         title: "نجحت العملية!",
        //                         icon: "success"
        //                     });

        //                     setTimeout(() => {
        //                         location.reload();
        //                     }, 3000);
        //                 })
        //                 .catch(error => {
        //                     console.error("حدث خطأ أثناء جلب المهن:", error);
        //                 });

        //         })
        //         .catch(error => {
        //             console.error('حدث خطأ أثناء جلب المهن:', error);
        //         });
        // });
    </script>
@stop
