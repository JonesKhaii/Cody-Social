<div class="modal fade" id="createThreadModal" tabindex="-1" aria-labelledby="createThreadLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <form action="{{ route('forum.threads.store') }}" method="POST"
            class="modal-content create-thread-form">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="createThreadLabel">Tạo chủ đề mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>

            <div class="modal-body p-4">
                <div class="mb-3">
                    <label for="category_id">Danh mục <span class="text-danger">*</span></label>
                    <select id="category_id" name="category_id"
                        class="form-select @error('category_id') is-invalid @enderror" required>
                        <option value="">-- Chọn danh mục --</option>
                        @foreach ($forumCategories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="title">Tiêu đề <span class="text-danger">*</span></label>
                    <input type="text" id="title" name="title"
                        class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Tiêu đề ngắn gọn mô tả nội dung chủ đề của bạn.</div>
                </div>

                <div class="mb-3">
                    <label for="content">Nội dung <span class="text-danger">*</span></label>
                    <textarea id="content" name="content" rows="12" class="form-control @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">
                        <p>Viết nội dung chi tiết để mọi người hiểu rõ chủ đề của bạn.</p>
                    </div>
                </div>

                <div class="form-guidelines bg-light border-start border-primary mt-4 rounded border-4 p-3">
                    <h5 class="mb-3">Hướng dẫn đăng bài</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-primary me-2"></i>Chọn tiêu đề ngắn gọn, súc tích</li>
                        <li><i class="fas fa-check text-primary me-2"></i>Viết rõ ràng, đầy đủ nội dung</li>
                        <li><i class="fas fa-check text-primary me-2"></i>Nếu là bài thuốc, ghi rõ thành phần & cách
                            dùng</li>
                        <li><i class="fas fa-check text-primary me-2"></i>KHÔNG spam, không quảng cáo</li>
                        <li><i class="fas fa-check text-primary me-2"></i>Tôn trọng mọi người, ngôn từ lịch sự
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-1"></i> Đăng bài</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor
                .create(document.querySelector('#content'))
                .catch(error => {
                    console.error('CKEditor load lỗi:', error);
                });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.create-thread-form');
            if (!form) return;

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(form);
                const submitBtn = form.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Đang gửi...';

                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(async res => {
                        if (!res.ok) {
                            // Bắt lỗi response không thành công
                            const errorData = await res.json().catch(() => ({}));
                            console.error('Server returned error:', errorData);
                            alert(errorData?.message || '❌ Đăng bài thất bại (lỗi server)!');
                            throw new Error('Fetch failed');
                        }
                        return res.json();
                    })
                    .then(data => {
                        if (data.success) {
                            const modal = bootstrap.Modal.getInstance(document.getElementById(
                                'createThreadModal'));
                            modal.hide();
                            form.reset();
                            if (window.ClassicEditor) ClassicEditor.instances?.content?.setData('');

                            alert('✅ Chủ đề đã đăng!');
                            window.location.href =
                                `/forum/${data.thread.category_slug}/${data.thread.slug}`;
                        } else {
                            alert(data.message || '❌ Đăng bài không thành công.');
                        }
                    })
                    .catch(err => {
                        console.error('Lỗi fetch:', err);
                        alert('❌ Có lỗi xảy ra, kiểm tra console log để biết thêm.');
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-paper-plane me-1"></i> Đăng bài';
                    });
            });
        });
    </script>

</div>

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
@endpush
