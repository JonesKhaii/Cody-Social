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
