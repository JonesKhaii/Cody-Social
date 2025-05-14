@extends('layouts.master')

@section('main-content')
    <div class="videos-page py-4">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('specialties.index') }}">Chuyên môn bác sĩ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Video chia sẻ chuyên môn</li>
                </ol>
            </nav>

            <h1 class="mb-2">Video chia sẻ chuyên môn</h1>
            <p class="lead mb-5">Xem các video chia sẻ kiến thức chuyên môn, hướng dẫn và tư vấn sức khỏe từ các bác sĩ</p>

            <!-- Video nổi bật -->
            @if (!request('page') && $featuredVideo)
                <div class="featured-video mb-5">
                    <div class="card shadow">
                        <div class="row g-0">
                            <div class="col-lg-8">
                                <div class="ratio ratio-16x9">
                                    @if (isset($featuredVideo->meta_data['video_url']))
                                        @php
                                            $videoUrl = $featuredVideo->meta_data['video_url'];
                                            // Xử lý URL YouTube để nhúng
                                            if (
                                                strpos($videoUrl, 'youtube.com') !== false ||
                                                strpos($videoUrl, 'youtu.be') !== false
                                            ) {
                                                $videoId = '';
                                                if (strpos($videoUrl, 'youtube.com/watch?v=') !== false) {
                                                    $videoId = substr($videoUrl, strpos($videoUrl, 'watch?v=') + 8);
                                                } elseif (strpos($videoUrl, 'youtu.be/') !== false) {
                                                    $videoId = substr($videoUrl, strpos($videoUrl, 'youtu.be/') + 9);
                                                }
                                                echo '<iframe src="https://www.youtube.com/embed/' .
                                                    $videoId .
                                                    '" title="' .
                                                    $featuredVideo->title .
                                                    '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                                            } elseif (strpos($videoUrl, 'vimeo.com') !== false) {
                                                $videoId = substr($videoUrl, strrpos($videoUrl, '/') + 1);
                                                echo '<iframe src="https://player.vimeo.com/video/' .
                                                    $videoId .
                                                    '" title="' .
                                                    $featuredVideo->title .
                                                    '" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';
                                            } else {
                                                echo '<div class="d-flex align-items-center justify-content-center bg-light h-100">
                                                <p class="text-center">Video không khả dụng</p>
                                              </div>';
                                            }
                                        @endphp
                                    @else
                                        <div class="d-flex align-items-center justify-content-center bg-light h-100">
                                            <i class="fas fa-video fa-3x text-primary"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card-body h-100 d-flex flex-column">
                                    <span class="badge bg-primary mb-2">Video nổi bật</span>
                                    <h3 class="card-title">{{ $featuredVideo->title }}</h3>
                                    <p class="card-text flex-grow-1">{{ Str::limit($featuredVideo->summary, 150) }}</p>

                                    <div class="doctor-info d-flex align-items-center mt-3">
                                        @if ($featuredVideo->author_info && $featuredVideo->author_info->photo)
                                            <img src="{{ $featuredVideo->author_info->photo }}" class="rounded-circle me-2"
                                                alt="{{ $featuredVideo->author_info->name }}" width="40" height="40">
                                        @else
                                            <div class="doctor-avatar bg-light rounded-circle d-flex align-items-center justify-content-center me-2"
                                                style="width: 40px; height: 40px;">
                                                <i class="fas fa-user-md text-primary"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="doctor-name">{{ $featuredVideo->author_info->name ?? 'Bác sĩ' }}
                                            </div>
                                            <div class="video-date small text-muted">
                                                {{ $featuredVideo->created_at->format('d/m/Y') }}</div>
                                        </div>
                                    </div>

                                    <a href="{{ route('post.detail', $featuredVideo->slug) }}"
                                        class="btn btn-primary mt-3">Xem đầy đủ</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Lọc video -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('specialties.videos') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Tìm kiếm</label>
                            <input type="text" class="form-control" id="search" name="search"
                                value="{{ request('search') }}" placeholder="Tìm theo tiêu đề...">
                        </div>
                        <div class="col-md-4">
                            <label for="doctor" class="form-label">Bác sĩ</label>
                            <select class="form-select" id="doctor" name="doctor">
                                <option value="">Tất cả</option>
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}"
                                        {{ request('doctor') == $doctor->id ? 'selected' : '' }}>{{ $doctor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Danh sách video -->
            <div class="video-list">
                <div class="row">
                    @if (count($videos) > 0)
                        @foreach ($videos as $video)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card video-card hover-card h-100">
                                    <div class="video-thumbnail position-relative">
                                        @if ($video->photo)
                                            <img src="{{ $video->photo }}" class="card-img-top" alt="{{ $video->title }}"
                                                style="height: 200px; object-fit: cover;">
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
                                        <p class="card-text">{{ Str::limit($video->summary, 80) }}</p>
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
                                Không tìm thấy video nào phù hợp với tiêu chí tìm kiếm. Vui lòng thử lại với tiêu chí khác.
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Phân trang -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $videos->appends(request()->except('page'))->links() }}
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

        .play-icon {
            transition: transform 0.3s;
        }

        .video-card:hover .play-icon {
            transform: translate(-50%, -50%) scale(1.2);
        }
    </style>
@endsection
