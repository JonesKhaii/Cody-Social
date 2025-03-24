@extends('layouts.master')

@section('title', 'Hồ Sơ Của Tôi')

@section('main-content')

    <!-- Bootstrap CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS và Popper.js (bắt buộc cho Bootstrap 5) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/users.css') }}"> --}}

    <!-- Breadcrumbs -->
    <div class="breadcrumbs bg-light py-2">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list d-flex align-items-center m-0 p-0" style="list-style: none;">
                            <li>
                                <a href="{{ route('home') }}" class="text-decoration-none">
                                    Trang chủ <i class="ti-arrow-right mx-2"></i>
                                </a>
                            </li>
                            <li class="active">
                                <a href="javascript:void(0);" class="text-decoration-none text-muted">
                                    Hồ sơ cá nhân
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- User Profile Section -->
    <section class="user-profile section py-4">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3">
                    <!-- Profile Card -->
                    <div class="card profile-card mb-4 shadow-sm">
                        <div class="card-body p-4 text-center">
                            <div
                                style="width: 150px; height: 150px; margin: 0 auto; overflow: hidden; border-radius: 50%; position: relative;">
                                <img src="{{ $user->photo ? asset($user->photo) : 'https://via.placeholder.com/150' }}"
                                    alt="User Avatar" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                            </div>
                            <h3 class="profile-name">{{ $user->name }}</h3>
                            <p class="profile-role mb-2">{{ ucfirst($user->role) }}</p>
                            <span class="status-badge {{ $user->status ? 'status-active' : 'status-inactive' }}">
                                {{ $user->status ? 'Đang hoạt động' : 'Tài khoản bị khóa' }}
                            </span>
                        </div>
                    </div>

                    <!-- Navigation Menu -->
                    <div class="card shadow-sm">
                        <div class="list-group list-group-flush rounded-3">
                            <a href="#" class="list-group-item list-group-item-action active py-3">
                                <i class="fas fa-user-circle fs-5 me-2"></i> Thông tin cá nhân
                            </a>
                            <a href="#" class="list-group-item list-group-item-action py-3">
                                <i class="fas fa-key fs-5 me-2"></i> Đổi mật khẩu
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <!-- User Info Card -->
                    <div class="card shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                            <h5 class="card-title fw-bold mb-0">Thông tin cá nhân</h5>
                            <div class="card-actions">
                                <button class="btn btn-sm btn-primary me-2" id="edit-info-btn">
                                    <i class="fas fa-edit fs-5 me-1"></i> Chỉnh sửa
                                </button>
                                <button class="btn btn-sm btn-light">
                                    <i class="fas fa-sync-alt fs-5"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="info-field">
                                        <label class="info-label">
                                            <i class="fas fa-envelope text-primary fa-lg me-2"></i> Email
                                        </label>
                                        <p class="info-value">{{ $user->email }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <div class="info-field">
                                        <label class="info-label">
                                            <i class="fas fa-phone text-primary fa-lg me-2"></i> Số điện thoại
                                        </label>
                                        <p class="info-value">{{ $user->phone ?: 'Chưa cập nhật' }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <div class="info-field">
                                        <label class="info-label">
                                            <i class="fas fa-map-marker-alt text-primary fa-lg me-2"></i> Địa chỉ
                                        </label>
                                        <p class="info-value">{{ $user->address ?: 'Chưa cập nhật' }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <div class="info-field">
                                        <label class="info-label">
                                            <i class="fas fa-city text-primary fa-lg me-2"></i> Tỉnh/Thành phố
                                        </label>
                                        <p class="info-value">{{ $user->province ?: 'Chưa cập nhật' }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <div class="info-field">
                                        <label class="info-label">
                                            <i class="fas fa-calendar-alt text-primary fa-lg me-2"></i> Ngày đăng ký
                                        </label>
                                        <p class="info-value">
                                            {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End User Profile Section -->

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Chỉnh sửa thông tin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="updateProfileForm" action="{{ route('profile.update', $user->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <div class="position-relative">
                                    <img id="preview-photo"
                                        src="{{ $user->photo ? asset($user->photo) : 'https://via.placeholder.com/150' }}"
                                        class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                                    <div class="upload-btn-wrapper">
                                        <button class="btn btn-sm btn-light position-absolute bottom-0 end-0">
                                            <i class="fas fa-camera"></i>
                                        </button>
                                        <input type="file" name="photo" id="photo"
                                            onchange="previewImage(this)">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" name="name" id="name"
                                value="{{ $user->name }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" name="phone" id="phone"
                                value="{{ $user->phone }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control" name="address" id="address"
                                value="{{ $user->address }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tỉnh/Thành phố</label>
                            <input type="text" class="form-control" name="province" id="province"
                                value="{{ $user->province }}">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var editModal = new bootstrap.Modal(document.getElementById('editProfileModal'));

            // Khi nhấn vào nút "Chỉnh sửa"
            document.getElementById('edit-info-btn').addEventListener('click', function() {
                editModal.show();
            });
        });

        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('preview-photo').setAttribute('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
