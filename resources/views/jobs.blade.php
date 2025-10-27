@extends('layouts.app')
@section('title', 'فرص العمل بالخارج')
@section('content')
    <div class="container py-5">
        <div class="text-center mb-4">
            <img src="{{ asset('images/logo-methaq.png') }}" alt="Methaq Logo"
                style="height: 70px; border-radius: 16px; background: #fff; padding: 8px; box-shadow: 0 4px 16px rgba(23,74,124,0.08);">
        </div>
        <h1 class="mb-2 text-center fw-bold" style="color:#174A7C; letter-spacing:1px; font-size:2.4rem;">فرص العمل بالخارج
        </h1>
        <p class="text-center mb-5" style="color:#174A7C; font-size:1.1rem;">هذه الصفحة مخصصة لعرض جميع فرص العمل المتاحة
            للعمالة المصرية
            بالخارج.</p>
        <div class="row g-4 justify-content-center">
            @forelse($jobs as $job)
                <div class="col-12 col-sm-6 col-lg-4 d-flex">
                    <div class="job-card flex-fill d-flex flex-column align-items-stretch">
                        @if ($job->image)
                            <img src="{{ asset('job_images/' . $job->image) }}" alt="صورة الوظيفة" class="job-img mb-2"
                                style="width:100%;max-height:170px;object-fit:cover;border-radius:14px 14px 0 0;">
                        @endif
                        <div class="job-card-header d-flex align-items-center justify-content-center mb-2">
                            <div class="job-icon d-flex align-items-center justify-content-center">
                                <i class="fas fa-briefcase"></i>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column align-items-start">
                            <h4 class="job-title mb-1 fw-bold">
                                <a href="{{ route('jobs.show', $job->id) }}"
                                    style="color:#174A7C; text-decoration:none;">{{ $job->title }}</a>
                            </h4>
                            <div class="job-details mb-3">{{ $job->details }}</div>
                            <a href="{{ route('jobs.show', $job->id) }}" class="btn job-apply-btn align-self-center">عرض
                                الوظيفة</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <div class="alert alert-info">لا توجد فرص عمل متاحة حالياً.</div>
                </div>
            @endforelse
        </div>
    </div>
    <style>
        .job-card {
            border-radius: 18px;
            background: linear-gradient(135deg, #fff 85%, #f8fafc 100%);
            box-shadow: 0 2px 12px rgba(23, 74, 124, 0.10);
            transition: box-shadow 0.2s, transform 0.2s;
            min-height: 340px;
            padding: 0 0 18px 0;
            margin-bottom: 0;
            display: flex;
            flex-direction: column;
        }

        .job-card:hover {
            box-shadow: 0 8px 32px rgba(23, 74, 124, 0.15);
            transform: translateY(-4px) scale(1.015);
        }

        .job-card-header {
            margin-top: -32px;
        }

        .job-icon {
            width: 54px;
            height: 54px;
            background: linear-gradient(135deg, #174A7C 60%, #B89C5A 100%);
            color: #fff;
            border-radius: 50%;
            font-size: 1.5rem;
            box-shadow: 0 2px 8px rgba(23, 74, 124, 0.10);
        }

        .job-title {
            color: #174A7C;
            font-size: 1.15rem;
            margin-bottom: 0.3rem;
            letter-spacing: 0.5px;
            text-align: right;
            width: 100%;
        }

        .job-details {
            color: #B89C5A;
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 0.5rem;
            text-align: right;
            width: 100%;
        }

        .job-desc {
            color: #174A7C;
            font-size: 1rem;
            min-height: 60px;
            text-align: right;
            width: 100%;
        }

        .job-apply-btn {
            background: linear-gradient(135deg, #174A7C 60%, #B89C5A 100%);
            border: none;
            border-radius: 50px;
            font-weight: 600;
            padding: 7px 28px;
            font-size: 1rem;
            transition: background 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(23, 74, 124, 0.10);
            color: #fff;
        }

        .job-apply-btn:hover {
            background: linear-gradient(135deg, #B89C5A 60%, #174A7C 100%);
            color: #fff;
            box-shadow: 0 6px 24px rgba(184, 156, 90, 0.13);
        }

        @media (max-width: 575.98px) {
            .job-card {
                min-height: 260px;
            }

            .job-title,
            .job-details,
            .job-desc {
                font-size: 0.98rem;
            }
        }
    </style>
@endsection
