$(document).ready(function () {
    const params = new URLSearchParams(window.location.search);
    const articleId = params.get("id");

    $.getJSON("asset/js/articles.json", function (articles) {
        const article = articles.find(a => a.id == articleId);

        if (article) {
            $("#articleTitle").text(article.title);
            $("#articleDate").text("Ngày đăng: " + article.published_date);
            $("#articleImage").attr("src", article.image);
            $("#articleContent").text(article.content);
            $("#authorName").text(article.author);
            $("#authorSpecialty").text("Chuyên khoa: " + article.category);

            // Hiển thị bài viết liên quan (tối đa 3 bài khác cùng chuyên mục)
            const relatedArticles = articles.filter(a => a.category === article.category && a.id != articleId).slice(0, 3);
            $("#relatedArticles").empty();
            relatedArticles.forEach(a => {
                $("#relatedArticles").append(`<li><a href="article-detail.html?id=${a.id}">${a.title}</a></li>`);
            });
        } else {
            $("#articleTitle").text("Bài viết không tồn tại");
            $("#articleContent").text("Xin lỗi, bài viết này không tồn tại hoặc đã bị xóa.");
        }
    }).fail(function () {
        console.error("Không thể tải dữ liệu từ articles.json");
    });
});
