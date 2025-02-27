@extends('layouts.master')

@section('title', 'Hồ Sơ Bác Sĩ | ' . $doctor->name)

@section('main-content')
    <style>
        .profile-section {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.06);
            padding: 25px;
            margin-bottom: 25px;
        }

        .doctor-main-profile {
            text-align: center;
        }

        .profile-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 20px;
            border: 4px solid #f8f9fa;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .contact-info {
            margin-top: 20px;
        }

        .contact-info i {
            width: 25px;
            color: #0984e3;
            margin-right: 10px;
        }

        .btn-appointment {
            background: #0984e3;
            border: none;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .btn-appointment:hover {
            background: #0769b5;
            transform: translateY(-2px);
        }

        .btn-follow {
            border-color: #00b894;
            color: #00b894;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .btn-follow:hover {
            background: #00b894;
            color: white;
            transform: translateY(-2px);
        }

        .section-title {
            color: #2d3436;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f1f2f6;
        }

        .doctor-bio {
            line-height: 1.8;
            color: #636e72;
        }

        /* Scroll container cho bài viết */
        .posts-scroll-container {
            overflow-x: auto;
            padding: 20px 0;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f1f2f6;
        }

        .posts-wrapper {
            display: flex;
            gap: 20px;
            padding: 10px 5px;
        }

        .article-card {
            min-width: 280px;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .article-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .article-image {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }

        .article-content {
            padding: 15px;
        }

        .article-title {
            font-size: 1rem;
            color: #2d3436;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .article-summary {
            font-size: 0.9rem;
            color: #636e72;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        /* Custom scrollbar */
        .posts-scroll-container::-webkit-scrollbar {
            height: 6px;
        }

        .posts-scroll-container::-webkit-scrollbar-track {
            background: #f1f2f6;
            border-radius: 10px;
        }

        .posts-scroll-container::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
        }
    </style>

    <div class="container mt-5">
        <div class="row">
            <!-- Cột thông tin bác sĩ -->
            <div class="col-md-4">
                <div class="profile-section doctor-main-profile">
                    <img src="{{ $doctor->photo }}" class="profile-photo" alt="{{ $doctor->name }}">
                    <h4 class="fw-bold mb-2">{{ $doctor->name }}</h4>
                    <p class="text-primary mb-4">{{ $doctor->specialization }}</p>

                    <div class="d-flex justify-content-between mb-4 gap-2">
                        <button class="btn btn-appointment w-50">Đặt Lịch Khám</button>
                        <button class="btn btn-follow w-50">Theo Dõi</button>
                    </div>

                    <div class="contact-info text-start">
                        <h5 class="section-title">Thông Tin Liên Hệ</h5>
                        <p><i class="fas fa-envelope"></i>{{ $doctor->email }}</p>
                        <p><i class="fas fa-phone"></i>{{ $doctor->phone }}</p>
                    </div>
                </div>
            </div>

            <!-- Cột thông tin chi tiết -->
            <div class="col-md-8">
                <div class="profile-section">
                    <h5 class="section-title">Giới Thiệu Bác Sĩ</h5>
                    <div class="doctor-bio">
                        {{ $doctor->bio }}
                    </div>
                </div>

                <!-- Phần bài viết với scroll ngang -->
                <div class="profile-section">
                    <h5 class="section-title">Bài Viết Của Bác Sĩ</h5>
                    @if ($doctor->posts->count() > 0)
                        <div class="posts-scroll-container">
                            <div class="posts-wrapper">
                                @foreach ($doctor->posts as $post)
                                    <div class="article-card">
                                        <img src="{{ asset($post->photo) }}" class="article-image"
                                            alt="{{ $post->title }}">
                                        <div class="article-content">
                                            <h6 class="article-title">{{ $post->title }}</h6>
                                            <p class="article-summary">{{ Str::limit($post->summary, 100) }}</p>
                                            @if (!empty($post->slug))
                                                <a href="{{ route('post.detail', ['slug' => $post->slug]) }}"
                                                    class="btn btn-sm btn-primary">
                                                    Xem chi tiết
                                                </a>
                                            @else
                                                <span class="text-muted">Không có đường dẫn hợp lệ</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <p class="text-muted">Bác sĩ chưa có bài viết nào.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection
