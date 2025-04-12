@extends('adminlte::page')

@section('title', 'لوحة التحكم')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;">المستخدمين</h1>
@stop

@section('content')
<div class="table-wrapper">
    <div class="table-title">
        <div class="row">
            <div class="col-sm-6 text-right"><h2>إدارة <b>النطاقات</b></h2></div>
            <div class="col-sm-6 text-left">
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-info active">
                        <input type="radio" name="status" value="all" checked="checked"> الكل
                    </label>
                    <label class="btn btn-success">
                        <input type="radio" name="status" value="active"> نشط
                    </label>
                    <label class="btn btn-warning">
                        <input type="radio" name="status" value="inactive"> غير نشط
                    </label>
                    <label class="btn btn-danger">
                        <input type="radio" name="status" value="expired"> منتهي الصلاحية
                    </label>                          
                </div>
            </div>
        </div>
    </div>
    
    <!-- MRZ Input Form -->
    <div class="form-group">
        <label for="mrz_input">أدخل بيانات MRZ:</label>
        <textarea id="mrz_input" class="form-control" rows="2" placeholder="ضع هنا منطقة القراءة الآلية من جواز السفر"></textarea>
    </div>
    <button class="btn btn-primary" onclick="extractMRZData()">استخراج البيانات</button>
    
    <!-- Extracted Passport Data -->
    <div class="form-group">
        <label for="passport_number">رقم الجواز:</label>
        <input type="text" id="passport_number" class="form-control" readonly>
    </div>
    <div class="form-group">
        <label for="full_name">الاسم الكامل:</label>
        <input type="text" id="full_name" class="form-control" readonly>
    </div>
    <div class="form-group">
        <label for="nationality">الجنسية:</label>
        <input type="text" id="nationality" class="form-control" readonly>
    </div>
    <div class="form-group">
        <label for="dob">تاريخ الميلاد:</label>
        <input type="text" id="dob" class="form-control" readonly>
    </div>
    <div class="form-group">
        <label for="expiry_date">تاريخ انتهاء الصلاحية:</label>
        <input type="text" id="expiry_date" class="form-control" readonly>
    </div>
    
    <table class="table table-striped table-hover text-right">
        <thead>
            <tr>
                <th style="text-align:center">#</th>
                <th style="text-align:center">النطاق</th>
                <th style="text-align:center">تاريخ الإنشاء</th>
                <th style="text-align:center">الحالة</th>
                <th style="text-align:center">موقع الخادم</th>
                <th style="text-align:center">إجراء</th>
            </tr>
        </thead>
        <tbody>
            <tr data-status="active">
                <td>1</td>
                <td><a href="#">loremvallis.com</a></td>
                <td>04/10/2013</td>
                <td><span class="badge badge-success">نشط</span></td>
                <td>بوينس آيرس</td>
                <td><a href="#" class="btn btn-sm manage">إدارة</a></td>
            </tr>
        </tbody>
    </table>
</div>     


@stop

@section('css')
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style>
    body {
		font-family: 'Tajawal';
	}
	.table-responsive {
        margin: 30px 0;
    }
	.table-wrapper {
		min-width: 1000px;
        background: #fff;
        padding: 20px 25px;
		border-radius: 3px;
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
	.table-title {        
		padding-bottom: 15px;
		background: #435d7d;
		color: #fff;
		padding: 16px 30px;
		margin: -20px -25px 10px;
		border-radius: 3px 3px 0 0;
    }
    .table-title h2 {
		margin: 5px 0 0;
		font-size: 24px;
	}
	.table-title .btn-group {
		float: right;
	}
	.table-title .btn {
		color: #fff;
		float: right;
		font-size: 13px;
		border: none;
		min-width: 50px;
		border-radius: 2px;
		border: none;
		outline: none !important;
		margin-left: 10px;
	}
	.table-title .btn i {
		float: left;
		font-size: 21px;
		margin-right: 5px;
	}
	.table-title .btn span {
		float: left;
		margin-top: 2px;
	}
    table.table tr th, table.table tr td {
        border-color: #e9e9e9;
		padding: 12px 15px;
		vertical-align: middle;
    }
	table.table tr th:first-child {
		width: 60px;
	}
	table.table tr th:last-child {
		width: 100px;
	}
    table.table-striped tbody tr:nth-of-type(odd) {
    	background-color: #fcfcfc;
	}
	table.table-striped.table-hover tbody tr:hover {
		background: #f5f5f5;
	}
    table.table th i {
        font-size: 13px;
        margin: 0 5px;
        cursor: pointer;
    }	
    table.table td:last-child i {
		opacity: 0.9;
		font-size: 22px;
        margin: 0 5px;
    }
	table.table td a {
		font-weight: bold;
		color: #566787;
		display: inline-block;
		text-decoration: none;
		outline: none !important;
	}
	table.table td a:hover {
		color: #2196F3;
	}
	table.table td a.edit {
        color: #FFC107;
    }
    table.table td a.delete {
        color: #F44336;
    }
    table.table td i {
        font-size: 19px;
    }
	table.table .avatar {
		border-radius: 50%;
		vertical-align: middle;
		margin-right: 10px;
	}
    .pagination {
        float: right;
        margin: 0 0 5px;
    }
    .pagination li a {
        border: none;
        font-size: 13px;
        min-width: 30px;
        min-height: 30px;
        color: #999;
        margin: 0 2px;
        line-height: 30px;
        border-radius: 2px !important;
        text-align: center;
        padding: 0 6px;
    }
    .pagination li a:hover {
        color: #666;
    }	
    .pagination li.active a, .pagination li.active a.page-link {
        background: #03A9F4;
    }
    .pagination li.active a:hover {        
        background: #0397d6;
    }
	.pagination li.disabled i {
        color: #ccc;
    }
    .pagination li i {
        font-size: 16px;
        padding-top: 6px
    }
    .hint-text {
        float: left;
        margin-top: 10px;
        font-size: 13px;
    }    
	/* Custom checkbox */
	.custom-checkbox {
		position: relative;
	}
	.custom-checkbox input[type="checkbox"] {    
		opacity: 0;
		position: absolute;
		margin: 5px 0 0 3px;
		z-index: 9;
	}
	.custom-checkbox label:before{
		width: 18px;
		height: 18px;
	}
	.custom-checkbox label:before {
		content: '';
		margin-right: 10px;
		display: inline-block;
		vertical-align: text-top;
		background: white;
		border: 1px solid #bbb;
		border-radius: 2px;
		box-sizing: border-box;
		z-index: 2;
	}
	.custom-checkbox input[type="checkbox"]:checked + label:after {
		content: '';
		position: absolute;
		left: 6px;
		top: 3px;
		width: 6px;
		height: 11px;
		border: solid #000;
		border-width: 0 3px 3px 0;
		transform: inherit;
		z-index: 3;
		transform: rotateZ(45deg);
	}
	.custom-checkbox input[type="checkbox"]:checked + label:before {
		border-color: #03A9F4;
		background: #03A9F4;
	}
	.custom-checkbox input[type="checkbox"]:checked + label:after {
		border-color: #fff;
	}
	.custom-checkbox input[type="checkbox"]:disabled + label:before {
		color: #b8b8b8;
		cursor: auto;
		box-shadow: none;
		background: #ddd;
	}
	/* Modal styles */
	.modal .modal-dialog {
		max-width: 400px;
	}
	.modal .modal-header, .modal .modal-body, .modal .modal-footer {
		padding: 20px 30px;
	}
	.modal .modal-content {
		border-radius: 3px;
	}
	.modal .modal-footer {
		background: #ecf0f1;
		border-radius: 0 0 3px 3px;
	}
    .modal .modal-title {
        display: inline-block;
    }
	.modal .form-control {
		border-radius: 2px;
		box-shadow: none;
		border-color: #dddddd;
	}
	.modal textarea.form-control {
		resize: vertical;
	}
	.modal .btn {
		border-radius: 2px;
		min-width: 100px;
	}	
	.modal form label {
		font-weight: normal;
	}	
</style>
@stop

@section(section: 'js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
	// Activate tooltip
	$('[data-toggle="tooltip"]').tooltip();
	
	// Select/Deselect checkboxes
	var checkbox = $('table tbody input[type="checkbox"]');
	$("#selectAll").click(function(){
		if(this.checked){
			checkbox.each(function(){
				this.checked = true;                        
			});
		} else{
			checkbox.each(function(){
				this.checked = false;                        
			});
		} 
	});
	checkbox.click(function(){
		if(!this.checked){
			$("#selectAll").prop("checked", false);
		}
	});
});
</script>
@stop