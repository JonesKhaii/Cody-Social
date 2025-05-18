@extends('layouts.master')

@section('main-content')
    <div class="forum-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="edit-post-container">
                        <!-- Breadcrumb -->
                        <div class="forum-breadcrumb">
                            <a href="{{ route('forum.index') }}">Diễn đàn</a>
                            <span class="separator">/</span>
                            <a href="{{ route('forum.category', $category->slug) }}">{{ $category->name }}</a>
                            <span class="separator">/</span>
                            <a
                                href="{{ route('forum.threads.show', [$category->slug, $thread->slug]) }}">{{ $thread->title }}</a>
                            <span class="separator">/</span>
                            <span class="current">Chỉnh sửa bình luận</span>
                        </div>

                        <!-- Edit Form -->
                        <div class="edit-form-container">
                            <h1 class="form-title">Chỉnh sửa bình luận</h1>

                            <form action="{{ route('forum.posts.update', [$category->slug, $thread->slug, $post->id]) }}"
                                method="POST" class="edit-post-form">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="content">Nội dung <span class="required">*</span></label>
                                    <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" rows="8"
                                        required>{{ old('content', $post->content) }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn-submit">Cập nhật</button>
                                    <a href="{{ route('forum.threads.show', [$category->slug, $thread->slug]) }}#post-{{ $post->id }}"
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
        .edit-post-container {
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
            min-height: 150px;
        }

        .invalid-feedback {
            display: block;
            color: #ea4335;
            font-size: 14px;
            margin-top: 5px;
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
            const form = document.querySelector('.edit-post-form');

            if (form) {
                form.addEventListener('submit', function(e) {
                    const content = document.getElementById('content').value.trim();

                    if (content === '') {
                        e.preventDefault();
                        alert('Vui lòng nhập nội dung bình luận!');
                        return false;
                    }

                    // Kiểm tra độ dài
                    if (content.length < 2) {
                        e.preventDefault();
                        alert('Nội dung phải có ít nhất 2 ký tự!');
                        return false;
                    }

                    return true;
                });
            }
        });
    </script>
@endpush
