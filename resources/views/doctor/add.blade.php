{{-- Thêm bài viết --}}
<div id="add-post-modal" class="modal">
    <div class="modal-content">
        <span class="close" id="close-add-post-modal">&times;</span>
        <h2>Thêm bài viết mới</h2>
        <form id="add-post-form" method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Tiêu đề</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="summary">Tóm tắt</label>
                <textarea id="summary" name="summary" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="description">Nội dung</label>
                <textarea id="description" name="description" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="post_cat_id">Danh mục bài viết</label>
                <select id="post_cat_id" name="post_cat_id" class="form-control" required>
                    <option value="">-- Chọn danh mục --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="photo">Ảnh bài viết</label>
                <input type="file" name="photo" id="photo" class="form-control" accept="image/*" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Đăng bài</button>
                <button type="button" class="btn btn-secondary" id="cancel-add-post">Hủy</button>
            </div>
        </form>

    </div>
</div>
