@extends('adminlte::page')

@section('title', 'إدارة المهام')

@section('content')
    <div class="container-fluid pt-4">

        <div class="row mb-4 px-2 justify-content-center">
            <div class="col-md-9 d-flex justify-content-between align-items-center modern-header-card p-4 shadow-sm">
                <div>
                    <h4 class="mb-0 font-weight-bold header-title">🎯 منصة إسناد المهام</h4>
                    <p class="mb-0 small user-subtitle text-muted">تابع ونسق العمليات اليومية مع فريقك</p>
                </div>
                <button class="btn btn-premium-add rounded-pill px-4 shadow-sm" data-toggle="modal"
                    data-target="#exampleModal">
                    <i class="fas fa-plus-circle ml-2"></i> إسناد مهمة جديدة
                </button>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form action="{{ route('user-tasks.create') }}" method="POST" class="modal-content border-0 shadow-lg"
                    style="border-radius: 20px;">
                    <div class="modal-header bg-navy text-white border-0 py-4" style="border-radius: 20px 20px 0 0;">
                        <h5 class="modal-title fw-bold"><i class="fas fa-tasks ml-2"></i> تفاصيل المهمة الجديدة</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body p-4">
                        @csrf
                        <div class="form-group mb-4">
                            <label class="font-weight-bold small text-muted">👤 الموظف المسؤول</label>
                            <select class="form-control custom-select-modern" name="receiving_user_id" required>
                                <option value="">اختر من القائمة...</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold small text-muted">📝 ماذا يجب أن يفعل؟</label>
                            <textarea class="form-control custom-input-modern" name="description" rows="4"
                                placeholder="اكتب وصف المهمة بدقة..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4">
                        <button type="submit" class="btn btn-navy w-100 py-3 rounded-pill shadow">إرسال المهمة
                            الآن</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-9">
                <div id="taskList" class="task-grid">
                    @forelse ($tasks as $task)
                        <div class="task-card shadow-sm mb-3 {{ $task->status == 'done' ? 'status-done' : 'status-new' }}">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex align-items-center">
                                        <div class="sender-avatar ml-3">
                                            {{ mb_substr($task->sender->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 font-weight-bold text-navy">بواسطة: {{ $task->sender->name }}
                                            </h6>
                                            <small class="text-muted"><i class="far fa-clock ml-1"></i>
                                                {{ $task->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <div class="task-badge">
                                        @if ($task->status == 'new')
                                            <span class="badge badge-soft-warning px-3 py-2">⏳ قيد الانتظار</span>
                                        @else
                                            <span class="badge badge-soft-success px-3 py-2">✅ تم الإنجاز</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="task-content my-3">
                                    <p class="mb-0">{{ $task->description }}</p>
                                </div>

                                <div
                                    class="task-footer d-flex justify-content-between align-items-center pt-3 border-top mt-3">
                                    <span class="small text-muted"><i class="far fa-calendar-alt ml-1"></i> التاريخ:
                                        {{ $task->created_at->format('Y-m-d') }}</span>

                                    @if ($task->status == 'new')
                                        <a href="{{ route('user-tasks.done', $task->id) }}"
                                            class="btn btn-sm btn-success-modern rounded-pill px-4">
                                            <i class="fas fa-check-circle ml-1"></i> تحديد كمكتملة
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-clipboard-list fa-3x text-light mb-3"></i>
                            <h5 class="text-muted">لا توجد مهام حالية</h5>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        :root {
            --primary-navy: #1a237e;
            --accent-blue: #3f51b5;
            --soft-gray: #f8fafc;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f4f7fa;
        }

        /* الهيدر */
        .modern-header-card {
            background-color: #ffffff;
            border-right: 6px solid var(--accent-blue);
            border-radius: 20px;
        }

        /* أزرار بريميوم */
        .btn-premium-add {
            background: linear-gradient(135deg, #1a237e 0%, #3f51b5 100%);
            color: white !important;
            font-weight: 700;
            border: none;
            transition: 0.3s;
        }

        .btn-premium-add:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 15px rgba(26, 35, 126, 0.2);
        }

        .btn-navy {
            background-color: var(--primary-navy);
            color: white;
            font-weight: 700;
        }

        /* كارد المهمة */
        .task-card {
            background: #fff;
            border: none;
            border-radius: 18px;
            transition: 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .task-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05) !important;
        }

        /* الحواف اللونية للمهمة */
        .status-new {
            border-right: 6px solid #ffc107;
        }

        .status-done {
            border-right: 6px solid #28a745;
            opacity: 0.85;
        }

        .status-done .task-content p {
            text-decoration: none;
            color: #6c757d;
        }

        /* أيقونة المرسل */
        .sender-avatar {
            width: 45px;
            height: 45px;
            background: #e8eaf6;
            color: var(--primary-navy);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 1.2rem;
        }

        /* البادجات */
        .badge-soft-warning {
            background: rgba(255, 193, 7, 0.15);
            color: #856404;
            font-weight: 700;
        }

        .badge-soft-success {
            background: rgba(40, 167, 69, 0.15);
            color: #155724;
            font-weight: 700;
        }

        /* مودال وإدخال */
        .custom-input-modern,
        .custom-select-modern {
            border-radius: 12px !important;
            padding: 12px !important;
            border: 2px solid #edf2f7 !important;
        }

        .bg-navy {
            background-color: var(--primary-navy) !important;
        }

        /* الدارك مود */
        .dark-mode .modern-header-card,
        .dark-mode .task-card {
            background-color: #1c2437 !important;
            color: #fff;
        }

        .dark-mode .text-navy {
            color: #8c9eff !important;
        }

        .dark-mode .task-content p {
            color: #cbd5e1 !important;
        }

        .dark-mode .border-top {
            border-color: #334155 !important;
        }

        .dark-mode .sender-avatar {
            background: #242f48;
            color: #fff;
        }
    </style>
@stop
