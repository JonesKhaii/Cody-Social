$(document).ready(function () {
    loadArticles(false, window.screen.width);
});

// Biến đếm số trang để tải thêm bài viết
var countArticles = 1;

// Sự kiện khi nhấn nút "Tải thêm bài viết"
$("#PlusArticles").click(function () {
    countArticles += 1;
    loadArticles(false, window.screen.width);
});

// Sự kiện khi nhấn nút "Thu gọn bài viết"
$("#CollapseArticles").click(function () {
    countArticles = 1;
    loadArticles(true, window.screen.width);
    $("#CollapseArticles").hide(); // Ẩn nút "Thu gọn bài viết" sau khi reset danh sách
});

// Sự kiện thay đổi thể loại bài viết
$("#Genero").on('change', function () {
    countArticles = 1;
    loadArticles(true, window.screen.width);
});

// Sự kiện tìm kiếm bài viết
$('#Pesquisar').on('input', function () {
    countArticles = 1;
    loadArticles(true, window.screen.width);
});

// Hàm tải bài viết từ file JSON
function loadArticles(clearArticles, w_width) {
    if (clearArticles) {
        $("#Articles").empty();
        countArticles = 1; // Reset số trang khi tìm kiếm hoặc lọc thể loại
    }

    $.getJSON("asset/js/articles.json", function (data) {
        let selectedCategory = $("#Genero option:selected").text(); // Lấy thể loại được chọn

        // Nếu không phải "Tất cả", lọc bài viết theo thể loại
        if (selectedCategory !== "Tất cả") {
            data = data.filter(article => article.category === selectedCategory);
        }

        let startIndex = (countArticles - 1) * 6; // Lấy tiếp 6 bài mới khi tải thêm
        let articlesToShow = data.slice(startIndex, startIndex + 6);

        articlesToShow.forEach(article => {
            let articleHtml = `
                <div class="col-md-4">
                    <div class="card mb-3 shadow-sm mt-3">
                        <img src="${article.image}" class="card-img-top" alt="${article.title}">
                        <div class="card-body">
                            <h5 class="card-title">${article.title}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">${article.category}</h6>
                            <p class="card-text">${article.content.substring(0, 100)}...</p>
                            <p class="card-text"><small class="text-muted">Tác giả: ${article.author} - ${article.published_date}</small></p>
                            <a href="article-detail.html?id=${article.id}" class="btn btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            `;
            $("#Articles").append(articleHtml);
        });

        // Ẩn nút "Tải thêm bài viết" nếu không còn bài mới
        if (startIndex + 6 >= data.length) {
            $("#PlusArticles").hide();
        } else {
            $("#PlusArticles").show();
        }

        // Hiển thị nút "Thu gọn bài viết" nếu có nhiều bài viết
        if (countArticles > 1) {
            $("#CollapseArticles").show();
        } else {
            $("#CollapseArticles").hide();
        }
    }).fail(function () {
        console.error("Không thể tải dữ liệu từ articles.json");
    });
}

// Hàm xác định số cột hiển thị dựa trên kích thước màn hình
function getColumnSize(w_width) {
    if (w_width <= 768) return 12;  // 1 cột trên màn hình nhỏ
    if (w_width > 768 && w_width <= 990) return 6; // 2 cột trên màn hình trung bình
    return 4; // 3 cột trên màn hình lớn
}

// Hàm điều chỉnh bố cục khi thay đổi kích thước cửa sổ
function adjustLayout(width) {
    $('#Articles').children().each(function () {
        $(this).attr('class', `col-${getColumnSize(width)}`);
    });
}

// Tải danh sách tác giả
document.addEventListener("DOMContentLoaded", function () {
    loadPopularAuthors();
});

function loadPopularAuthors() {
    fetch("asset/js/authors.json")
        .then(response => response.json())
        .then(authors => {
            const authorsContainer = document.getElementById("PopularAuthors");
            authorsContainer.innerHTML = "";

            authors.forEach(author => {
                const authorCard = `
                    <div class="col-md-3">
                        <a href="doctor-profile.html?id=${author.id}" class="text-decoration-none text-dark">
                            <div class="card shadow-sm p-3 text-center author-card">
                                <img src="${author.image}" alt="${author.name}" class="rounded-circle mb-2" style="width: 80px; height: 80px;">
                                <h5>${author.name}</h5>
                                <p class="text-muted">${author.field}</p>
                            </div>
                        </a>
                    </div>
                `;
                authorsContainer.innerHTML += authorCard;
            });
        })
        .catch(error => console.error("Không thể tải dữ liệu từ authors.json", error));
}


$(document).ready(function () {
    // Khi nhấn vào danh mục, lọc bài viết theo danh mục
    $(".category-card").click(function () {
        let selectedCategory = $(this).data("category");
        $("#Genero").val(selectedCategory).change();
    });

    // Hiển thị tất cả danh mục khi nhấn "Xem toàn bộ"
    $("#showAllCategories").click(function () {
        $(".category-item.hidden").fadeIn();
        $(this).hide();
        $("#hideCategories").show();
    });

    // Thu gọn danh mục khi nhấn "Thu gọn"
    $("#hideCategories").click(function () {
        $(".category-item.hidden").fadeOut();
        $(this).hide();
        $("#showAllCategories").show();
    });
});


// Form đăng bài viết 
$(document).ready(function () {
    $("#togglePostForm").click(function () {
        $("#postArticleSection").slideToggle();
    });
});
