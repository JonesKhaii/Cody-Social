{{-- chỉnh sửa thông tin cá nhân --}}
<div id="edit-modal" class="modal">
    <div class="modal-content">
        <span class="close" id="close-modal">&times;</span>
        <h2>Chỉnh sửa thông tin cá nhân</h2>
        <form id="edit-form" method="POST" action="{{ route('doctor.update', $doctor->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Tên bác sĩ</label>
                <input type="text" id="name" name="name" class="form-control"
                    value="{{ $doctor->name }}">
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại</label>
                <input type="text" id="phone" name="phone" class="form-control"
                    value="{{ $doctor->phone }}">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control"
                    value="{{ $doctor->email }}">
            </div>
            <div class="form-group">
                <label for="workplace">Địa chỉ làm việc</label>
                <input type="text" id="workplace" name="workplace" class="form-control"
                    value="{{ $doctor->workplace }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancel-modal">Hủy</button>
                <button type="submit" class="btn btn-primary" style="text-align: center">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>

{{-- chỉnh sửa bài viết --}}
<div id="edit-post-modal" class="modal">
    <div class="modal-content">
        <span class="close" id="close-edit-post-modal">&times;</span>
        <h2>Chỉnh sửa bài viết</h2>
        <form id="edit-post-form" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit-post-id" name="post_id">

            <div class="form-group">
                <label for="edit-title">Tiêu đề</label>
                <input type="text" id="edit-title" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit-summary">Tóm tắt</label>
                <textarea id="edit-summary" name="summary" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="edit-description">Nội dung</label>
                <textarea id="edit-description" name="description" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="edit-post-cat-id">Danh mục bài viết</label>
                <select id="edit-post-cat-id" name="post_cat_id" class="form-control" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Xem trước ảnh hiện tại -->
            <div class="form-group">
                <label>Ảnh hiện tại</label>
                <br>
                <div class="image-preview-container">
                    <img id="edit-preview-image" src="" alt="Ảnh bài viết">
                </div>
            </div>

            <div class="form-group">
                <label>Cập nhật ảnh</label>
                <div class="mb-3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="edit_image_option" id="edit_keep_image"
                            value="keep" checked>
                        <label class="form-check-label" for="edit_keep_image">Giữ ảnh hiện tại</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="edit_image_option" id="edit_image_upload"
                            value="upload">
                        <label class="form-check-label" for="edit_image_upload">Tải ảnh mới</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="edit_image_option" id="edit_image_link"
                            value="link">
                        <label class="form-check-label" for="edit_image_link">Nhập link ảnh</label>
                    </div>
                </div>

                <div id="edit_upload_option" class="mt-2" style="display: none;">
                    <input type="file" id="edit-photo" name="photo" class="form-control" accept="image/*">
                </div>

                <div id="edit_link_option" class="mt-2" style="display: none;">
                    <input type="text" id="edit-photo_url" name="photo_url" class="form-control"
                        placeholder="Nhập URL của ảnh">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancel-edit-post">Hủy</button>
                <button type="submit" class="btn btn-primary">Cập nhật bài viết</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý tùy chọn ảnh cho form chỉnh sửa
        const keepImageRadio = document.getElementById('edit_keep_image');
        const editUploadRadio = document.getElementById('edit_image_upload');
        const editLinkRadio = document.getElementById('edit_image_link');
        const editUploadOption = document.getElementById('edit_upload_option');
        const editLinkOption = document.getElementById('edit_link_option');

        if (keepImageRadio && editUploadRadio && editLinkRadio) {
            keepImageRadio.addEventListener('change', function() {
                if (this.checked) {
                    editUploadOption.style.display = 'none';
                    editLinkOption.style.display = 'none';
                    document.getElementById('edit-photo').removeAttribute('required');
                    document.getElementById('edit-photo_url').removeAttribute('required');
                }
            });

            editUploadRadio.addEventListener('change', function() {
                if (this.checked) {
                    editUploadOption.style.display = 'block';
                    editLinkOption.style.display = 'none';
                    document.getElementById('edit-photo').setAttribute('required', '');
                    document.getElementById('edit-photo_url').removeAttribute('required');
                }
            });

            editLinkRadio.addEventListener('change', function() {
                if (this.checked) {
                    editUploadOption.style.display = 'none';
                    editLinkOption.style.display = 'block';
                    document.getElementById('edit-photo').removeAttribute('required');
                    document.getElementById('edit-photo_url').setAttribute('required', '');
                }
            });
        }
    });
</script>
