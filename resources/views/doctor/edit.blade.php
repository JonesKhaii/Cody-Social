<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Khởi tạo CKEditor cho form chỉnh sửa
        if (document.querySelector('#edit-description')) {
            ClassicEditor
                .create(document.querySelector('#edit-description'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                        'outdent', 'indent', '|', 'imageUpload', 'blockQuote', 'insertTable',
                        'mediaEmbed',
                        'undo', 'redo'
                    ]
                })
                .then(editor => {
                    // Lưu instance editor để sử dụng sau này
                    window.editEditor = editor;
                })
                .catch(error => {
                    console.error('Lỗi khởi tạo CKEditor cho form chỉnh sửa:', error);
                });
        }

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

        // Xử lý hiển thị các trường meta_data dựa trên post_type trong form chỉnh sửa
        const editPostTypeSelect = document.getElementById('edit-post_type');
        const editMetaFields = document.querySelectorAll('#edit-post-modal .meta-fields');
        const editTreatmentClinics = document.getElementById('edit-treatment_clinics');

        if (editPostTypeSelect) {
            editPostTypeSelect.addEventListener('change', function() {
                // Ẩn tất cả các trường meta
                editMetaFields.forEach(field => {
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
                    document.getElementById('edit-event_meta').style.display = 'block';
                    document.getElementById('edit-event_start_date').setAttribute('required', '');
                    document.getElementById('edit-event_end_date').setAttribute('required', '');
                    document.getElementById('edit-event_location').setAttribute('required', '');
                } else if (selectedType === 'research') {
                    document.getElementById('edit-research_meta').style.display = 'block';
                } else if (selectedType === 'video') {
                    document.getElementById('edit-video_meta').style.display = 'block';
                    document.getElementById('edit-video_url').setAttribute('required', '');
                }

                // Kiểm tra nếu đây là danh mục phương pháp điều trị (ID 88-100)
                checkIfTreatmentCategory();
            });
        }

        // Xử lý tìm kiếm danh mục cho form chỉnh sửa
        const editCategorySearch = document.getElementById('edit-category_search');
        const editCategoryDropdown = document.getElementById('edit-category_dropdown');
        const editCategoryItems = document.querySelectorAll('#edit-category_dropdown .category-item');
        const editSelectedCategory = document.getElementById('edit-selected_category');
        const editSelectedCategoryName = document.getElementById('edit-selected_category_name');
        const editClearCategoryBtn = document.getElementById('edit-clear_category');
        const editPostCatIdInput = document.getElementById('edit-post_cat_id');

        let editHighlightedIndex = -1;

        // Hàm kiểm tra xem danh mục đã chọn có phải là danh mục phương pháp điều trị không
        function checkIfTreatmentCategory() {
            if (editPostCatIdInput && editTreatmentClinics) {
                const categoryId = parseInt(editPostCatIdInput.value);
                // Danh sách ID danh mục phương pháp điều trị (88-100)
                const treatmentCategoryIds = Array.from({
                    length: 13
                }, (_, i) => 88 + i);

                if (treatmentCategoryIds.includes(categoryId)) {
                    editTreatmentClinics.style.display = 'block';
                } else {
                    editTreatmentClinics.style.display = 'none';
                }
            }
        }

        if (editCategorySearch) {
            // Hiển thị dropdown khi focus vào ô tìm kiếm
            editCategorySearch.addEventListener('focus', function() {
                editCategoryDropdown.style.display = 'block';
                editFilterCategories('');
            });

            // Xử lý tìm kiếm real-time
            editCategorySearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                editHighlightedIndex = -1;
                editFilterCategories(searchTerm);
            });

            // Xử lý phím di chuyển trong dropdown
            editCategorySearch.addEventListener('keydown', function(e) {
                const visibleItems = Array.from(editCategoryItems).filter(item =>
                    item.style.display !== 'none');

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    editHighlightedIndex = Math.min(editHighlightedIndex + 1, visibleItems.length - 1);
                    editUpdateHighlight(visibleItems);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    editHighlightedIndex = Math.max(editHighlightedIndex - 1, 0);
                    editUpdateHighlight(visibleItems);
                } else if (e.key === 'Enter' && editHighlightedIndex >= 0) {
                    e.preventDefault();
                    visibleItems[editHighlightedIndex].click();
                } else if (e.key === 'Escape') {
                    editCategoryDropdown.style.display = 'none';
                }
            });

            // Đóng dropdown khi click ra ngoài
            document.addEventListener('click', function(e) {
                if (!editCategorySearch.contains(e.target) && !editCategoryDropdown.contains(e
                    .target)) {
                    editCategoryDropdown.style.display = 'none';
                }
            });
        }

        if (editCategoryItems) {
            // Xử lý chọn danh mục
            editCategoryItems.forEach(item => {
                if (item.dataset && item.dataset.id && item.dataset.name) {
                    item.addEventListener('click', function() {
                        const id = this.dataset.id;
                        const name = this.dataset.name;

                        editPostCatIdInput.value = id;
                        editSelectedCategoryName.textContent = name;
                        editSelectedCategory.style.display = 'flex';
                        editCategorySearch.value = '';
                        editCategorySearch.style.display = 'none';
                        editCategoryDropdown.style.display = 'none';

                        // Kiểm tra nếu đây là danh mục phương pháp điều trị
                        checkIfTreatmentCategory();
                    });
                }
            });
        }

        if (editClearCategoryBtn) {
            // Xử lý xóa danh mục đã chọn
            editClearCategoryBtn.addEventListener('click', function() {
                editPostCatIdInput.value = '';
                editSelectedCategory.style.display = 'none';
                editCategorySearch.style.display = 'block';
                editCategorySearch.focus();

                // Ẩn phần chọn phòng khám nếu có
                if (editTreatmentClinics) {
                    editTreatmentClinics.style.display = 'none';
                }
            });
        }

        // Hàm lọc danh mục theo từ khóa cho form chỉnh sửa
        function editFilterCategories(searchTerm) {
            let hasResults = false;

            editCategoryItems.forEach(item => {
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
                let noResults = document.getElementById('edit-no_results');
                if (!noResults) {
                    noResults = document.createElement('li');
                    noResults.id = 'edit-no_results';
                    noResults.className = 'category-item';
                    noResults.style.fontStyle = 'italic';
                    noResults.style.color = '#999';
                    const dropdownList = editCategoryDropdown.querySelector('ul');
                    if (dropdownList) {
                        dropdownList.appendChild(noResults);
                    }
                }
                if (noResults) {
                    noResults.textContent = 'Không tìm thấy danh mục phù hợp';
                    noResults.style.display = 'block';
                }
            } else {
                const noResults = document.getElementById('edit-no_results');
                if (noResults) {
                    noResults.style.display = 'none';
                }
            }
        }

        // Cập nhật hiển thị item được highlight cho form chỉnh sửa
        function editUpdateHighlight(visibleItems) {
            visibleItems.forEach((item, index) => {
                if (index === editHighlightedIndex) {
                    item.classList.add('active');
                    item.scrollIntoView({
                        block: 'nearest'
                    });
                } else {
                    item.classList.remove('active');
                }
            });
        }

        // Xử lý khi mở modal chỉnh sửa bài viết
        const editPostBtns = document.querySelectorAll('.edit-post-btn');
        if (editPostBtns) {
            editPostBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const postId = this.dataset.id;

                    // Lấy thông tin bài viết bằng AJAX
                    fetch(`/doctor/posts/${postId}/edit-data`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const post = data.post;

                                // Điền thông tin cơ bản
                                document.getElementById('edit-post-id').value = post.id;
                                document.getElementById('edit-title').value = post.title;
                                document.getElementById('edit-post_type').value = post
                                    .post_type;
                                document.getElementById('edit-summary').value = post
                                .summary;

                                // Điền thông tin editor
                                if (window.editEditor) {
                                    window.editEditor.setData(post.description);
                                } else {
                                    document.getElementById('edit-description').value = post
                                        .description;
                                }

                                // Điền thông tin tags và quote
                                document.getElementById('edit-tags').value = post.tags ||
                                '';
                                document.getElementById('edit-quote').value = post.quote ||
                                    '';

                                // Điền thông tin danh mục
                                document.getElementById('edit-post_cat_id').value = post
                                    .post_cat_id;

                                // Hiển thị tên danh mục đã chọn
                                if (post.cat_info) {
                                    document.getElementById('edit-selected_category_name')
                                        .textContent = post.cat_info.title;
                                    document.getElementById('edit-selected_category').style
                                        .display = 'flex';
                                    document.getElementById('edit-category_search').style
                                        .display = 'none';
                                }

                                // Hiển thị ảnh hiện tại
                                if (post.photo) {
                                    document.getElementById('edit-preview-image').src = post
                                        .photo;
                                    document.getElementById('edit-preview-image')
                                        .parentElement.style.display = 'block';
                                } else {
                                    document.getElementById('edit-preview-image')
                                        .parentElement.style.display = 'none';
                                }

                                // Reset các tùy chọn ảnh
                                document.getElementById('edit_keep_image').checked = true;
                                document.getElementById('edit_upload_option').style
                                    .display = 'none';
                                document.getElementById('edit_link_option').style.display =
                                    'none';

                                // Khởi tạo hiển thị meta fields dựa trên post_type
                                const editMetaFields = document.querySelectorAll(
                                    '#edit-post-modal .meta-fields');
                                editMetaFields.forEach(field => {
                                    field.style.display = 'none';

                                    // Bỏ required cho tất cả các trường trong meta_fields
                                    const requiredFields = field.querySelectorAll(
                                        '[required]');
                                    requiredFields.forEach(reqField => {
                                        reqField.removeAttribute(
                                        'required');
                                    });
                                });

                                // Hiển thị trường meta phù hợp với loại bài viết
                                switch (post.post_type) {
                                    case 'event':
                                        document.getElementById('edit-event_meta').style
                                            .display = 'block';

                                        // Điền dữ liệu meta cho event
                                        if (post.meta_data) {
                                            if (post.meta_data.event_start_date) {
                                                document.getElementById(
                                                        'edit-event_start_date').value =
                                                    post.meta_data.event_start_date.replace(
                                                        ' ', 'T');
                                            }
                                            if (post.meta_data.event_end_date) {
                                                document.getElementById(
                                                        'edit-event_end_date').value = post
                                                    .meta_data.event_end_date.replace(' ',
                                                        'T');
                                            }

                                            // Thiết lập hình thức tổ chức
                                            if (post.meta_data.is_online === true || post
                                                .meta_data.is_online === 'true') {
                                                document.getElementById('edit-online_event')
                                                    .checked = true;
                                            } else {
                                                document.getElementById(
                                                    'edit-offline_event').checked = true;
                                            }

                                            // Điền các trường khác
                                            document.getElementById('edit-event_location')
                                                .value = post.meta_data.location || '';
                                            document.getElementById('edit-event_speaker')
                                                .value = post.meta_data.speaker || '';
                                            document.getElementById('edit-max_attendees')
                                                .value = post.meta_data.max_attendees || '';
                                            document.getElementById(
                                                    'edit-registration_deadline').value =
                                                post.meta_data.registration_deadline || '';
                                        }

                                        // Đặt required fields
                                        document.getElementById('edit-event_start_date')
                                            .setAttribute('required', '');
                                        document.getElementById('edit-event_end_date')
                                            .setAttribute('required', '');
                                        document.getElementById('edit-event_location')
                                            .setAttribute('required', '');
                                        break;

                                    case 'research':
                                        document.getElementById('edit-research_meta').style
                                            .display = 'block';

                                        // Điền dữ liệu meta cho research
                                        if (post.meta_data) {
                                            document.getElementById('edit-publish_date')
                                                .value = post.meta_data.publish_date || '';
                                            document.getElementById('edit-journal').value =
                                                post.meta_data.journal || '';
                                            document.getElementById('edit-doi').value = post
                                                .meta_data.doi || '';

                                            // Điền danh sách đồng tác giả
                                            if (post.meta_data.co_authors) {
                                                let coAuthors;
                                                if (typeof post.meta_data.co_authors ===
                                                    'string') {
                                                    try {
                                                        coAuthors = JSON.parse(post
                                                            .meta_data.co_authors);
                                                    } catch (e) {
                                                        coAuthors = [post.meta_data
                                                            .co_authors
                                                        ];
                                                    }
                                                } else {
                                                    coAuthors = post.meta_data.co_authors;
                                                }
                                                document.getElementById('edit-co_authors')
                                                    .value = coAuthors.join('\n');
                                            }

                                            // Hiển thị tài liệu hiện tại nếu có
                                            if (post.meta_data.document_url) {
                                                document.getElementById('edit-document_url')
                                                    .href = post.meta_data.document_url;
                                                document.getElementById('edit-document_url')
                                                    .textContent = 'Xem tài liệu hiện tại';
                                                document.getElementById(
                                                        'edit-current-document').style
                                                    .display = 'block';
                                            } else {
                                                document.getElementById(
                                                        'edit-current-document').style
                                                    .display = 'none';
                                            }
                                        }
                                        break;

                                    case 'video':
                                        document.getElementById('edit-video_meta').style
                                            .display = 'block';

                                        // Điền dữ liệu meta cho video
                                        if (post.meta_data) {
                                            document.getElementById('edit-video_url')
                                                .value = post.meta_data.video_url || '';
                                            document.getElementById('edit-duration').value =
                                                post.meta_data.duration || '';

                                            // Điền chủ đề video
                                            if (post.meta_data.topics) {
                                                let topics;
                                                if (typeof post.meta_data.topics ===
                                                    'string') {
                                                    try {
                                                        topics = JSON.parse(post.meta_data
                                                            .topics);
                                                    } catch (e) {
                                                        topics = [post.meta_data.topics];
                                                    }
                                                } else {
                                                    topics = post.meta_data.topics;
                                                }
                                                document.getElementById('edit-video_topics')
                                                    .value = topics.join(', ');
                                            }

                                            // Thiết lập đối tượng
                                            if (post.meta_data.audience) {
                                                document.getElementById('edit-audience')
                                                    .value = post.meta_data.audience;
                                            }
                                        }

                                        // Đặt required fields
                                        document.getElementById('edit-video_url')
                                            .setAttribute('required', '');
                                        break;
                                }

                                // Kiểm tra xem có phải danh mục phương pháp điều trị không (ID 88-100)
                                const isTreatmentCategory = post.post_cat_id >= 88 && post
                                    .post_cat_id <= 100;
                                if (isTreatmentCategory) {
                                    document.getElementById('edit-treatment_clinics').style
                                        .display = 'block';

                                    // Điền danh sách bệnh viện đã chọn nếu có
                                    if (data.clinics && data.clinics.length > 0) {
                                        // Nếu bạn sử dụng Select2, cần khởi tạo ở đây
                                        if ($.fn.select2) {
                                            $('#edit-clinic_ids').select2({
                                                placeholder: 'Chọn bệnh viện/phòng khám...',
                                                allowClear: true,
                                                width: '100%'
                                            });
                                        }

                                        // Chọn các bệnh viện đã liên kết
                                        const selectedClinicIds = data.clinics.map(clinic =>
                                            clinic.id);
                                        $('#edit-clinic_ids').val(selectedClinicIds)
                                            .trigger('change');
                                    }
                                } else {
                                    document.getElementById('edit-treatment_clinics').style
                                        .display = 'none';
                                }

                                // Thiết lập action form
                                document.getElementById('edit-post-form').action =
                                    `/doctor/posts/${postId}`;

                                // Hiển thị modal
                                document.getElementById('edit-post-modal').style.display =
                                    'block';
                            } else {
                                alert(
                                    'Không thể lấy thông tin bài viết. Vui lòng thử lại sau.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
                        });
                });
            });
        }

        // Xử lý đóng modal chỉnh sửa bài viết
        const closeEditPostModal = document.getElementById('close-edit-post-modal');
        const cancelEditPost = document.getElementById('cancel-edit-post');
        const editPostModal = document.getElementById('edit-post-modal');

        if (closeEditPostModal) {
            closeEditPostModal.addEventListener('click', function() {
                editPostModal.style.display = 'none';
            });
        }

        if (cancelEditPost) {
            cancelEditPost.addEventListener('click', function() {
                editPostModal.style.display = 'none';
            });
        }

        // Đóng modal khi click bên ngoài
        window.addEventListener('click', function(e) {
            if (e.target === editPostModal) {
                editPostModal.style.display = 'none';
            }
        });

        // Xử lý submit form chỉnh sửa bài viết
        const editPostForm = document.getElementById('edit-post-form');
        if (editPostForm) {
            editPostForm.addEventListener('submit', function(e) {
                // Kiểm tra nội dung editor
                if (window.editEditor) {
                    const editorContent = window.editEditor.getData().trim();
                    if (!editorContent) {
                        e.preventDefault();
                        alert('Vui lòng nhập nội dung bài viết');
                        return false;
                    }

                    // Đồng bộ nội dung vào textarea gốc
                    document.querySelector('#edit-description').value = editorContent;
                }

                // Chuyển co-authors từ nhiều dòng thành mảng
                const coAuthorsField = document.getElementById('edit-co_authors');
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
                const videoTopicsField = document.getElementById('edit-video_topics');
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
        }
    });
</script>
