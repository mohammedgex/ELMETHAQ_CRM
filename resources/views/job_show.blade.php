@extends('layouts.app')
@section('title', $job->title)
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="job-card-details p-4 shadow-sm mb-4"
                    style="border-radius: 20px; background: linear-gradient(135deg, #fff 85%, #f8fafc 100%);">
                    @if ($job->image)
                        <img src="{{ asset('job_images/' . $job->image) }}" alt="صورة الوظيفة" class="job-img mb-4"
                            style="width:100%;max-height:320px;object-fit:cover;border-radius:16px;box-shadow:0 2px 12px rgba(23,74,124,0.10);">
                    @endif
                    <div class="d-flex align-items-center mb-3">
                        <div class="job-icon-details d-flex align-items-center justify-content-center me-3">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <h2 class="fw-bold mb-0" style="color:#174A7C; font-size:2rem;">{{ $job->title }}</h2>
                    </div>
                    <div class="mb-3" style="color:#B89C5A; font-weight:600; font-size:1.15rem;">{{ $job->details }}</div>
                    <div class="mb-4"
                        style="color:#174A7C; font-size:1.13rem; line-height:2; background:rgba(184,156,90,0.04); border-radius:10px; padding:18px;">
                        {{ $job->description }}</div>
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="mailto:info@elmethaq.co?subject=تقديم على وظيفة: {{ $job->title }}"
                            class="btn job-apply-btn">تقديم الآن</a>
                        <a href="{{ route('jobs') }}" class="btn btn-outline-secondary">رجوع</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .job-card-details {
            box-shadow: 0 4px 24px rgba(23, 74, 124, 0.10);
        }

        .job-icon-details {
            width: 54px;
            height: 54px;
            background: linear-gradient(135deg, #174A7C 60%, #B89C5A 100%);
            color: #fff;
            border-radius: 50%;
            font-size: 1.7rem;
            box-shadow: 0 2px 8px rgba(23, 74, 124, 0.10);
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
    </style>
@endsection
