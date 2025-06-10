@extends('layouts.master')

@section('main-content')
    <div class="events-page py-4">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('specialties.index') }}">Chuyên môn bác sĩ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Lịch sự kiện chuyên môn</li>
                </ol>
            </nav>

            <h1 class="mb-2">Lịch sự kiện chuyên môn</h1>
            <p class="lead mb-5">Cập nhật các sự kiện y khoa, hội thảo đào tạo và workshop nội bộ</p>

            <!-- Lọc sự kiện -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('specialties.events') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="eventType" class="form-label">Loại sự kiện</label>
                            <select class="form-select" id="eventType" name="type">
                                <option value="">Tất cả</option>
                                @foreach ($eventCategories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('type') == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="eventDate" class="form-label">Thời gian</label>
                            <select class="form-select" id="eventDate" name="date">
                                <option value="">Tất cả</option>
                                <option value="upcoming" {{ request('date') == 'upcoming' ? 'selected' : '' }}>Sắp diễn ra
                                </option>
                                <option value="past" {{ request('date') == 'past' ? 'selected' : '' }}>Đã diễn ra</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Lọc sự kiện</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sự kiện sắp diễn ra -->
            @if (!request('date') || request('date') == 'upcoming')
                <div class="upcoming-events mb-5">
                    <h2 class="section-title mb-4">Sự kiện sắp diễn ra</h2>

                    @if (count($upcomingEvents) > 0)
                        <div class="row">
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
                                                @if ($event->cat_info)
                                                    <span
                                                        class="badge bg-light text-dark">{{ $event->cat_info->title }}</span>
                                                @endif
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
                        </div>

                       
                        <div class="pagination-container">
                            {{ $upcomingEvents->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            Hiện không có sự kiện nào sắp diễn ra. Vui lòng quay lại sau.
                        </div>
                    @endif
                </div>
            @endif

            <!-- Sự kiện đã diễn ra -->
            @if (!request('date') || request('date') == 'past')
                <div class="past-events">
                    <h2 class="section-title mb-4">Sự kiện đã diễn ra</h2>

                    @if (count($pastEvents) > 0)
                        <div class="row">
                            @foreach ($pastEvents as $event)
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card event-card hover-card h-100">
                                        <div class="event-date bg-secondary py-2 text-center text-white">
                                            @php
                                                $startDate = \Carbon\Carbon::parse(
                                                    $event->meta_data['event_start_date'] ?? $event->created_at,
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
                                                @if ($event->cat_info)
                                                    <span
                                                        class="badge bg-light text-dark">{{ $event->cat_info->title }}</span>
                                                @endif
                                            </div>
                                            <h5 class="card-title">{{ $event->title }}</h5>
                                            <p class="card-text">{{ Str::limit($event->summary, 100) }}</p>
                                        </div>
                                        <div class="card-footer border-top-0 bg-transparent">
                                            <a href="{{ route('post.detail', $event->slug) }}"
                                                class="btn btn-outline-secondary w-100">Xem chi tiết</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- <div class="d-flex justify-content-center">
                            {{ $pastEvents->appends(request()->except('page'))->links() }}
                        </div> --}}
                        <div class="pagination-container">
                            {{ $pastEvents->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            Không có sự kiện nào trong lịch sử.
                        </div>
                    @endif
                </div>
            @endif
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

        .event-card .event-date {
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
