<?php
require_once __DIR__.'/auth/boot.php';

$user = null;

if (check_auth()) {
    // Получим данные пользователя по сохранённому идентификатору
    $stmt = pdo()->prepare("SELECT * FROM `users` WHERE `id` = :id");
    $stmt->execute(['id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<doctype html>
<html>
<head>
    <title>CloudDisc</title>
    <meta charset="utf8">
    <link type="image/x-icon" href="favicon.ico" rel="image/x-icon">
    <link rel="stylesheet" type="text/css" href="cursor.css">
<link type="Image/x-icon" href="favicon.ico" rel="icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php
$conn = new mysqli("localhost", "root", "", "cd");
if($conn->connect_error){
    die("Ошибка: " . $conn->connect_error);
}
$sql = "SELECT * FROM `files` WHERE id=" . $_GET['id'];
if($result = $conn->query($sql)){
    foreach($result as $row){
        $name = $row["Name"];
        $parent = $row["Parent"];
        $path = $row["Path"];
        $status = $row["Status"];
        $date = $row["Date import"];
        if ($parent == $user['id']) {
            include "parent_file_viewer.inc";
        } elseif ($status == "public") {
            include "file_viewer.inc";
        }
        else {
            echo "Данный файл является приватным и вы НЕ можете получить к нему доступ.";
            echo '<button onclick="history.back();">Назад</button>';
        }
    }
}
?>
</body>
</html>