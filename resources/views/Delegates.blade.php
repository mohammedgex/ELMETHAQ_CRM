@extends('adminlte::page')

@section('title', 'المناديب')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;">المناديب</h1>
@stop

@section('content')
<div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn" style="border-radius: 15px;">
    <h4 class="mb-3 text-success font-weight-bold">إضافة مندوب جديد</h4>
   <form action="{{ route('delegates.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-4 form-group">
            <label class="font-weight-bold">اسم المندوب</label>
            <input type="text" class="form-control" name="name" placeholder="أدخل اسم المندوب" required>
        </div>
        <div class="col-md-4 form-group">
            <label class="font-weight-bold">رقم الهاتف</label>
            <input type="text" class="form-control" name="phone" placeholder="أدخل رقم الهاتف" required>
        </div>
        <div class="col-md-4 form-group">
            <label class="font-weight-bold">الرقم القومي</label>
            <input type="text" class="form-control" name="card_id" placeholder="أدخل الرقم القومي" required>
        </div>
    </div>
    <button type="submit" class="btn btn-success mt-3 px-4 shadow-sm">إضافة مندوب</button>
</form>

    <hr>

    <h4 class="mb-3 text-success font-weight-bold">قائمة المناديب</h4>
    <div class="table-responsive">
        <table class="table table-hover text-center animate__animated animate__fadeInUp">
            <thead class="text-white" style="background: linear-gradient(45deg, #28a745, #218838); border-radius: 10px;">
                <tr>
                    <th>#</th>
                    <th>اسم المندوب</th>
                    <th>رقم الهاتف</th>
                    <th>الرقم القومي</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
           <tbody>
    @foreach($delegates as $index => $delegate)
    <tr class="table-light">
        <td>{{ $index + 1 }}</td>
        <td>{{ $delegate->name }}</td>
        <td>{{ $delegate->phone }}</td>
                <td>{{ $delegate->card_id }}</td>

                <td>
            <button class="btn btn-sm btn-outline-success shadow-sm"><i class="fas fa-edit"></i> تعديل</button>
            <button class="btn btn-sm btn-outline-danger shadow-sm"><i class="fas fa-trash"></i> حذف</button>
            <button class="btn btn-sm btn-outline-primary shadow-sm"><i class="fas fa-users"></i> عرض العملاء</button>
        </td>
    </tr>
    @endforeach
</tbody>
        </table>
    </div>
</div>


@stop

@section('css')
<style>
/* تحسين إدخال البيانات */
.form-control {
    border-radius: 10px;
    padding: 12px;
    height: 50px;
    border: 1px solid #ced4da;
    transition: all 0.3s ease-in-out;
}
.form-control:focus {
    border-color: #28a745;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
}

/* تحسين الجدول */
.table-hover tbody tr:hover {
    background-color: #e9ecef;
    transition: 0.3s ease-in-out;
}

/* تحسين الأزرار */
.btn {
    transition: all 0.3s ease-in-out;
    font-weight: bold;
    
}
.btn:hover {
    transform: translateY(-2px);
}

/* تحسين البطاقة */
.card {
    border-radius: 12px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}


</style>
@stop

@section('js')

@stop