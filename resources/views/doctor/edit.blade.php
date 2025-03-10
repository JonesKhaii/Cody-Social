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
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                <button type="button" class="btn btn-secondary" id="cancel-modal">Hủy</button>
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
                    <img id="edit-preview-image" src="{{ $post->photo }}?t={{ time() }}"
                        alt="Ảnh bài viết">
                </div>

            </div>

            <!-- Input chọn ảnh mới -->
            <div class="form-group">
                <label for="edit-photo">Chọn ảnh mới (nếu có)</label>
                <input type="file" id="edit-photo" name="photo" class="form-control" accept="image/*">
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Cập nhật bài viết</button>
                <button type="button" class="btn btn-secondary" id="cancel-edit-post">Hủy</button>
            </div>
        </form>
    </div>
</div>
