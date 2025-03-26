<?php

// app/Helpers/BioFormatter.php
namespace App\Helpers;

class BioFormatter
{
    public static function format($bio)
    {
        // Xử lý markdown đơn giản
        $bio = preg_replace('/\*\*(.*?)\*\*/m', '<strong>$1</strong>', $bio);

        // Chuyển đổi xuống dòng thành thẻ <p> (Bao gồm cả xuống dòng đơn và đôi)
        $paragraphs = preg_split('/(\r?\n){2,}/', $bio); // Tách các đoạn văn bản tại xuống dòng đơn hoặc đôi.
        $formattedBio = '';

        foreach ($paragraphs as $paragraph) {
            // Loại bỏ các ký tự đặc biệt nhưng giữ nguyên định dạng
            $paragraph = trim(htmlspecialchars($paragraph, ENT_QUOTES, 'UTF-8'));

            // Áp dụng lại markdown
            $paragraph = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $paragraph);

            // Thêm thẻ <p> cho mỗi đoạn văn
            $formattedBio .= "<p>{$paragraph}</p>";
        }

        return $formattedBio;
    }
}
