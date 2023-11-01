<?php
// 連接到 MariaDB 資料庫
$servername = "localhost";
$username = "center61";
$password = "catInKeyboard1101";
$dbname = "demo";

$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接是否成功
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 創建資料庫表格（如果不存在）
$sql = "CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    publication_year INT
)";

if ($conn->query($sql) === TRUE) {
    echo "資料表已建立或已存在。";
} else {
    echo "資料表建立失敗: " . $conn->error;
}

// 增加書本
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $author = $_POST["author"];
    $year = $_POST["year"];

    $sql = "INSERT INTO books (title, author, publication_year) VALUES ('$title', '$author', $year)";

    if ($conn->query($sql) === TRUE) {
        echo "書本已新增成功！";
    } else {
        echo "新增書本失敗: " . $conn->error;
    }
}

// 刪除書本
if (isset($_GET["delete"])) {
    $id = $_GET["delete"];

    $sql = "DELETE FROM books WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "書本已刪除成功！";
    } else {
        echo "刪除書本失敗: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>書本管理</title>
</head>
<body>
    <h1>書本管理</h1>

    <!-- 增加書本的表單 -->
    <form method="post" action="">
        <label>書名:</label>
        <input type="text" name="title" required><br>

        <label>作者:</label>
        <input type="text" name="author" required><br>

        <label>出版年份:</label>
        <input type="number" name="year"><br>

        <input type="submit" value="新增書本">
    </form>

    <h2>書本列表</h2>
    <table>
        <tr>
            <th>書名</th>
            <th>作者</th>
            <th>出版年份</th>
            <th>操作</th>
        </tr>
        <?php
        // 顯示書本列表
        $sql = "SELECT * FROM books";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["title"] . "</td>";
                echo "<td>" . $row["author"] . "</td>";
                echo "<td>" . $row["publication_year"] . "</td>";
                echo "<td><a href='?delete=" . $row["id"] . "'>刪除</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>沒有書本可顯示。</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
// 關閉資料庫連接
$conn->close();
?>
