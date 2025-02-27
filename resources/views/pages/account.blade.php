@extends('layouts.master')

@section('title', 'Hồ Sơ Người Dùng')

@section('main-content')
    <div class="container mt-4">
        <!-- Hồ sơ người dùng -->
        <div class="card profile-card mb-4 p-4">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="{{ asset('asset/images/users/user1.jpeg') }}" class="profile-img rounded-circle"
                        alt="Người dùng" />
                </div>
                <div class="col-md-8">
                    <h3>{{ Auth::user()->name }}</h3>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Điện thoại:</strong> {{ Auth::user()->phone ?? 'Chưa cập nhật' }}</p>
                    <p><strong>Địa chỉ:</strong> {{ Auth::user()->address ?? 'Chưa cập nhật' }}</p>
                    <!-- Thêm các thông tin khác của người dùng nếu cần -->
                </div>
            </div>
        </div>

        <!-- Thống kê nhanh -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-card p-3 text-center shadow-sm">
                    <h4>{{ $posts->count() }}+</h4>
                    <p>Bài viết đã đăng</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card p-3 text-center shadow-sm">
                    <h4>4.8 ⭐</h4>
                    <p>Đánh giá trung bình</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card p-3 text-center shadow-sm">
                    <h4>{{ Auth::user()->followers_count ?? '0' }}+</h4>
                    <p>Người theo dõi</p>
                </div>
            </div>
        </div>

        <!-- Nút đăng bài -->
        <button id="togglePostForm" class="btn btn-primary mb-3">
            + Đăng bài viết
        </button>

        <!-- Form đăng bài viết (Ẩn mặc định) -->
        <div id="postArticleSection" class="card mb-4 p-4" style="display: none">
            <h3>Đăng bài viết mới</h3>
            <form id="postArticleForm" action="{{ route('post.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="articleTitle" class="form-label">Tiêu đề bài viết</label>
                    <input type="text" class="form-control" id="articleTitle" name="title" required />
                </div>
                <div class="mb-3">
                    <label for="articleCategory" class="form-label">Chuyên mục</label>
                    <select class="form-select" id="articleCategory" name="category_id">
                        <option>Sức khỏe tổng quát</option>
                        <option>Tim mạch</option>
                        <option>Dinh dưỡng</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="articleImage" class="form-label">Hình ảnh</label>
                    <input type="file" class="form-control" id="articleImage" name="image" />
                </div>
                <div class="mb-3">
                    <label for="articleContent" class="form-label">Nội dung</label>
                    <textarea class="form-control" id="articleContent" name="content" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Đăng bài viết</button>
            </form>
        </div>

        <!-- Danh sách bài viết của người dùng -->
        <h3 class="mb-3">Bài Viết Của Bạn</h3>
        <div class="row" id="UserArticles">
            @foreach ($posts as $post)
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <img src="{{ asset($post->image) }}" class="card-img-top" alt="{{ $post->title }}" />
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ Str::limit($post->content, 100) }}</p>
                            <button class="btn btn-primary w-100">Chỉnh sửa</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <footer class="footer bg-dark mt-4 p-3 text-center text-white">
        <p>© 2025 Cody Health. Tất cả quyền được bảo lưu.</p>
    </footer>

    <script src="{{ asset('asset/js/main.js') }}"></script>
@endsection
