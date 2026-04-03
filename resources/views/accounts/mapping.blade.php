@extends('adminlte::page')

@section('title', 'معالج المطابقة الذكي')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h1 class="m-0 font-weight-bold" style="font-size:1.6rem; letter-spacing:-.3px;">
                <i class="fas fa-magic ml-2" style="color:#6c63ff;"></i>معالج المطابقة الذكي
            </h1>
            <p class="text-muted mb-0 mt-1" style="font-size:.82rem;">
                <i class="fas fa-circle ml-1" style="font-size:.45rem; color:#28a745; vertical-align:middle;"></i>
                ربط بيانات النظام بملف الإكسيل المرفوع
            </p>
        </div>
        <span class="badge badge-pill px-3 py-2 shadow-sm" id="badge-total"
            style="font-size:.82rem; background:#6c63ff; color:#fff; letter-spacing:.3px;">
            0 عميل
        </span>
    </div>
@stop

@section('content')
    <div class="container-fluid pb-5">

        {{-- ===== بطاقات الإحصائيات ===== --}}
        <div class="row mb-4">

            <div class="col-md-4 col-6 mb-3">
                <div class="stat-card stat-success p-3 rounded-lg shadow-sm d-flex align-items-center gap-3">
                    <div class="stat-icon-wrap success-icon">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <div>
                        <div class="stat-number" id="stat-matched">0</div>
                        <div class="stat-label">تمت المطابقة</div>
                        <div class="stat-progress mt-1">
                            <div class="stat-progress-bar" id="progress-matched" style="width:0%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-6 mb-3">
                <div class="stat-card stat-warning p-3 rounded-lg shadow-sm d-flex align-items-center gap-3">
                    <div class="stat-icon-wrap warning-icon">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div>
                        <div class="stat-number" id="stat-pending">0</div>
                        <div class="stat-label">بانتظار الربط</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-12 mb-3">
                <div class="stat-card stat-secondary p-3 rounded-lg shadow-sm d-flex align-items-center gap-3">
                    <div class="stat-icon-wrap secondary-icon">
                        <i class="fas fa-eye-slash"></i>
                    </div>
                    <div>
                        <div class="stat-number" id="stat-ignored">0</div>
                        <div class="stat-label">متجاهل</div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ===== بطاقة الجدول ===== --}}
        <div class="card shadow-lg rounded-lg border-0 matching-card">

            <div class="card-header d-flex align-items-center justify-content-between py-3"
                style="border-bottom: 2px solid #6c63ff20; border-radius: 12px 12px 0 0;">
                <h5 class="m-0 font-weight-bold" style="color:#6c63ff;">
                    <i class="fas fa-table ml-2"></i>جدول المطابقة
                </h5>
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted small" id="match-summary">—</span>
                </div>
            </div>

            <form action="{{ route('import.final_confirm') }}" method="POST" id="mappingForm">
                @csrf
                <input type="hidden" name="group_id" value="{{ $group_id }}">

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 matching-table" id="mapping-table">
                            <thead>
                                <tr>
                                    <th class="text-center px-3" style="width:60px">
                                        <span class="th-label">حالة</span>
                                    </th>
                                    <th style="width:35%">
                                        <span class="th-label">عميل النظام</span>
                                    </th>
                                    <th>
                                        <span class="th-label">المقابل في الإكسيل</span>
                                    </th>
                                    <th class="text-center" style="width:110px">
                                        <span class="th-label">إجراء</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customersList as $index => $item)
                                    @php
                                        $isMatched = $item['status'] === 'found' && !empty($item['excel_original']);
                                    @endphp
                                    <tr class="customer-row {{ $isMatched ? 'row-matched' : 'row-pending' }}"
                                        id="row-{{ $index }}" data-index="{{ $index }}"
                                        data-initial="{{ $item['excel_original'] ?? '' }}">

                                        {{-- مؤشر الحالة --}}
                                        <td class="text-center align-middle px-3">
                                            <span class="indicator-dot {{ $isMatched ? 'dot-matched' : 'dot-unmatched' }}"
                                                id="dot-{{ $index }}">
                                            </span>
                                        </td>

                                        {{-- اسم العميل --}}
                                        <td class="align-middle">
                                            <div class="customer-name-cell">
                                                <span class="customer-name">{{ $item['system_name'] }}</span>
                                                <small class="customer-id text-muted">#{{ $item['system_id'] }}</small>
                                            </div>
                                            <input type="hidden" name="mapping[{{ $index }}][customer_id]"
                                                value="{{ $item['system_id'] }}">
                                        </td>

                                        {{-- قائمة البحث --}}
                                        <td class="align-middle" style="overflow:visible; position:static;">
                                            <div class="custom-search-wrap" data-index="{{ $index }}">

                                                {{-- حقل البحث --}}
                                                <div class="search-field-wrap {{ $isMatched ? 'is-matched' : '' }}"
                                                    id="field-{{ $index }}">
                                                    <i class="fas fa-search search-icon"></i>
                                                    <input type="text" class="search-trigger"
                                                        id="inp-{{ $index }}" data-index="{{ $index }}"
                                                        value="{{ $item['excel_original'] ?? '' }}"
                                                        placeholder="ابحث واختر اسماً..." autocomplete="off"
                                                        spellcheck="false">
                                                    <button type="button" class="btn-clear-sel"
                                                        data-index="{{ $index }}" id="clear-{{ $index }}"
                                                        {{ empty($item['excel_original']) ? 'style=display:none' : '' }}>
                                                        <i class="fas fa-times-circle"></i>
                                                    </button>
                                                </div>

                                                {{-- القائمة المنسدلة --}}
                                                <div class="search-dropdown" id="drop-{{ $index }}">
                                                    <div class="drop-inner">
                                                        @forelse ($allExcelNames as $excelName)
                                                            <div class="search-opt {{ ($item['excel_original'] ?? '') === $excelName ? 'selected-opt' : '' }}"
                                                                data-value="{{ $excelName }}"
                                                                data-index="{{ $index }}">
                                                                <span class="opt-check"><i
                                                                        class="fas fa-check"></i></span>
                                                                <span class="opt-text">{{ $excelName }}</span>
                                                            </div>
                                                        @empty
                                                            <div class="drop-empty">لا توجد بيانات</div>
                                                        @endforelse
                                                        <div class="drop-no-results d-none">
                                                            <i class="fas fa-search-minus ml-1"></i> لا توجد نتائج مطابقة
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="mapping[{{ $index }}][excel_name]"
                                                    id="hidden-{{ $index }}"
                                                    value="{{ $item['excel_original'] ?? '' }}">
                                            </div>
                                        </td>

                                        {{-- زر التجاهل --}}
                                        <td class="text-center align-middle">
                                            <button type="button" class="btn-ignore-row"
                                                id="ignore-btn-{{ $index }}" data-index="{{ $index }}"
                                                data-state="active">
                                                <i class="fas fa-eye-slash ml-1"></i>تجاهل
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="card-footer d-flex align-items-center justify-content-between py-3 px-4"
                    style="border-top: 1px solid var(--border-clr); border-radius: 0 0 12px 12px;">
                    <div class="d-flex align-items-center gap-2">
                        <span class="legend-dot dot-matched"></span><small class="text-muted mr-3">مطابق</small>
                        <span class="legend-dot dot-unmatched mr-2"></span><small class="text-muted mr-3">غير
                            مربوط</small>
                        <span class="legend-dot dot-ignored mr-2"></span><small class="text-muted">متجاهل</small>
                    </div>
                    <button type="submit" class="btn-save-main" id="btn-save">
                        <i class="fas fa-save ml-2"></i>حفظ ومزامنة الحركات
                    </button>
                </div>
            </form>
        </div>

    </div>
@stop

@section('css')
    <style>
        /* ===================================================
               CSS Variables — Light & Dark Mode
            =================================================== */
        :root {
            --brand: #6c63ff;
            --brand-soft: rgba(108, 99, 255, .08);
            --brand-mid: rgba(108, 99, 255, .18);

            --card-bg: #ffffff;
            --card-header: #ffffff;
            --table-head: #f8f9fc;
            --table-row-hover: rgba(108, 99, 255, .04);
            --row-matched: rgba(40, 167, 69, .04);
            --row-pending: rgba(255, 193, 7, .03);
            --row-ignored-bg: #f8f9fa;

            --input-bg: #f7f8fc;
            --input-border: #dde1ec;
            --input-focus: #6c63ff;
            --input-matched-bg: rgba(40, 167, 69, .06);
            --input-matched-border: #28a745;
            --input-matched-color: #1a7a35;

            --drop-bg: #ffffff;
            --drop-border: #dde1ec;
            --drop-hover: #f3f2ff;
            --drop-selected-bg: rgba(40, 167, 69, .08);
            --drop-selected-color: #1a7a35;
            --drop-disabled-opacity: .3;

            --text-main: #212529;
            --text-muted: #6c757d;
            --border-clr: #e9ecef;

            --stat-success-bg: rgba(40, 167, 69, .08);
            --stat-success-icon: #28a745;
            --stat-warning-bg: rgba(255, 193, 7, .1);
            --stat-warning-icon: #d39e00;
            --stat-secondary-bg: rgba(108, 117, 125, .08);
            --stat-secondary-icon: #6c757d;

            --ignore-color: #dc3545;
            --ignore-border: rgba(220, 53, 69, .35);
            --ignore-hover: rgba(220, 53, 69, .08);
            --undo-color: #6c757d;
            --undo-border: rgba(108, 117, 125, .3);
            --undo-hover: rgba(108, 117, 125, .08);

            --shadow-card: 0 4px 24px rgba(108, 99, 255, .08);
            --shadow-drop: 0 8px 24px rgba(0, 0, 0, .12);
        }

        .dark-mode {
            --brand: #8b83ff;
            --brand-soft: rgba(139, 131, 255, .1);
            --brand-mid: rgba(139, 131, 255, .2);

            --card-bg: #1f2329;
            --card-header: #252b33;
            --table-head: #252b33;
            --table-row-hover: rgba(139, 131, 255, .06);
            --row-matched: rgba(40, 167, 69, .06);
            --row-pending: rgba(255, 193, 7, .04);
            --row-ignored-bg: #191d22;

            --input-bg: #2a3038;
            --input-border: #3d4551;
            --input-focus: #8b83ff;
            --input-matched-bg: rgba(40, 167, 69, .1);
            --input-matched-border: #48c774;
            --input-matched-color: #5dd992;

            --drop-bg: #252b33;
            --drop-border: #3d4551;
            --drop-hover: #2e3540;
            --drop-selected-bg: rgba(40, 167, 69, .12);
            --drop-selected-color: #5dd992;
            --drop-disabled-opacity: .2;

            --text-main: #d1d5db;
            --text-muted: #8d96a0;
            --border-clr: #2e3540;

            --stat-success-bg: rgba(40, 167, 69, .12);
            --stat-success-icon: #48c774;
            --stat-warning-bg: rgba(255, 193, 7, .12);
            --stat-warning-icon: #ffd454;
            --stat-secondary-bg: rgba(108, 117, 125, .12);
            --stat-secondary-icon: #adb5bd;

            --ignore-color: #ff7b7b;
            --ignore-border: rgba(255, 123, 123, .3);
            --ignore-hover: rgba(255, 123, 123, .08);
            --undo-color: #8d96a0;
            --undo-border: rgba(141, 150, 160, .3);
            --undo-hover: rgba(141, 150, 160, .08);

            --shadow-card: 0 4px 24px rgba(0, 0, 0, .3);
            --shadow-drop: 0 8px 28px rgba(0, 0, 0, .4);
        }

        /* ===================================================
               Stat Cards
            =================================================== */
        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border-clr);
            border-radius: 12px !important;
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-card) !important;
        }

        .stat-icon-wrap {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .success-icon {
            background: var(--stat-success-bg);
            color: var(--stat-success-icon);
        }

        .warning-icon {
            background: var(--stat-warning-bg);
            color: var(--stat-warning-icon);
        }

        .secondary-icon {
            background: var(--stat-secondary-bg);
            color: var(--stat-secondary-icon);
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1;
        }

        .stat-label {
            font-size: .78rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .stat-progress {
            height: 4px;
            background: var(--border-clr);
            border-radius: 4px;
            width: 100px;
        }

        .stat-progress-bar {
            height: 100%;
            background: #28a745;
            border-radius: 4px;
            transition: width .4s ease;
        }

        /* ===================================================
               Matching Card
            =================================================== */
        .matching-card {
            background: var(--card-bg) !important;
            border: 1px solid var(--border-clr) !important;
            border-radius: 12px !important;
            box-shadow: var(--shadow-card) !important;
        }

        .matching-card .card-header {
            background: var(--card-header) !important;
            border-color: var(--border-clr) !important;
        }

        .matching-card .card-footer {
            background: var(--card-bg) !important;
        }

        /* ===================================================
               Table
            =================================================== */
        .matching-table thead tr {
            background: var(--table-head);
        }

        .matching-table thead th {
            border-top: 0;
            border-bottom: 2px solid var(--border-clr);
            padding: .85rem 1rem;
        }

        .th-label {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        .matching-table tbody tr {
            border-bottom: 1px solid var(--border-clr);
            transition: background .15s;
        }

        .matching-table tbody tr:last-child {
            border-bottom: none;
        }

        .matching-table tbody tr:hover {
            background: var(--table-row-hover) !important;
        }

        .row-matched {
            background: var(--row-matched) !important;
        }

        .row-pending {
            background: var(--row-pending) !important;
        }

        .row-ignored {
            background: var(--row-ignored-bg) !important;
            opacity: .45;
            filter: grayscale(.6);
        }

        .row-ignored td {
            pointer-events: none;
        }

        .row-ignored td:last-child {
            pointer-events: auto;
        }

        /* ===================================================
               Customer Name Cell
            =================================================== */
        .customer-name-cell {
            display: flex;
            flex-direction: column;
        }

        .customer-name {
            font-weight: 600;
            color: var(--text-main);
            font-size: .9rem;
        }

        .customer-id {
            font-size: .72rem;
            margin-top: 1px;
        }

        /* ===================================================
               Status Dots
            =================================================== */
        .indicator-dot,
        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }

        .dot-matched {
            background: #28a745;
            box-shadow: 0 0 6px rgba(40, 167, 69, .5);
        }

        .dot-unmatched {
            background: #ffc107;
            box-shadow: 0 0 6px rgba(255, 193, 7, .5);
        }

        .dot-ignored {
            background: #adb5bd;
            box-shadow: none;
        }

        .legend-dot {
            vertical-align: middle;
            margin-left: 4px;
        }

        /* ===================================================
               Search Field
            =================================================== */
        .custom-search-wrap {
            position: relative;
        }

        .search-field-wrap {
            display: flex;
            align-items: center;
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            border-radius: 8px;
            padding: 0 10px;
            height: 40px;
            transition: border-color .2s, box-shadow .2s;
            gap: 8px;
        }

        .search-field-wrap:focus-within {
            border-color: var(--input-focus);
            box-shadow: 0 0 0 3px var(--brand-soft);
        }

        .search-field-wrap.is-matched {
            border-color: var(--input-matched-border);
            background: var(--input-matched-bg);
        }

        .search-field-wrap.is-matched .search-trigger {
            color: var(--input-matched-color);
            font-weight: 600;
        }

        .search-icon {
            color: var(--text-muted);
            font-size: .75rem;
            flex-shrink: 0;
            transition: color .2s;
        }

        .search-field-wrap:focus-within .search-icon {
            color: var(--brand);
        }

        .search-field-wrap.is-matched .search-icon {
            color: var(--input-matched-border);
        }

        .search-trigger {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            color: var(--text-main);
            font-size: .875rem;
            font-family: inherit;
            min-width: 0;
        }

        .search-trigger::placeholder {
            color: var(--text-muted);
            font-size: .83rem;
        }

        .btn-clear-sel {
            border: none;
            background: none;
            padding: 0;
            color: var(--text-muted);
            cursor: pointer;
            font-size: .9rem;
            line-height: 1;
            transition: color .15s;
            flex-shrink: 0;
        }

        .btn-clear-sel:hover {
            color: #dc3545;
        }

        /* ===================================================
               Search Dropdown
            =================================================== */
        .search-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            right: 0;
            background: var(--drop-bg);
            border: 1.5px solid var(--drop-border);
            border-radius: 10px;
            z-index: 9999;
            box-shadow: var(--shadow-drop);
            overflow: hidden;
        }

        .search-dropdown.open {
            display: block;
            animation: dropIn .15s ease;
        }

        @keyframes dropIn {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .drop-inner {
            max-height: 210px;
            overflow-y: auto;
        }

        .drop-inner::-webkit-scrollbar {
            width: 4px;
        }

        .drop-inner::-webkit-scrollbar-thumb {
            background: var(--drop-border);
            border-radius: 4px;
        }

        .search-opt {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 14px;
            cursor: pointer;
            color: var(--text-main);
            font-size: .855rem;
            border-bottom: 1px solid var(--drop-border);
            transition: background .1s;
        }

        .search-opt:last-of-type {
            border-bottom: none;
        }

        .search-opt:hover {
            background: var(--drop-hover);
        }

        .search-opt.selected-opt {
            background: var(--drop-selected-bg);
            color: var(--drop-selected-color);
            font-weight: 600;
        }

        .search-opt.disabled-opt {
            opacity: var(--drop-disabled-opacity);
            pointer-events: none;
            cursor: default;
        }

        .opt-check {
            width: 16px;
            text-align: center;
            color: var(--drop-selected-color);
            font-size: .7rem;
            flex-shrink: 0;
            visibility: hidden;
        }

        .selected-opt .opt-check {
            visibility: visible;
        }

        .opt-text {
            flex: 1;
        }

        .drop-no-results,
        .drop-empty {
            padding: 14px;
            text-align: center;
            color: var(--text-muted);
            font-size: .83rem;
        }

        /* ===================================================
               Ignore Button
            =================================================== */
        .btn-ignore-row {
            border: 1.5px solid var(--ignore-border);
            background: transparent;
            color: var(--ignore-color);
            border-radius: 20px;
            padding: 4px 14px;
            font-size: .78rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s, color .15s;
            white-space: nowrap;
            font-family: inherit;
        }

        .btn-ignore-row:hover {
            background: var(--ignore-hover);
        }

        .btn-ignore-row.is-undo {
            border-color: var(--undo-border);
            color: var(--undo-color);
        }

        .btn-ignore-row.is-undo:hover {
            background: var(--undo-hover);
        }

        /* ===================================================
               Save Button
            =================================================== */
        .btn-save-main {
            background: var(--brand);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 32px;
            font-size: .92rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background .2s, transform .15s, box-shadow .2s;
            box-shadow: 0 4px 14px var(--brand-mid);
            font-family: inherit;
        }

        .btn-save-main:hover {
            background: #574fd6;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px var(--brand-mid);
        }

        .btn-save-main:active {
            transform: scale(.98);
        }

        .btn-save-main:disabled {
            opacity: .65;
            cursor: not-allowed;
            transform: none;
        }

        /* ===================================================
               Responsive
            =================================================== */
        @media (max-width: 768px) {
            .stat-number {
                font-size: 1.4rem;
            }

            .search-trigger {
                font-size: .82rem;
            }

            .btn-save-main {
                padding: 9px 20px;
                font-size: .85rem;
            }
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {

            /* ==========================================
               STATE — خريطة المطابقات الحالية
            ========================================== */
            let selectedMap = {}; // { rowIndex: excelName }
            let ignoredSet = new Set(); // مجموعة الصفوف المتجاهلة

            // تهيئة من القيم المعيّنة مسبقاً من السيرفر
            $('.customer-row').each(function() {
                let idx = parseInt($(this).data('index'));
                let val = $('#hidden-' + idx).val();
                if (val) selectedMap[idx] = val;
            });

            /* ==========================================
               HELPERS
            ========================================== */

            // القيم المستخدمة في صفوف أخرى (لمنع التكرار)
            function getUsedValues(excludeIdx) {
                return Object.entries(selectedMap)
                    .filter(([i]) => parseInt(i) !== excludeIdx && !ignoredSet.has(parseInt(i)))
                    .map(([, v]) => v);
            }

            // تحديث عرض الخيارات المعطّلة في dropdown معيّن
            function refreshDropOptions(idx) {
                let used = getUsedValues(idx);
                $('#drop-' + idx + ' .search-opt').each(function() {
                    let val = $(this).data('value');
                    $(this).toggleClass('disabled-opt', used.includes(val));
                });
            }

            // إغلاق كل القوائم
            function closeAllDrops() {
                $('.search-dropdown').removeClass('open');
            }

            // فتح قائمة معيّنة
            function openDrop(idx) {
                closeAllDrops();
                refreshDropOptions(idx);
                // إعادة إظهار جميع الخيارات (مسح فلترة البحث السابقة)
                $('#drop-' + idx + ' .search-opt').show();
                $('#drop-' + idx + ' .drop-no-results').addClass('d-none');
                $('#drop-' + idx).addClass('open');
            }

            // تحديث شكل صف بعد تغيير
            function updateRowState(idx) {
                let row = $('#row-' + idx);
                let dot = $('#dot-' + idx);
                let field = $('#field-' + idx);

                if (ignoredSet.has(idx)) {
                    dot.attr('class', 'indicator-dot dot-ignored');
                    return;
                }

                if (selectedMap[idx]) {
                    dot.attr('class', 'indicator-dot dot-matched');
                    field.addClass('is-matched');
                    row.addClass('row-matched').removeClass('row-pending');
                } else {
                    dot.attr('class', 'indicator-dot dot-unmatched');
                    field.removeClass('is-matched');
                    row.addClass('row-pending').removeClass('row-matched');
                }
            }

            // تحديث الإحصائيات
            function updateStats() {
                let totalRows = $('.customer-row').length;
                let active = totalRows - ignoredSet.size;
                let matched = 0;

                Object.entries(selectedMap).forEach(([i, v]) => {
                    if (v && !ignoredSet.has(parseInt(i))) matched++;
                });

                let pending = active - matched;
                let pct = active > 0 ? Math.round((matched / active) * 100) : 0;

                $('#stat-matched').text(matched);
                $('#stat-pending').text(pending);
                $('#stat-ignored').text(ignoredSet.size);
                $('#badge-total').text(totalRows + ' عميل');
                $('#progress-matched').css('width', pct + '%');
                $('#match-summary').text(matched + ' / ' + active + ' مطابق (' + pct + '%)');
            }

            /* ==========================================
               EVENTS — فتح القائمة
            ========================================== */
            $(document).on('focus click', '.search-trigger', function(e) {
                let idx = parseInt($(this).data('index'));
                openDrop(idx);
            });

            /* ==========================================
               EVENTS — البحث
            ========================================== */
            $(document).on('input', '.search-trigger', function() {
                let idx = parseInt($(this).data('index'));
                let query = $(this).val().trim();
                let found = 0;

                // لو مسح الكتابة كلها → أعد تصفير الاختيار
                if (!query) {
                    if (selectedMap[idx]) {
                        delete selectedMap[idx];
                        $('#hidden-' + idx).val('');
                        $('#clear-' + idx).hide();
                        updateRowState(idx);
                        updateStats();
                    }
                    // أظهر كل الخيارات
                    $('#drop-' + idx + ' .search-opt').show();
                    $('#drop-' + idx + ' .drop-no-results').addClass('d-none');
                    openDrop(idx);
                    return;
                }

                // فلترة النتائج
                $('#drop-' + idx + ' .search-opt').each(function() {
                    let match = $(this).data('value').includes(query);
                    $(this).toggle(match);
                    if (match) found++;
                });
                $('#drop-' + idx + ' .drop-no-results').toggleClass('d-none', found > 0);

                if (!$('#drop-' + idx).hasClass('open')) {
                    $('#drop-' + idx).addClass('open');
                }
            });

            /* ==========================================
               EVENTS — اختيار خيار
            ========================================== */
            $(document).on('click', '.search-opt', function(e) {
                e.stopPropagation();
                if ($(this).hasClass('disabled-opt')) return;

                let idx = parseInt($(this).data('index'));
                let val = $(this).data('value');

                // حفظ الاختيار
                selectedMap[idx] = val;
                $('#hidden-' + idx).val(val);
                $('#inp-' + idx).val(val);
                $('#clear-' + idx).show();

                // تحديث علامة الصح داخل الـ dropdown
                $('#drop-' + idx + ' .search-opt').removeClass('selected-opt');
                $(this).addClass('selected-opt');

                updateRowState(idx);
                closeAllDrops();
                updateStats();
            });

            /* ==========================================
               EVENTS — زر المسح
            ========================================== */
            $(document).on('click', '.btn-clear-sel', function(e) {
                e.stopPropagation();
                let idx = parseInt($(this).data('index'));

                // إزالة الاختيار
                delete selectedMap[idx];
                $('#hidden-' + idx).val('');
                $('#inp-' + idx).val('');
                $(this).hide();

                // إزالة selected-opt من الـ dropdown
                $('#drop-' + idx + ' .search-opt').removeClass('selected-opt');

                updateRowState(idx);
                closeAllDrops();
                updateStats();
            });

            /* ==========================================
               EVENTS — زر التجاهل / تراجع
            ========================================== */
            $(document).on('click', '.btn-ignore-row', function() {
                let idx = parseInt($(this).data('index'));
                let row = $('#row-' + idx);

                if (!ignoredSet.has(idx)) {
                    // ← تجاهل
                    ignoredSet.add(idx);
                    row.addClass('row-ignored').removeClass('row-matched row-pending');
                    $(this).html('<i class="fas fa-undo ml-1"></i>تراجع').addClass('is-undo');
                    closeAllDrops();
                } else {
                    // ← تراجع
                    ignoredSet.delete(idx);
                    row.removeClass('row-ignored');
                    $(this).html('<i class="fas fa-eye-slash ml-1"></i>تجاهل').removeClass('is-undo');
                    updateRowState(idx);
                }

                updateStats();
            });

            /* ==========================================
               EVENTS — إغلاق الـ dropdown خارجياً
            ========================================== */
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.custom-search-wrap').length) {
                    closeAllDrops();
                }
            });

            /* ==========================================
               EVENTS — التحقق عند الإرسال
            ========================================== */
            $('#mappingForm').on('submit', function(e) {
                let matched = Object.entries(selectedMap)
                    .filter(([i, v]) => v && !ignoredSet.has(parseInt(i))).length;

                if (matched === 0) {
                    e.preventDefault();
                    toastr.warning('يجب مطابقة عميل واحد على الأقل قبل الحفظ.', 'تنبيه');
                    return;
                }

                // تعطيل الصفوف المتجاهلة من الإرسال
                ignoredSet.forEach(idx => {
                    $('#row-' + idx + ' input[type=hidden]').prop('disabled', true);
                });

                $('#btn-save').prop('disabled', true)
                    .html('<i class="fas fa-spinner fa-spin ml-2"></i>جارٍ الحفظ...');
            });

            /* ==========================================
               INIT
            ========================================== */
            // تهيئة أولى لمؤشرات الحالة
            $('.customer-row').each(function() {
                updateRowState(parseInt($(this).data('index')));
            });
            updateStats();

        });
    </script>
@stop
