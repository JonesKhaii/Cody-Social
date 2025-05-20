{{-- Thêm bài viết --}}
<div id="add-post-modal" class="modal">
    <div class="modal-content modal-lg">
        <span class="close" id="close-add-post-modal">&times;</span>
        <h2>Thêm bài viết mới</h2>
        <form id="add-post-form" method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Tiêu đề <span class="text-danger">*</span></label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="post_type">Loại bài viết <span class="text-danger">*</span></label>
                <select id="post_type" name="post_type" class="form-control" required>
                    <option value="post">Bài viết thông thường</option>
                    <option value="event">Sự kiện</option>
                    <option value="story">Câu chuyện</option>
                    <option value="research">Nghiên cứu</option>
                    <option value="video">Video</option>
                </select>
            </div>

            <div class="form-group">
                <label for="post_cat_id">Danh mục bài viết <span class="text-danger">*</span></label>
                <div class="category-search-container">
                    <input type="text" id="category_search" class="form-control" placeholder="Tìm kiếm danh mục..."
                        autocomplete="off">
                    <div class="category-dropdown" id="category_dropdown" style="display: none;">
                        <ul class="category-list">
                            @foreach ($categories as $category)
                                <li class="category-item" data-id="{{ $category->id }}"
                                    data-name="{{ $category->name }}">
                                    {{ $category->name }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <input type="hidden" id="post_cat_id" name="post_cat_id" required>
                    <div id="selected_category" class="selected-category" style="display: none;">
                        <span id="selected_category_name"></span>
                        <button type="button" id="clear_category" class="clear-btn">&times;</button>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="summary">Tóm tắt <span class="text-danger">*</span></label>
                <textarea id="summary" name="summary" class="form-control" required rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="description">Nội dung <span class="text-danger">*</span></label>
                <textarea id="description" name="description" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="tags">Thẻ gắn (cách nhau bởi dấu phẩy)</label>
                <input type="text" id="tags" name="tags" class="form-control"
                    placeholder="Ví dụ: y học, sức khỏe, dinh dưỡng">
            </div>

            <div class="form-group">
                <label for="quote">Trích dẫn nổi bật</label>
                <textarea id="quote" name="quote" class="form-control"
                    placeholder="Nhập câu trích dẫn nổi bật từ bài viết (nếu có)" rows="2"></textarea>
            </div>

            <!-- Phần meta_data cho Event -->
            <div id="event_meta" class="meta-fields" style="display: none;">
                <h4 class="mb-3 mt-4">Thông tin sự kiện</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="event_start_date">Ngày bắt đầu <span class="text-danger">*</span></label>
                            <input type="datetime-local" id="event_start_date" name="meta_data[event_start_date]"
                                class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="event_end_date">Ngày kết thúc <span class="text-danger">*</span></label>
                            <input type="datetime-local" id="event_end_date" name="meta_data[event_end_date]"
                                class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Hình thức tổ chức</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="meta_data[is_online]"
                            id="offline_event" value="false" checked>
                        <label class="form-check-label" for="offline_event">Sự kiện offline</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="meta_data[is_online]" id="online_event"
                            value="true">
                        <label class="form-check-label" for="online_event">Sự kiện online</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="event_location">Địa điểm <span class="text-danger">*</span></label>
                    <input type="text" id="event_location" name="meta_data[location]" class="form-control">
                </div>

                <div class="form-group">
                    <label for="event_speaker">Diễn giả</label>
                    <input type="text" id="event_speaker" name="meta_data[speaker]" class="form-control">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="max_attendees">Số người tham dự tối đa</label>
                            <input type="number" id="max_attendees" name="meta_data[max_attendees]"
                                class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="registration_deadline">Hạn đăng ký</label>
                            <input type="date" id="registration_deadline" name="meta_data[registration_deadline]"
                                class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Phần meta_data cho Research -->
            <div id="research_meta" class="meta-fields" style="display: none;">
                <h4 class="mb-3 mt-4">Thông tin nghiên cứu</h4>

                <div class="form-group">
                    <label for="publish_date">Ngày xuất bản</label>
                    <input type="date" id="publish_date" name="meta_data[publish_date]" class="form-control">
                </div>

                <div class="form-group">
                    <label for="journal">Tạp chí đăng</label>
                    <input type="text" id="journal" name="meta_data[journal]" class="form-control">
                </div>

                <div class="form-group">
                    <label for="doi">DOI (Digital Object Identifier)</label>
                    <input type="text" id="doi" name="meta_data[doi]" class="form-control"
                        placeholder="Ví dụ: 10.5555/vjm.2024.09.003">
                </div>

                <div class="form-group">
                    <label for="co_authors">Đồng tác giả (mỗi người một dòng)</label>
                    <textarea id="co_authors" name="co_authors" class="form-control" placeholder="Nhập mỗi tác giả một dòng"
                        rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="document_file">Tải lên tài liệu nghiên cứu (PDF)</label>
                    <input type="file" id="document_file" name="document_file" class="form-control"
                        accept=".pdf">
                </div>
            </div>

            <!-- Phần meta_data cho Video -->
            <div id="video_meta" class="meta-fields" style="display: none;">
                <h4 class="mb-3 mt-4">Thông tin video</h4>

                <div class="form-group">
                    <label for="video_url">URL Video (YouTube, Vimeo...) <span class="text-danger">*</span></label>
                    <input type="url" id="video_url" name="meta_data[video_url]" class="form-control"
                        placeholder="Ví dụ: https://www.youtube.com/watch?v=example">
                </div>

                <div class="form-group">
                    <label for="duration">Thời lượng</label>
                    <input type="text" id="duration" name="meta_data[duration]" class="form-control"
                        placeholder="Ví dụ: 22:18">
                </div>

                <div class="form-group">
                    <label for="video_topics">Chủ đề (cách nhau bởi dấu phẩy)</label>
                    <input type="text" id="video_topics" name="video_topics" class="form-control"
                        placeholder="Ví dụ: cấp cứu, kỹ thuật, vết thương">
                </div>

                <div class="form-group">
                    <label for="audience">Đối tượng hướng đến</label>
                    <select id="audience" name="meta_data[audience]" class="form-control">
                        <option value="">-- Chọn đối tượng --</option>
                        <option value="medical">Nhân viên y tế</option>
                        <option value="patient">Bệnh nhân</option>
                        <option value="public">Cộng đồng</option>
                        <option value="student">Sinh viên y khoa</option>
                    </select>
                </div>
            </div>


            <!-- Phần liên kết bệnh viện/phòng khám (cho phương pháp điều trị) -->
            <div id="treatment_clinics" class="meta-fields" style="display: none;">
                <h4 class="mb-3 mt-4">Bệnh viện/Phòng khám cung cấp phương pháp này</h4>

                <div class="form-group">
                    <label>Tìm kiếm và chọn bệnh viện/phòng khám</label>
                    <div class="clinic-search-container">
                        <input type="text" id="clinic_search" class="form-control"
                            placeholder="Tìm kiếm bệnh viện/phòng khám..." autocomplete="off">
                        <div class="clinic-dropdown" id="clinic_dropdown" style="display: none;">
                            <ul class="clinic-list" id="clinic_list">
                                <!-- Danh sách bệnh viện sẽ được điền vào đây bằng JavaScript -->
                            </ul>
                        </div>
                    </div>

                    <div id="selected_clinics" class="selected-clinics mt-3">
                        <!-- Các bệnh viện đã chọn sẽ hiển thị ở đây -->
                    </div>

                    <!-- Input ẩn để lưu trữ ID của các bệnh viện đã chọn -->
                    <input type="hidden" id="clinic_ids" name="clinic_ids" value="">
                </div>
            </div>

            <!-- Phần ảnh bài viết -->
            <div class="form-group">
                <label>Ảnh bài viết <span class="text-danger">*</span></label>
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

            <div class="modal-footer mt-4">
                <button type="button" class="btn btn-secondary" id="cancel-add-post">Hủy</button>
                <button type="submit" class="btn btn-primary">Đăng bài</button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Styles cho modal lớn hơn */
    .modal-lg {
        max-width: 90%;
        width: 1000px;
    }

    /* Styles cho tìm kiếm danh mục */
    .category-search-container {
        position: relative;
    }

    .category-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 0 0 4px 4px;
        max-height: 300px;
        overflow-y: auto;
        z-index: 1000;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .category-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .category-item {
        padding: 10px 15px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
        transition: background-color 0.2s;
    }

    .category-item:hover {
        background-color: #f5f8ff;
    }

    .category-item.active {
        background-color: #e3f2fd;
    }

    .category-item:last-child {
        border-bottom: none;
    }

    .selected-category {
        margin-top: 10px;
        padding: 8px 12px;
        background-color: #f0f7ff;
        border: 1px solid #cce5ff;
        border-radius: 4px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .clear-btn {
        background: none;
        border: none;
        color: #999;
        font-size: 18px;
        cursor: pointer;
        padding: 0 5px;
    }

    .clear-btn:hover {
        color: #f44336;
    }

    .highlight {
        background-color: #e6f2ff;
    }

    /* Meta fields styling */
    .meta-fields {
        background-color: #f9f9f9;
        padding: 15px;
        margin-top: 15px;
        border: 1px solid #eee;
        border-radius: 5px;
    }

    .meta-fields h4 {
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
        margin-bottom: 15px;
        color: #333;
    }

    .clinic-search-container {
        position: relative;
        margin-bottom: 15px;
    }

    .clinic-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 0 0 4px 4px;
        max-height: 300px;
        overflow-y: auto;
        z-index: 1000;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .clinic-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .clinic-item {
        padding: 10px 15px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
        transition: background-color 0.2s;
    }

    .clinic-item:hover {
        background-color: #f5f8ff;
    }

    .clinic-item.active {
        background-color: #e3f2fd;
    }

    .clinic-item:last-child {
        border-bottom: none;
    }

    .selected-clinics {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 15px;
    }

    .selected-clinic-tag {
        display: inline-flex;
        align-items: center;
        background-color: #f0f7ff;
        border: 1px solid #cce5ff;
        border-radius: 4px;
        padding: 5px 10px;
        font-size: 14px;
    }

    .remove-clinic {
        background: none;
        border: none;
        color: #999;
        font-size: 16px;
        cursor: pointer;
        margin-left: 5px;
        padding: 0;
    }

    .remove-clinic:hover {
        color: #f44336;
    }

    .clinic-item-info {
        display: flex;
        flex-direction: column;
    }

    .clinic-item-name {
        font-weight: 500;
    }

    .clinic-item-address {
        font-size: 12px;
        color: #666;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('#description').removeAttribute('required');
        ClassicEditor
            .create(document.querySelector('#description'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                    'outdent', 'indent', '|', 'imageUpload', 'blockQuote', 'insertTable', 'mediaEmbed',
                    'undo', 'redo'
                ]
            })
            .then(editor => {
                // Lưu instance editor để sử dụng sau này
                window.editor = editor;
            })
            .catch(error => {
                console.error('Lỗi khởi tạo CKEditor:', error);
            });

        // Xử lý tùy chọn hình ảnh
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

        // Xử lý hiển thị các trường meta_data dựa trên post_type
        const postTypeSelect = document.getElementById('post_type');
        const metaFields = document.querySelectorAll('.meta-fields');

        postTypeSelect.addEventListener('change', function() {
            // Ẩn tất cả các trường meta
            metaFields.forEach(field => {
                field.style.display = 'none';

                // Bỏ required cho tất cả các trường trong meta_fields
                const requiredFields = field.querySelectorAll('[required]');
                requiredFields.forEach(reqField => {
                    reqField.removeAttribute('required');
                });
            });

            // Hiển thị trường meta phù hợp với loại bài viết
            const selectedType = this.value;
            if (selectedType === 'event') {
                document.getElementById('event_meta').style.display = 'block';
                document.getElementById('event_start_date').setAttribute('required', '');
                document.getElementById('event_end_date').setAttribute('required', '');
                document.getElementById('event_location').setAttribute('required', '');
            } else if (selectedType === 'research') {
                document.getElementById('research_meta').style.display = 'block';
            } else if (selectedType === 'video') {
                document.getElementById('video_meta').style.display = 'block';
                document.getElementById('video_url').setAttribute('required', '');
            }
        });

        // Xử lý real-time search cho danh mục
        const categorySearch = document.getElementById('category_search');
        const categoryDropdown = document.getElementById('category_dropdown');
        const categoryItems = document.querySelectorAll('.category-item');
        const selectedCategory = document.getElementById('selected_category');
        const selectedCategoryName = document.getElementById('selected_category_name');
        const clearCategoryBtn = document.getElementById('clear_category');
        const postCatIdInput = document.getElementById('post_cat_id');

        let highlightedIndex = -1;

        // Hiển thị dropdown khi focus vào ô tìm kiếm
        categorySearch.addEventListener('focus', function() {
            categoryDropdown.style.display = 'block';
            filterCategories('');
        });

        // Đóng dropdown khi click ra ngoài
        document.addEventListener('click', function(e) {
            if (!categorySearch.contains(e.target) && !categoryDropdown.contains(e.target)) {
                categoryDropdown.style.display = 'none';
            }
        });

        // Xử lý tìm kiếm real-time
        categorySearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            highlightedIndex = -1;
            filterCategories(searchTerm);
        });

        // Xử lý phím di chuyển trong dropdown
        categorySearch.addEventListener('keydown', function(e) {
            const visibleItems = Array.from(categoryItems).filter(item =>
                item.style.display !== 'none');

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                highlightedIndex = Math.min(highlightedIndex + 1, visibleItems.length - 1);
                updateHighlight(visibleItems);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                highlightedIndex = Math.max(highlightedIndex - 1, 0);
                updateHighlight(visibleItems);
            } else if (e.key === 'Enter' && highlightedIndex >= 0) {
                e.preventDefault();
                visibleItems[highlightedIndex].click();
            } else if (e.key === 'Escape') {
                categoryDropdown.style.display = 'none';
            }
        });

        // Xử lý chọn danh mục
        categoryItems.forEach(item => {
            if (item.dataset && item.dataset.id && item.dataset.name) {
                item.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;

                    postCatIdInput.value = id;
                    selectedCategoryName.textContent = name;
                    selectedCategory.style.display = 'flex';
                    categorySearch.value = '';
                    categorySearch.style.display = 'none';
                    categoryDropdown.style.display = 'none';
                });
            }
        });

        // Xử lý xóa danh mục đã chọn
        clearCategoryBtn.addEventListener('click', function() {
            postCatIdInput.value = '';
            selectedCategory.style.display = 'none';
            categorySearch.style.display = 'block';
            categorySearch.focus();
        });

        // Hàm lọc danh mục theo từ khóa
        function filterCategories(searchTerm) {
            let hasResults = false;

            categoryItems.forEach(item => {
                // Kiểm tra item có dataset và name hợp lệ
                if (!item.dataset || !item.dataset.name) return;

                const name = item.dataset.name.toLowerCase();

                if (name.includes(searchTerm)) {
                    item.style.display = 'block';
                    if (searchTerm) {
                        try {
                            const regex = new RegExp(
                                `(${searchTerm.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&')})`, 'gi');
                            const highlightedText = item.dataset.name.replace(
                                regex,
                                '<span class="highlight">$1</span>'
                            );
                            item.innerHTML = highlightedText;
                        } catch (e) {
                            item.textContent = item.dataset.name;
                        }
                    } else {
                        item.textContent = item.dataset.name;
                    }
                    hasResults = true;
                } else {
                    item.style.display = 'none';
                }
            });

            if (!hasResults) {
                let noResults = document.getElementById('no_results');
                if (!noResults) {
                    noResults = document.createElement('li');
                    noResults.id = 'no_results';
                    noResults.className = 'category-item';
                    noResults.style.fontStyle = 'italic';
                    noResults.style.color = '#999';
                    const dropdownList = categoryDropdown.querySelector('ul');
                    if (dropdownList) {
                        dropdownList.appendChild(noResults);
                    }
                }
                if (noResults) {
                    noResults.textContent = 'Không tìm thấy danh mục phù hợp';
                    noResults.style.display = 'block';
                }
            } else {
                const noResults = document.getElementById('no_results');
                if (noResults) {
                    noResults.style.display = 'none';
                }
            }
        }

        // Cập nhật hiển thị item được highlight
        function updateHighlight(visibleItems) {
            visibleItems.forEach((item, index) => {
                if (index === highlightedIndex) {
                    item.classList.add('active');
                    item.scrollIntoView({
                        block: 'nearest'
                    });
                } else {
                    item.classList.remove('active');
                }
            });
        }

        // Xử lý submit form với validation cho CKEditor
        document.getElementById('add-post-form').addEventListener('submit', function(e) {
            // Kiểm tra nội dung editor
            if (window.editor) {
                const editorContent = window.editor.getData().trim();
                if (!editorContent) {
                    e.preventDefault();
                    alert('Vui lòng nhập nội dung bài viết');
                    return false;
                }

                // Đồng bộ nội dung vào textarea gốc
                document.querySelector('#description').value = editorContent;
            }

            // Chuyển co-authors từ nhiều dòng thành mảng
            const coAuthorsField = document.getElementById('co_authors');
            if (coAuthorsField && coAuthorsField.value) {
                const coAuthorsArray = coAuthorsField.value.split('\n')
                    .map(author => author.trim())
                    .filter(author => author !== '');

                // Tạo input ẩn để gửi đi
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'meta_data[co_authors]';
                hiddenInput.value = JSON.stringify(coAuthorsArray);
                this.appendChild(hiddenInput);
            }

            // Chuyển video topics từ chuỗi phân cách bằng dấu phẩy thành mảng
            const videoTopicsField = document.getElementById('video_topics');
            if (videoTopicsField && videoTopicsField.value) {
                const topicsArray = videoTopicsField.value.split(',')
                    .map(topic => topic.trim())
                    .filter(topic => topic !== '');

                // Tạo input ẩn để gửi đi
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'meta_data[topics]';
                hiddenInput.value = JSON.stringify(topicsArray);
                this.appendChild(hiddenInput);
            }
        });

        // Modal control
        const addPostModal = document.getElementById('add-post-modal');
        const closeBtn = document.getElementById('close-add-post-modal');
        const cancelBtn = document.getElementById('cancel-add-post');

        // document.getElementById('open-add-post-modal').addEventListener('click', function() {
        //     addPostModal.style.display = 'block';
        // });

        closeBtn.addEventListener('click', function() {
            addPostModal.style.display = 'none';
        });

        cancelBtn.addEventListener('click', function() {
            addPostModal.style.display = 'none';
        });

        window.addEventListener('click', function(e) {
            if (e.target === addPostModal) {
                addPostModal.style.display = 'none';
            }
        });





        // Xử lý hiển thị phần chọn bệnh viện khi chọn danh mục phương pháp điều trị
        // const postCatIdInput = document.getElementById('post_cat_id');
        const treatmentClinics = document.getElementById('treatment_clinics');

        // Mảng danh mục phương pháp điều trị (ID 88-100)
        const treatmentCategoryIds = Array.from({
            length: 13
        }, (_, i) => 88 + i);

        function checkIfTreatmentCategory() {
            if (postCatIdInput && treatmentClinics) {
                const categoryId = parseInt(postCatIdInput.value);
                if (treatmentCategoryIds.includes(categoryId)) {
                    treatmentClinics.style.display = 'block';
                } else {
                    treatmentClinics.style.display = 'none';
                }
            }
        }

        // Danh sách bệnh viện (sẽ được lấy từ API)
        let allClinics = [];
        let selectedClinics = [];

        // Lấy danh sách bệnh viện từ API khi trang tải xong
        fetch('/api/clinics/list')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                // console.log('Dữ liệu bệnh viện:', data);
                allClinics = data;
            })
            .catch(error => {
                console.error('Lỗi khi lấy danh sách bệnh viện:', error);
                // Hiển thị thông báo lỗi cho người dùng
                alert('Không thể tải danh sách bệnh viện. Vui lòng thử lại sau.');
            });

        // Xử lý real-time search cho bệnh viện
        const clinicSearch = document.getElementById('clinic_search');
        const clinicDropdown = document.getElementById('clinic_dropdown');
        const clinicList = document.getElementById('clinic_list');
        const selectedClinicsContainer = document.getElementById('selected_clinics');
        const clinicIdsInput = document.getElementById('clinic_ids');

        let clinicHighlightedIndex = -1;

        if (clinicSearch) {
            // Hiển thị dropdown khi focus vào ô tìm kiếm
            clinicSearch.addEventListener('focus', function() {
                clinicDropdown.style.display = 'block';
                renderClinicList('');
            });

            // Đóng dropdown khi click ra ngoài
            document.addEventListener('click', function(e) {
                if (!clinicSearch.contains(e.target) && !clinicDropdown.contains(e.target)) {
                    clinicDropdown.style.display = 'none';
                }
            });

            // Xử lý tìm kiếm real-time
            clinicSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                clinicHighlightedIndex = -1;
                renderClinicList(searchTerm);
            });

            // Xử lý phím di chuyển trong dropdown
            clinicSearch.addEventListener('keydown', function(e) {
                const visibleItems = document.querySelectorAll(
                    '.clinic-item:not([style*="display: none"])');

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    clinicHighlightedIndex = Math.min(clinicHighlightedIndex + 1, visibleItems.length -
                        1);
                    updateClinicHighlight(visibleItems);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    clinicHighlightedIndex = Math.max(clinicHighlightedIndex - 1, 0);
                    updateClinicHighlight(visibleItems);
                } else if (e.key === 'Enter' && clinicHighlightedIndex >= 0) {
                    e.preventDefault();
                    visibleItems[clinicHighlightedIndex].click();
                } else if (e.key === 'Escape') {
                    clinicDropdown.style.display = 'none';
                }
            });
        }

        // Hàm render danh sách bệnh viện theo từ khóa tìm kiếm
        function renderClinicList(searchTerm) {
            // Xóa danh sách hiện tại
            clinicList.innerHTML = '';

            // Lọc bệnh viện theo từ khóa
            const filteredClinics = allClinics.filter(clinic => {
                const alreadySelected = selectedClinics.some(sc => sc.id === clinic.id);
                if (alreadySelected) return false;

                return clinic.name.toLowerCase().includes(searchTerm) ||
                    (clinic.address && clinic.address.toLowerCase().includes(searchTerm));
            });

            if (filteredClinics.length === 0) {
                const noResults = document.createElement('li');
                noResults.id = 'no_clinic_results';
                noResults.className = 'clinic-item';
                noResults.style.fontStyle = 'italic';
                noResults.style.color = '#999';
                noResults.textContent = 'Không tìm thấy bệnh viện/phòng khám phù hợp';
                clinicList.appendChild(noResults);
            } else {
                filteredClinics.forEach(clinic => {
                    const item = document.createElement('li');
                    item.className = 'clinic-item';
                    item.dataset.id = clinic.id;

                    const infoDiv = document.createElement('div');
                    infoDiv.className = 'clinic-item-info';

                    const nameSpan = document.createElement('span');
                    nameSpan.className = 'clinic-item-name';
                    nameSpan.textContent = clinic.name;
                    infoDiv.appendChild(nameSpan);

                    if (clinic.address) {
                        const addressSpan = document.createElement('span');
                        addressSpan.className = 'clinic-item-address';
                        addressSpan.textContent = clinic.address;
                        infoDiv.appendChild(addressSpan);
                    }

                    item.appendChild(infoDiv);

                    // Xử lý highlight từ khóa tìm kiếm nếu có
                    if (searchTerm) {
                        try {
                            const regex = new RegExp(
                                `(${searchTerm.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&')})`, 'gi');
                            nameSpan.innerHTML = clinic.name.replace(regex,
                                '<span class="highlight">$1</span>');
                            if (clinic.address) {
                                addressSpan.innerHTML = clinic.address.replace(regex,
                                    '<span class="highlight">$1</span>');
                            }
                        } catch (e) {
                            // Do nothing, keep the original text
                        }
                    }

                    // Xử lý khi click vào item
                    item.addEventListener('click', function() {
                        addClinic(clinic);
                        clinicSearch.value = '';
                        renderClinicList('');
                    });

                    clinicList.appendChild(item);
                });
            }
        }

        // Cập nhật hiển thị item được highlight
        function updateClinicHighlight(visibleItems) {
            visibleItems.forEach((item, index) => {
                if (index === clinicHighlightedIndex) {
                    item.classList.add('active');
                    item.scrollIntoView({
                        block: 'nearest'
                    });
                } else {
                    item.classList.remove('active');
                }
            });
        }

        // Thêm bệnh viện vào danh sách đã chọn
        function addClinic(clinic) {
            if (!selectedClinics.some(c => c.id === clinic.id)) {
                selectedClinics.push(clinic);
                updateSelectedClinics();
            }
        }

        // Xóa bệnh viện khỏi danh sách đã chọn
        function removeClinic(clinicId) {
            selectedClinics = selectedClinics.filter(c => c.id !== clinicId);
            updateSelectedClinics();
        }

        // Cập nhật hiển thị danh sách bệnh viện đã chọn
        function updateSelectedClinics() {
            // Xóa nội dung hiện tại
            selectedClinicsContainer.innerHTML = '';

            // Hiển thị các bệnh viện đã chọn
            selectedClinics.forEach(clinic => {
                const tag = document.createElement('div');
                tag.className = 'selected-clinic-tag';
                tag.dataset.id = clinic.id;

                const nameSpan = document.createElement('span');
                nameSpan.textContent = clinic.name;
                tag.appendChild(nameSpan);

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'remove-clinic';
                removeBtn.innerHTML = '&times;';
                removeBtn.addEventListener('click', function() {
                    removeClinic(clinic.id);
                });
                tag.appendChild(removeBtn);

                selectedClinicsContainer.appendChild(tag);
            });

            // Cập nhật giá trị cho input ẩn
            clinicIdsInput.value = selectedClinics.map(c => c.id).join(',');
        }

        // Kiểm tra danh mục khi thay đổi
        if (postCatIdInput) {
            postCatIdInput.addEventListener('change', checkIfTreatmentCategory);

            // Đồng thời kiểm tra khi chọn danh mục từ dropdown
            document.querySelectorAll('.category-item').forEach(item => {
                item.addEventListener('click', function() {
                    // Cho thời gian để cập nhật giá trị post_cat_id
                    setTimeout(checkIfTreatmentCategory, 100);
                });
            });

            // Kiểm tra ban đầu
            checkIfTreatmentCategory();
        }
    });
</script>
