<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CKEditor Demo</title>

    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
</head>
<body>

<form method="POST">
    <textarea name="content" id="editor"><?php echo $_POST['content'] ?? ''; ?></textarea>
    <button type="submit">Lưu</button>
</form>

<h3>HTML thật render ra:</h3>
<div style="border:1px solid #ccc;padding:10px;">
    <?php echo $_POST['content'] ?? ''; ?>
</div>

<h3>Mã HTML thô:</h3>
<pre style="border:1px solid #ccc;padding:10px; white-space: pre-wrap;">
<?php
    if (!empty($_POST['content'])) {
        echo htmlspecialchars($_POST['content']); 
    }
?>
</pre>

<script>
    CKEDITOR.replace('editor', {
        extraAllowedContent: '*(*);*{*}',
        enterMode: CKEDITOR.ENTER_BR,
        shiftEnterMode: CKEDITOR.ENTER_P
    });
</script>

</body>
</html>
