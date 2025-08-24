@extends('adminlte::page')

@section('title', 'قائمة المهام')

@section('content_header')
    <h3 class="fw-bold text-center text-primary">📋 إدارة المهام</h3>
@stop

@section('content')
    <div class="container w-75 bg-light dark:bg-dark p-4 shadow-lg rounded-4">
        <h2 class="text-center mb-4 border-bottom pb-3 fw-bold text-dark dark:text-light">قائمة المهام</h2>

        <!-- زر إضافة مهمة -->
        <button class="btn btn-primary w-100 mb-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
            + إسناد مهمة
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('user-tasks.create') }}" method="POST" class="modal-content rounded-4 shadow-lg">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold">➕ إضافة مهمة</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <label class="fw-bold mb-2">👤 الموظف</label>
                        <select class="form-control fw-bold mb-3" name="receiving_user_id" required>
                            <option value="">اختر الموظف</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>

                        <label class="fw-bold mb-2">📝 وصف المهمة</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-primary text-white"><i class="fas fa-edit"></i></span>
                            <textarea class="form-control" name="description" placeholder="أدخل وصف المهمة" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-primary">✔ إسناد المهمة</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- قائمة المهام -->
        <div id="taskList" class="d-flex flex-column gap-3">
            @foreach ($tasks as $task)
                <div
                    class="card shadow-sm border-0 rounded-4 
                    {{ $task->status == 'done' ? 'task-done' : 'task-new' }}">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="w-75">
                            <h5 class="fw-bold mb-2 text-dark dark:text-light">
                                👤 من: <span class="text-primary">{{ $task->sender->name }}</span>
                            </h5>
                            <p class="mb-2 text-muted dark:text-gray-300">{{ $task->description }}</p>
                            <small class="text-secondary">📅 {{ $task->created_at->format('Y-m-d') }}</small>
                        </div>

                        <div>
                            @if ($task->status == 'new')
                                <a href="{{ route('user-tasks.done', $task->id) }}">
                                    <button class="btn btn-success btn-sm shadow-sm me-2">✔ إتمام</button>
                                </a>
                                <button class="btn btn-outline-warning btn-sm shadow-sm">⏳ جديدة</button>
                            @elseif ($task->status == 'done')
                                <button class="btn btn-outline-success btn-sm shadow-sm">✅ مكتملة</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@stop

@section('css')
    <style>
        /* Light & Dark Mode */
        body {
            background-color: #f8f9fa;
        }

        @media (prefers-color-scheme: dark) {
            body {
                background-color: #121212 !important;
                color: #eee;
            }

            .dark\:bg-dark {
                background-color: #1e1e1e !important;
            }

            .dark\:text-light {
                color: #f1f1f1 !important;
            }

            .dark\:text-gray-300 {
                color: #ccc !important;
            }

            .card {
                background-color: #2a2a2a !important;
                border: 1px solid #444 !important;
            }
        }

        /* حالة المهام */
        .task-new {
            background-color: #fff9e6;
            /* أصفر فاتح */
            border-left: 6px solid #ffc107;
        }

        .task-done {
            background-color: #e6f7ed;
            /* أخضر فاتح */
            border-left: 6px solid #28a745;
        }

        /* أزرار */
        .btn {
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.2s ease-in-out;
        }

        .btn:hover {
            transform: translateY(-2px);
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
@stop
