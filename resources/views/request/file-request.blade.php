@extends('adminlte::page')

@section('title', 'طلبات الملفات')

@section('content_header')
    <h1>طلبات الملفات</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>صورة الملف</th>
                        <th>اسم العميل</th>
                        <th>اسم المستند</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody id="attachmentTable">
                    @foreach ($files as $file)
                        <tr>
                            {{-- الترقيم --}}
                            <td>{{ $loop->iteration }}</td>

                            {{-- صورة الملف --}}
                            <td>
                                @php
                                    $extension = pathinfo($file->file, PATHINFO_EXTENSION);
                                @endphp
                                @if (!empty($extension))
                                    <a href="{{ asset('storage/' . $file->file) }}" target="_blank">
                                        @if (strtolower($extension) === 'pdf')
                                            <img src="https://cdn-icons-png.freepik.com/512/4726/4726010.png" alt="PDF"
                                                class="img-fluid rounded" style="width: 40px; height: 40px;">
                                        @else
                                            <img src="{{ asset('storage/' . $file->file) }}" alt="File"
                                                class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                        @endif
                                    </a>
                                @elseif ($file->file != null)
                                    <a href="{{ $file->file }}" target="_blank">
                                        <img src="https://png.pngtree.com/png-vector/20200622/ourmid/pngtree-hospital-icon-vector-flat-design-png-image_2261694.jpg"
                                            alt="File" class="img-fluid rounded" style="width: 40px; height: 40px;">
                                    </a>
                                @else
                                    <span class="text-muted">لا يوجد</span>
                                @endif
                            </td>

                            {{-- اسم العميل --}}
                            <td>{{ $file->customer->name_ar ?? '—' }}</td>

                            {{-- اسم المستند --}}
                            <td class="fw-bold">{{ $file->document_type }}</td>

                            {{-- الحالة --}}
                            <td>
                                @if ($file->order_status === 'approved')
                                    <span class="badge bg-success">موافق عليه</span>
                                @elseif($file->order_status === 'rejected')
                                    <span class="badge bg-danger">مرفوض</span>
                                @else
                                    <span class="badge bg-warning text-dark">قيد الانتظار</span>
                                @endif
                            </td>

                            {{-- الإجراءات --}}
                            <td>
                                <div class="btn-group" role="group">
                                    @if ($file->order_status === 'panding')
                                        <a href="{{ route('document-type.accept', $file->id) }}"
                                            class="btn btn-success btn-sm" title="موافقة">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <a href="{{ route('document-type.reject', $file->id) }}"
                                            class="btn btn-danger btn-sm" title="رفض">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/' . $file->file) }}" download
                                            class="btn btn-success btn-sm" title="تحميل">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <a href="{{ asset('storage/' . $file->file) }}" target="_blank"
                                            class="btn btn-primary btn-sm" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        {{-- @if (method_exists($files, 'links'))
            <div class="card-footer">
                {{ $fileRequests->links() }}
            </div>
        @endif --}}
    </div>
@stop
