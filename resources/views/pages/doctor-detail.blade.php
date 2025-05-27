@extends('layouts.master')

@section('title', 'Hồ Sơ Bác Sĩ | ' . $doctor->name)
@section('page_css')
    <link rel="stylesheet" href="{{ asset('css/doctor-detail.css') }}">
@endsection

@section('main-content')


    <div class="container mt-5">
        <div class="row row-infor">
            <!-- Cột thông tin bác sĩ -->
            <div class="col-md-4">
                <div class="profile-section doctor-main-profile">
                    <img src="{{ $doctor->photo }}" class="profile-photo" alt="{{ $doctor->name }}">
                    <h4 class="fw-bold mb-2">{{ $doctor->name }}</h4>
                    <p class="text-primary mb-4">
                        @foreach ($doctor->specializations as $spec)
                            {{ $spec->name }}{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    </p>

                    <div class="d-flex justify-content-between mb-4 gap-2">
                        <button class="btn btn-primary btn-appointment w-50" data-bs-toggle="modal"
                            data-bs-target="#bookAppointmentModal">Đặt Lịch Khám</button>
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
                        {!! $doctor->formatted_bio !!}
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
    @include('pages.booking-appointment')

    <script>
        document.querySelector('.btn-appointment').addEventListener('click', function() {
            const doctor = {
                id: '{{ $doctor->id }}',
                name: '{{ $doctor->name }}',
                specialization: '{{ $doctor->specialization }}',
                photo: '{{ $doctor->photo }}'
            };

            // Điền thông tin bác sĩ vào modal
            document.getElementById('selected_doctor_id').value = doctor.id;
            document.getElementById('selected-doctor-name').textContent = 'Bs. ' + doctor.name;
            document.getElementById('selected-doctor-specialization').textContent = doctor.specialization;
            document.getElementById('selected-doctor-img').src = doctor.photo;
            document.getElementById('selected-doctor-info').style.display = 'block';

            // Mở modal để người dùng điền thông tin và đặt lịch
            const bookAppointmentModal = new bootstrap.Modal(document.getElementById('bookAppointmentModal'));
            bookAppointmentModal.show();

            // Đảm bảo khi đóng modal, backdrop cũng sẽ biến mất
            document.getElementById('bookAppointmentModal').addEventListener('hidden.bs.modal', function() {
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove(); // Loại bỏ backdrop khi modal đóng
                }
            });
        });
    </script>
@endsection
