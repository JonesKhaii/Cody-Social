@extends('layouts.master')

@section('main-content')
    <div class="specialties-page py-4">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Chuyên môn bác sĩ</li>
                </ol>
            </nav>

            <h1 class="mb-2">Chuyên môn bác sĩ</h1>
            <p class="lead mb-5">Khám phá kiến thức chuyên môn, sự kiện và chia sẻ từ đội ngũ bác sĩ</p>

            <!-- Danh mục chuyên môn -->
            <div class="row mb-5">
                <!-- Sự kiện chuyên môn -->
                <div class="col-lg-6 mb-4">
                    <div class="card h-100 hover-card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="category-icon bg-light me-3 rounded p-3">
                                    <i class="fas fa-calendar-alt text-primary fa-2x"></i>
                                </div>
                                <h3>Sự kiện chuyên môn</h3>
                            </div>
                            <p>Theo dõi các sự kiện chuyên môn, hội thảo đào tạo và workshop để cập nhật kiến thức y khoa
                                mới nhất.</p>
                            <a href="" class="btn btn-outline-primary mt-3">Xem tất cả sự
                                kiện</a>
                        </div>
                    </div>
                </div>

                <!-- Câu chuyện nghề y -->
                <div class="col-lg-6 mb-4">
                    <div class="card h-100 hover-card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="category-icon bg-light me-3 rounded p-3">
                                    <i class="fas fa-book-medical text-primary fa-2x"></i>
                                </div>
                                <h3>Câu chuyện nghề y</h3>
                            </div>
                            <p>Những trải nghiệm, tâm sự và góc nhìn của các bác sĩ trong hành trình hành nghề và chăm sóc
                                bệnh nhân.</p>
                            <a href="" class="btn btn-outline-primary mt-3">Đọc câu
                                chuyện</a>
                        </div>
                    </div>
                </div>

                <!-- Thành tựu & nghiên cứu -->
                <div class="col-lg-6 mb-4">
                    <div class="card h-100 hover-card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="category-icon bg-light me-3 rounded p-3">
                                    <i class="fas fa-microscope text-primary fa-2x"></i>
                                </div>
                                <h3>Thành tựu & nghiên cứu</h3>
                            </div>
                            <p>Khám phá các công trình nghiên cứu y học và báo cáo ca lâm sàng đặc biệt từ đội ngũ y bác sĩ.
                            </p>
                            <a href="" class="btn btn-outline-primary mt-3">Xem nghiên
                                cứu</a>
                        </div>
                    </div>
                </div>

                <!-- Video chia sẻ chuyên môn -->
                <div class="col-lg-6 mb-4">
                    <div class="card h-100 hover-card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="category-icon bg-light me-3 rounded p-3">
                                    <i class="fas fa-video text-primary fa-2x"></i>
                                </div>
                                <h3>Video chia sẻ chuyên môn</h3>
                            </div>
                            <p>Xem các video chia sẻ kiến thức chuyên môn, hướng dẫn và tư vấn sức khỏe từ các bác sĩ.</p>
                            <a href="" class="btn btn-outline-primary mt-3">Xem video</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sự kiện sắp diễn ra -->
            <div class="upcoming-events mb-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title mb-0">Sự kiện sắp diễn ra</h2>
                    <a href="" class="btn btn-link">Xem tất cả <i
                            class="fas fa-angle-right ms-1"></i></a>
                </div>

                <div class="row">
                    @if (count($upcomingEvents) > 0)
                        @foreach ($upcomingEvents as $event)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card event-card hover-card h-100">
                                    <div
                                        class="event-date {{ isset($event->meta_data['is_online']) && $event->meta_data['is_online'] ? 'bg-info' : 'bg-primary' }} py-2 text-center text-white">
                                        @php
                                            $startDate = \Carbon\Carbon::parse(
                                                $event->meta_data['event_start_date'] ?? now(),
                                            );
                                        @endphp
                                        <div class="small">{{ $startDate->format('l') }}</div>
                                        <div class="h4 mb-0">{{ $startDate->format('d') }}</div>
                                        <div class="small">{{ $startDate->format('F Y') }}</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span
                                                class="badge bg-{{ isset($event->meta_data['is_online']) && $event->meta_data['is_online'] ? 'info' : 'success' }}">
                                                {{ isset($event->meta_data['is_online']) && $event->meta_data['is_online'] ? 'Trực tuyến' : 'Trực tiếp' }}
                                            </span>
                                        </div>
                                        <h5 class="card-title">{{ $event->title }}</h5>
                                        <p class="card-text">{{ Str::limit($event->summary, 100) }}</p>

                                        <div class="event-details mt-3">
                                            <div class="mb-2">
                                                <i class="far fa-clock text-primary me-2"></i>
                                                {{ $startDate->format('H:i') }}
                                                @if (isset($event->meta_data['event_end_date']))
                                                    -
                                                    {{ \Carbon\Carbon::parse($event->meta_data['event_end_date'])->format('H:i') }}
                                                @endif
                                            </div>
                                            @if (isset($event->meta_data['location']))
                                                <div class="mb-2">
                                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                                    {{ $event->meta_data['location'] }}
                                                </div>
                                            @endif
                                            @if (isset($event->meta_data['speaker']))
                                                <div>
                                                    <i class="fas fa-user-md text-primary me-2"></i>
                                                    {{ $event->meta_data['speaker'] }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-footer border-top-0 bg-transparent">
                                        <a href="{{ route('post.detail', $event->slug) }}"
                                            class="btn btn-primary w-100">Chi tiết & Đăng ký</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="alert alert-info">
                                Hiện không có sự kiện nào sắp diễn ra. Vui lòng quay lại sau.
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Câu chuyện nghề y mới nhất -->
            <div class="latest-stories mb-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title mb-0">Câu chuyện nghề y mới nhất</h2>
                    <a href="{{ route('specialties.stories') }}" class="btn btn-link">Xem tất cả <i
                            class="fas fa-angle-right ms-1"></i></a>
                </div>

                <div class="row">
                    @if (count($latestStories) > 0)
                        @foreach ($latestStories as $story)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card story-card hover-card h-100">
                                    @if ($story->photo)
                                        <img src="{{ $story->photo }}" class="card-img-top" alt="{{ $story->title }}"
                                            style="height: 200px; object-fit: cover;">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $story->title }}</h5>
                                        <p class="card-text">{{ Str::limit($story->summary, 100) }}</p>

                                        <div class="doctor-info d-flex align-items-center mt-3">
                                            @if ($story->author_info && $story->author_info->photo)
                                                <img src="{{ $story->author_info->photo }}" class="rounded-circle me-2"
                                                    alt="{{ $story->author_info->name }}" width="40" height="40">
                                            @else
                                                <div class="doctor-avatar bg-light rounded-circle d-flex align-items-center justify-content-center me-2"
                                                    style="width: 40px; height: 40px;">
                                                    <i class="fas fa-user-md text-primary"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="doctor-name">{{ $story->author_info->name ?? 'Bác sĩ' }}</div>
                                                <div class="story-date small text-muted">
                                                    {{ $story->created_at->format('d/m/Y') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer border-top-0 bg-transparent">
                                        <a href="{{ route('post.detail', $story->slug) }}" class="btn btn-link p-0">Đọc
                                            tiếp <i class="fas fa-angle-right ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="alert alert-info">
                                Chưa có câu chuyện nghề y nào. Vui lòng quay lại sau.
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Video chuyên môn mới nhất -->
            <div class="latest-videos mb-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title mb-0">Video chia sẻ chuyên môn</h2>
                    <a href="{{ route('specialties.videos') }}" class="btn btn-link">Xem tất cả <i
                            class="fas fa-angle-right ms-1"></i></a>
                </div>

                <div class="row">
                    @if (count($latestVideos) > 0)
                        @foreach ($latestVideos as $video)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card video-card hover-card h-100">
                                    <div class="video-thumbnail position-relative">
                                        @if ($video->photo)
                                            <img src="{{ $video->photo }}" class="card-img-top"
                                                alt="{{ $video->title }}" style="height: 200px; object-fit: cover;">
                                        @else
                                            <div class="placeholder-thumbnail bg-light d-flex align-items-center justify-content-center"
                                                style="height: 200px;">
                                                <i class="fas fa-video fa-3x text-primary"></i>
                                            </div>
                                        @endif
                                        <div class="play-icon position-absolute"
                                            style="top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                            <i class="fas fa-play-circle fa-3x text-white"></i>
                                        </div>
                                        @if (isset($video->meta_data['duration']))
                                            <div class="video-duration position-absolute bg-dark rounded px-2 py-1 text-white"
                                                style="bottom: 10px; right: 10px;">
                                                {{ $video->meta_data['duration'] }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $video->title }}</h5>
                                        <div class="doctor-info d-flex align-items-center mt-3">
                                            @if ($video->author_info && $video->author_info->photo)
                                                <img src="{{ $video->author_info->photo }}" class="rounded-circle me-2"
                                                    alt="{{ $video->author_info->name }}" width="40" height="40">
                                            @else
                                                <div class="doctor-avatar bg-light rounded-circle d-flex align-items-center justify-content-center me-2"
                                                    style="width: 40px; height: 40px;">
                                                    <i class="fas fa-user-md text-primary"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="doctor-name">{{ $video->author_info->name ?? 'Bác sĩ' }}</div>
                                                <div class="video-date small text-muted">
                                                    {{ $video->created_at->format('d/m/Y') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer border-top-0 bg-transparent">
                                        <a href="{{ route('post.detail', $video->slug) }}"
                                            class="btn btn-primary w-100">Xem video</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="alert alert-info">
                                Chưa có video chuyên môn nào. Vui lòng quay lại sau.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .category-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .text-primary {
            color: #1565c0 !important;
        }
    </style>
@endsection
