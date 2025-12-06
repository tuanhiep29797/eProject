<?php
    $feedbacks = [
        [
            "username" => "Nguyen Van An",
            "email" => "nguyenvanan@gmail.com",
            "phone_number" => "0901234567",
            "content" => "Shop có nhiều mẫu đèn đẹp, chất lượng tốt. Nhân viên tư vấn nhiệt tình. Sẽ ủng hộ shop dài dài!"
        ],
        [
            "username" => "Tran Thi Bich",
            "email" => "tranbich@gmail.com",
            "phone_number" => "0912345678",
            "content" => "Mình đã mua đèn chùm pha lê Philips, sản phẩm đẹp đúng như hình. Giao hàng nhanh, đóng gói cẩn thận."
        ],
        [
            "username" => "Le Minh Cuong",
            "email" => "leminhcuong@gmail.com",
            "phone_number" => "0923456789",
            "content" => "Đặt hàng online rất tiện lợi. Website dễ sử dụng, thanh toán nhanh chóng. Sản phẩm nhận được rất hài lòng."
        ],
        [
            "username" => "Pham Hong Dao",
            "email" => "phamdao@gmail.com",
            "phone_number" => "0934567890",
            "content" => "Tôi muốn hỏi shop có dịch vụ lắp đặt tại nhà không? Mình muốn mua quạt trần nhưng không biết lắp."
        ],
        [
            "username" => "Vo Thi Em",
            "email" => "vothiem@gmail.com",
            "phone_number" => "0945678901",
            "content" => "Shop có thể bổ sung thêm danh mục đèn trang trí Tết không ạ? Mình đang tìm đèn lồng và đèn LED trang trí Tết."
        ],
        [
            "username" => "Hoang Van Phuc",
            "email" => "hoangphuc@gmail.com",
            "phone_number" => "0956789012",
            "content" => "Đã mua đèn LED thông minh Philips Hue, kết nối app điều khiển rất tiện. Recommend cho ai đang tìm smart home!"
        ],
        [
            "username" => "Nguyen Thi Giang",
            "email" => "nguyengiang@gmail.com",
            "phone_number" => "0967890123",
            "content" => "Giá cả hợp lý so với chất lượng sản phẩm. Mình đã so sánh với nhiều shop khác và thấy shop này tốt nhất."
        ],
        [
            "username" => "Tran Van Hai",
            "email" => "tranhai@gmail.com",
            "phone_number" => "0978901234",
            "content" => "Mua quạt trần Hunter về dùng rất êm, gió mát. Vợ mình rất thích. Cảm ơn shop đã tư vấn nhiệt tình!"
        ],
        [
            "username" => "Le Thi Yen",
            "email" => "leyen@gmail.com",
            "phone_number" => "0989012345",
            "content" => "Góp ý shop nên có thêm filter lọc sản phẩm theo giá và theo công suất để dễ tìm kiếm hơn ạ."
        ],
        [
            "username" => "Pham Duc Khang",
            "email" => "phamkhang@gmail.com",
            "phone_number" => "0990123456",
            "content" => "Shop tuyệt vời! Đã mua bộ đèn năng lượng mặt trời cho sân vườn, tiết kiệm điện mà vẫn đẹp. 10 điểm!"
        ],
        [
            "username" => "Mai Lan Chi",
            "email" => "mailachi@gmail.com",
            "phone_number" => "0901122334",
            "content" => "Mình là kiến trúc sư, thường xuyên đặt đèn cho các dự án từ shop này. Sản phẩm chất lượng, giao hàng đúng hẹn."
        ],
        [
            "username" => "Do Van Minh",
            "email" => "dovanminh@gmail.com",
            "phone_number" => "0912233445",
            "content" => "Hỏi shop có hỗ trợ bảo hành không ạ? Mình mua đèn LED 2 năm trước, giờ bị nhấp nháy muốn đổi."
        ]
    ];
    
    try
    {
        $conn = getConnection();
        foreach ($feedbacks as $item)
        {
            $stmt = $conn -> prepare(SQL_ADD_FEEDBACK);
            $stmt -> bindParam(":username", $item["username"]);
            $stmt -> bindParam(":email", $item["email"]);
            $stmt -> bindParam(":phone_number", $item["phone_number"]);
            $stmt -> bindParam(":content", $item["content"]);
            $stmt -> execute();
        }
        echo "Feedback data inserted successfully!\n";
    }
    catch (PDOException $e)
    {
        echo "Feedback Error: " . $e -> getMessage() . "\n";
    };

    $conn = null;
?>