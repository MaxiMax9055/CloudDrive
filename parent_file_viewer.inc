<?php
//Status file
if (isset($_POST['change_status'])) {
    if ($status == "public") {
    $link = mysqli_connect("localhost", "root", "", "cd");
    $sql = "UPDATE `files` SET `Status`='private' WHERE id=" . $_GET['id'];
    $result = mysqli_query($link, $sql);
    } elseif ($status == "private") {
    $link = mysqli_connect("localhost", "root", "", "cd");
    $sql = "UPDATE `files` SET `Status`='public' WHERE id=" . $_GET['id'];
    $result = mysqli_query($link, $sql);
    }
    header("Location: .");
}
//Delete file
if (isset($_POST['delete_file'])) {
    $link = mysqli_connect("localhost", "root", "", "cd");
    $sql = "DELETE FROM `files` WHERE id=" . $_GET['id'];
    unlink($path);
    $result = mysqli_query($link, $sql);
header("Location: .");
}
?>
<h1 align="center"><?php echo $name; ?></h1><br>
<h3>Владелец: <?php echo $parent; ?></h3><br>
<a href="<?php echo $path; ?>" download><button><h3>Скачать</h3></button></a>
<form method="POST">
<button name="change_status">
<?php
if ($status == "public") {
    echo 'Скрыть';
} elseif ($status == "private") {
    echo 'Показать';
}
?>
</button>
</form>
<form method="post">
<button name="delete_file">Удалить файл</button>
</form>