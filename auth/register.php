<?php

require_once __DIR__.'/boot.php';

if (check_auth()) {
    header('Location: ..');
    die;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Register</title>
  <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>

          <h1 class="mb-5">Registration</h1>

            <?php flash(); ?>

          <form method="post" action="do_register.php">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-flex justify-content-between">
              <button type="submit" class="btn btn-primary">Register</button>
              <a class="btn btn-outline-primary" href="/./index.php">Login</a>
            </div>
          </form>

    </div>
  </div>
</div>

</body>
</html>
