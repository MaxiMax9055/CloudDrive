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
<html>
<head>
    <title>Загрузка файла</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {display:none;}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
    </style>
</head>
<body>
    <h1>Загрузить файл на сервер:</h1>
<?php
function val_file() {
    $dir = opendir('files/');
$count = 0;
while($file = readdir($dir)){
    if($file == '.' || $file == '..' || is_dir('files/' . $file)){
        continue;
    }
    $count++;
}
return $count;
}
if ($_FILES && $_FILES["filename"]["error"]== UPLOAD_ERR_OK)
{
    function status() {
        if ($_POST['status'] == "on"){
            return "public";
        } else {
            return "private";
        }
    }
    $fn = date('Y.m.d_') . date('H') +2 . date('.i.s');
    $name = "files/". $fn . ".upd";
    move_uploaded_file($_FILES["filename"]["tmp_name"], $name);
    $link = mysqli_connect("localhost", "root", "", "cd");
    $sql = "INSERT INTO `files`(`id`, `Name`, `Parent`, `Path`, `Status`, `Date import`) VALUES ('". val_file()  . "','" . $_FILES["filename"]["name"] . "','" . $user['id'] . "','" . $name . "','". status() . "','" . date("Y.m.d") . "')";
    $result = mysqli_query($link, $sql);

    if ($result == false) {
        print("Произошла ошибка при выполнении запроса");
    }
    header ("Location: index.php");
}
?>
<form method="POST" enctype="multipart/form-data">
<h2>Выберите файл:</h2><input type="file" name="filename" size="10" /><br /><br />
<h2>Опубликовать?</h2>
  <p><label class="switch">
  <input type="checkbox" name="status" checked>
  <span class="slider round"></span>
</label>Если включено то файл будет доступен всем.</p><br>
<input type="submit" value="Загрузить" />
</form>
</body>
</html>