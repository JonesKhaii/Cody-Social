@extends('layouts.master')

@section('main-content')
    <div class="forum-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="edit-thread-container">
                        <!-- Breadcrumb -->
                        <div class="forum-breadcrumb">
                            <a href="{{ route('forum.index') }}">Diễn đàn</a>
                            <span class="separator">/</span>
                            <a href="">{{ $category->name }}</a>
                            <span class="separator">/</span>
                            <a
                                href="{{ route('forum.threads.show', [$category->slug, $thread->slug]) }}">{{ $thread->title }}</a>
                            <span class="separator">/</span>
                            <span class="current">Chỉnh sửa</span>
                        </div>

                        <!-- Edit Form -->
                        <div class="edit-form-container">
                            <h1 class="form-title">Chỉnh sửa chủ đề</h1>

                            <form action="{{ route('forum.threads.update', [$category->slug, $thread->slug]) }}"
                                method="POST" class="edit-thread-form">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="title">Tiêu đề <span class="required">*</span></label>
                                    <input type="text" id="title" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title', $thread->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="content">Nội dung <span class="required">*</span></label>
                                    <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" rows="12"
                                        required>{{ old('content', $thread->content) }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if (auth()->user()->isAdmin())
                                    <div class="admin-options">
                                        <h3>Tùy chọn quản trị</h3>
                                        <div class="form-check">
                                            <input type="checkbox" id="is_sticky" name="is_sticky" class="form-check-input"
                                                {{ $thread->is_sticky ? 'checked' : '' }}>
                                            <label for="is_sticky" class="form-check-label">Ghim chủ đề này</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" id="is_locked" name="is_locked" class="form-check-input"
                                                {{ $thread->is_locked ? 'checked' : '' }}>
                                            <label for="is_locked" class="form-check-label">Khóa chủ đề này</label>
                                        </div>
                                    </div>
                                @endif

                                <div class="form-actions">
                                    <button type="submit" class="btn-submit">Cập nhật</button>
                                    <a href="{{ route('forum.threads.show', [$category->slug, $thread->slug]) }}"
                                        class="btn-cancel">Hủy</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Breadcrumb */
        .forum-breadcrumb {
            padding: 15px 20px;
            background: #f8f9fa;
            border-radius: 10px 10px 0 0;
            font-size: 14px;
        }

        .forum-breadcrumb a {
            color: #4285f4;
            text-decoration: none;
        }

        .forum-breadcrumb .separator {
            margin: 0 8px;
            color: #aaa;
        }

        .forum-breadcrumb .current {
            color: #666;
            font-weight: 500;
        }

        /* Edit Form Container */
        .edit-thread-container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .edit-form-container {
            padding: 20px;
        }

        .form-title {
            font-size: 24px;
            font-weight: 600;
            margin: 0 0 20px;
            color: #333;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }

        .required {
            color: #ea4335;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 15px;
            transition: all 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #4285f4;
            box-shadow: 0 0 0 2px rgba(66, 133, 244, 0.2);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 200px;
        }

        .invalid-feedback {
            display: block;
            color: #ea4335;
            font-size: 14px;
            margin-top: 5px;
        }

        /* Admin Options */
        .admin-options {
            background: #f8f9fa;
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 25px;
        }

        .admin-options h3 {
            font-size: 16px;
            margin: 0 0 15px;
            color: #333;
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .form-check:last-child {
            margin-bottom: 0;
        }

        .form-check-input {
            margin-right: 10px;
            width: 18px;
            height: 18px;
        }

        .form-check-label {
            font-weight: normal;
            margin-bottom: 0;
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-submit,
        .btn-cancel {
            padding: 12px 25px;
            border-radius: 5px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: all 0.3s;
        }

        .btn-submit {
            background: linear-gradient(135deg, #4285f4, #0d67db);
            color: white;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #3b78e7, #0c5ccc);
            box-shadow: 0 4px 10px rgba(13, 103, 219, 0.2);
            transform: translateY(-2px);
        }

        .btn-cancel {
            background: #f1f3f4;
            color: #5f6368;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-cancel:hover {
            background: #e8eaed;
            color: #202124;
            text-decoration: none;
        }

        @media (max-width: 767px) {
            .form-actions {
                flex-direction: column;
            }

            .btn-submit,
            .btn-cancel {
                width: 100%;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Thêm editor WYSIWYG nếu cần

            // Kiểm tra form trước khi submit
            const form = document.querySelector('.edit-thread-form');

            if (form) {
                form.addEventListener('submit', function(e) {
                    const title = document.getElementById('title').value.trim();
                    const content = document.getElementById('content').value.trim();

                    if (title === '') {
                        e.preventDefault();
                        alert('Vui lòng nhập tiêu đề cho chủ đề của bạn!');
                        return false;
                    }

                    if (content === '') {
                        e.preventDefault();
                        alert('Vui lòng nhập nội dung cho chủ đề của bạn!');
                        return false;
                    }

                    // Kiểm tra độ dài
                    if (title.length < 5) {
                        e.preventDefault();
                        alert('Tiêu đề phải có ít nhất 5 ký tự!');
                        return false;
                    }

                    if (content.length < 10) {
                        e.preventDefault();
                        alert('Nội dung phải có ít nhất 10 ký tự!');
                        return false;
                    }

                    return true;
                });
            }
        });
    </script>
@endpush
