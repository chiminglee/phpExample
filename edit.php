<?php
// 編輯書本
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_id"])) {
    $edit_id = $_POST["edit_id"];
    $new_title = $_POST["new_title"];
    $new_author = $_POST["new_author"];
    $new_year = $_POST["new_year"];

    $sql = "UPDATE books SET title='$new_title', author='$new_author', publication_year=$new_year WHERE id=$edit_id";

    if ($conn->query($sql) === TRUE) {
        echo "書本已成功更新！";
    } else {
        echo "更新書本失敗: " . $conn->error;
    }
}

// 編輯書本的表單
if (isset($_GET["edit"])) {
    $edit_id = $_GET["edit"];
    $sql = "SELECT * FROM books WHERE id=$edit_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <h2>編輯書本</h2>
        <form method="post" action="">
            <input type="hidden" name="edit_id" value="<?= $edit_id ?>">
            <label>新書名:</label>
            <input type="text" name="new_title" value="<?= $row["title"] ?>" required><br>

            <label>新作者:</label>
            <input type="text" name="new_author" value="<?= $row["author"] ?>" required><br>

            <label>新出版年份:</label>
            <input type="number" name="new_year" value="<?= $row["publication_year"] ?>"><br>

            <input type="submit" value="更新書本">
        </form>
        <?php
    }
}
?>
