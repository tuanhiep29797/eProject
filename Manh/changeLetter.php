<?php 
function slugify($text) {
    $text = trim($text);
    $text = preg_replace('/[áàảãạăắằẳẵặâấầẩẫậ]/u', 'a', $text);
    $text = preg_replace('/[ÁÀẢÃẠĂẮẰẲẴẶÂẤẦẨẪẬ]/u', 'A', $text);
    $text = preg_replace('/[đ]/u', 'd', $text);
    $text = preg_replace('/[Đ]/u', 'D', $text);
    $text = preg_replace('/[éèẻẽẹêếềểễệ]/u', 'e', $text);
    $text = preg_replace('/[ÉÈẺẼẸÊẾỀỂỄỆ]/u', 'E', $text);
    $text = preg_replace('/[íìỉĩị]/u', 'i', $text);
    $text = preg_replace('/[ÍÌỈĨỊ]/u', 'I', $text);
    $text = preg_replace('/[óòỏõọôốồổỗộơớờởỡợ]/u', 'o', $text);
    $text = preg_replace('/[ÓÒỎÕỌÔỐỒỔỖỘƠỚỜỞỠỢ]/u', 'O', $text);
    $text = preg_replace('/[úùủũụưứừửữự]/u', 'u', $text);
    $text = preg_replace('/[ÚÙỦŨỤƯỨỪỬỮỰ]/u', 'U', $text);
    $text = preg_replace('/[ýỳỷỹỵ]/u', 'y', $text);
    $text = preg_replace('/[ÝỲỶỸỴ]/u', 'Y', $text);
    
    // Chuyển thành chữ thường
    $text = strtolower($text);
    
    // Thay ký tự không phải chữ số/chữ cái bằng dấu -
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    
    // Xóa dấu - thừa ở đầu và cuối
    return trim($text, '-');

}