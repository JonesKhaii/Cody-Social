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
            {{-- <div class="form-group">
                <label for="photo">Ảnh bài viết</label>
                <input type="file" name="photo" id="photo" class="form-control" accept="image/*" required>
            </div> --}}
            <div class="form-group">
                <label>Ảnh bài viết</label>
                <div class="mb-3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="image_option" id="image_upload"
                            value="upload" checked>
                        <label class="form-check-label" for="image_upload">Tải ảnh lên</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="image_option" id="image_link"
                            value="link">
                        <label class="form-check-label" for="image_link">Nhập link ảnh</label>
                    </div>
                </div>

                <div id="upload_option" class="mt-2">
                    <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
                </div>

                <div id="link_option" class="mt-2" style="display: none;">
                    <input type="text" name="photo_url" id="photo_url" class="form-control"
                        placeholder="Nhập URL của ảnh">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancel-add-post">Hủy</button>
                <button type="submit" class="btn btn-primary">Đăng bài</button>
            </div>
        </form>

    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadRadio = document.getElementById('image_upload');
        const linkRadio = document.getElementById('image_link');
        const uploadOption = document.getElementById('upload_option');
        const linkOption = document.getElementById('link_option');

        uploadRadio.addEventListener('change', function() {
            if (this.checked) {
                uploadOption.style.display = 'block';
                linkOption.style.display = 'none';
                document.getElementById('photo').setAttribute('required', '');
                document.getElementById('photo_url').removeAttribute('required');
            }
        });

        linkRadio.addEventListener('change', function() {
            if (this.checked) {
                uploadOption.style.display = 'none';
                linkOption.style.display = 'block';
                document.getElementById('photo').removeAttribute('required');
                document.getElementById('photo_url').setAttribute('required', '');
            }
        });
    });
</script>
