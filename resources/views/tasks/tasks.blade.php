@extends('adminlte::page')

@section('title', 'تعريف المستندات')

@section('content_header')
<h3>المهام </h3>
@stop

@section('content')
      <div class="container w-75 bg-white p-4 shadow-lg rounded">
        <h2 class="text-center mb-4 border-bottom pb-3"> قائمة المهام</h2>
        
        <button class="btn btn-primary w-100 mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal"> اسناد مهمة</button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">اضافة مهمة</h5>
                        <button type="button" class="" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times-circle text-danger"></i></button>
                    </div>
                    <div class="modal-body">
                        <label class="font-weight-bold"> الموظف </label>
                        <select class="form-control fw-bold">
                                <option value="">اختر الموظف</option>
                                <option value="A">ندي سلامة</option>
                                <option value="B">بسنت احمد</option>
                                <option value="C"> احمد بشير </option>
                        </select>
                        <label class="font-weight-bold"> وصف المهمة </label>
                        <div class="col-md-12 input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-edit" style="color:#7c6232;"></i></span>
                                </div>
                                <input type="text" class="form-control" name="title" placeholder="أدخل وصف المهمة" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اسناد المهمة</button>
                        </div>
                </div>
            </div>
        </div>

        
        <div id="taskList" class="d-flex flex-column gap-3">
            <div class="task-item p-4 bg-success bg-opacity-25 border border-success rounded d-flex justify-content-between align-items-center my-2">
                <div class="w-75">
                    <h4 class="mb-1 text-black border-bottom pb-2" style="color:black;font-weight:700;font-size:28px;"> مهمة للموظف : "محمد سيد"</h4>
                    <p class="mb-2" style="font-weight:300;font-size:14px;"> مراجعة تقرير  الشهريال شهري الشهريالشه ريالشهري الشهري الشهري الأداء الشهري.</p>
                    <small class="text-white">📅  2025-03-15</small>  
                </div>
                <button class="btn mt-1 px-1 shadow-sm text-success" style="background-color: #ffffff;font-weight:700" onclick="markComplete(this)"> <i class="fas fa-check"></i> مكتملة</button>
            </div>
            
            <div class="task-item p-4 bg-warning bg-opacity-25 border border-warning rounded d-flex justify-content-between align-items-center">
                <div class="w-75">
                    <h4 class="mb-1 text-black fw-bolder"> مهمة للموظف : "محمد سيد"</h4>
                    <p class="mb-2 text-white"> إعداد عرض تقديمي لاجتماع الفريق.</p>
                    <small class="text-white">📅 2025-03-14</small>
                </div>
                <div>
                    <button class="btn mt-1 px-2 shadow-sm text-success" style="background-color: green;font-weight:700"> <i class="fas fa-check text-white"></i></button>
                    <button class="btn mt-1 px-1 shadow-sm text-warning" style="background-color: #ffffff;font-weight:700" onclick="markComplete(this)"> <i class="fas fa-history"></i> جديدة</button>

                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
       .form-control {
            border-radius: 10px;
            padding: 12px;
            height: 50px;
            border: 1px solid #ced4da;
            transition: all 0.3s ease-in-out;
        }

        .form-control:focus {
            border-color: #997a44;
            /* box-shadow: 0 0 8px rgba(153, 122, 68, 0.3); */
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
       
    </script>
@stop
