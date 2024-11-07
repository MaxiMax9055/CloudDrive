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
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>CloudDrive</title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <style>
    table{
	border: 1px solid #eee;
	table-layout: fixed;
	width: 100%;
	margin-bottom: 20px;
}
table th {
	font-weight: bold;
	padding: 5px;
	background: #efefef;
	border: 1px solid #dddddd;
}
table td{
	padding: 5px 10px;
	border: 1px solid #eee;
	text-align: left;
}
table tbody tr:nth-child(odd){
	background: #fff;
}
table tbody tr:nth-child(even){
	background: #F7F7F7;
}
  </style>
</head>
<body>

<div class="container">
  <div class="row py-5">
    <div class="col-lg-6">

        <?php if ($user) { ?>
            <a href="upload.php"><button><h3>Загрузить файл</h3></button></a><button><?php $user['username']; ?></button>
            <h1>Файлы на сервере:</h1>
            <table>
            <th>Name</th><th>Parent</th><th>Date import</th>
            <?php
            echo date('Y.m.d-') . date('H') +2 . date(':i:s');
            $conn = new mysqli("localhost", "root", "", "cd");
            if($conn->connect_error){
                die("Ошибка: " . $conn->connect_error);
            }
            $sql = "SELECT * FROM files";
            if($result = $conn->query($sql)){
                foreach($result as $row){
                    $id = $row["id"];
                    $name = $row["Name"];
                    $parent = $row["Parent"];
                    $path = $row["Path"];
                    $status = $row["Status"];
                    $date = $row["Date import"];
                    if ($status == "public") {
                    echo '<tr><td><a href="file_viewer.php?id=' . $id . '">' . $name . '</a></td><td>' . $parent . '</td><td>' . $date . '</td></tr>';
                    } elseif ($status == "private" & $parent == $user['id']) {
                    echo '<tr><td><a href="file_viewer.php?id=' . $id . '"><p style="color: gray;">' . $name . '</p></a></td><td>' . $parent . '</td><td>' . $date . '</td></tr>';
                    }
                }
            }
            ?>
            </table>
          <form class="mt-5" method="post" action="auth/do_logout.php">
            <button type="submit" class="btn btn-primary">Logout</button>
          </form>

        <?php } else { ?>

        <h1 class="mb-5">Login</h1>

        <?php flash() ?>

      <form method="post" action="auth/do_login.php">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="d-flex justify-content-between">
          <button type="submit" class="btn btn-primary">Login</button>
          <a class="btn btn-outline-primary" href="auth/register.php">Register</a>
        </div>
      </form>

        <?php } ?>

    </div>
  </div>
</div>

</body>
</html>
