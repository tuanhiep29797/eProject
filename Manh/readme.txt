M file đã thay đổi
U là file mới

git pull origin main --rebase 
// Để lưu lại file mới nhất

changeLetter Để thay đổi text tiếng viết -> khong-dau

//Gặp lỗi css 
2. Cache trình duyệt (rất hay gặp)
Trình duyệt lưu file CSS cũ → nên bạn sửa nhưng nó không cập nhật.
Cách fix:
Thay link thành:
<link rel="stylesheet" href="../css/style.css?v=<?= time() ?>">
→ Mỗi lần load sẽ luôn lấy CSS mới.