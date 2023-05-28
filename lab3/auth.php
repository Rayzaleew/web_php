<?php

include $_SERVER['DOCUMENT_ROOT'] . "/shared/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = pg_escape_string($_POST['login']);
    $password = pg_escape_string($_POST['password']);

    if (!$login || !$password) {
        header("Location: /lab3/auth.php?error=nodata");
        exit();
    }

    $auth_query = pg_query($dbconn, "SELECT * FROM staff WHERE username = '$login' AND password = '$password'");
    $auth = pg_fetch_all($auth_query);

    if ($auth) {
        session_start();
        $_SESSION['auth'] = true;
        $_SESSION['userid'] = $auth[0]['id'];
        header("Location: /lab3");
    } else {
        header("Location: /lab3/auth.php?error=auth");
    }
}

?>


<!DOCTYPE html>
<html>



<head>

    <title>Войти</title>
    <link href="/main.css?version=2" rel="stylesheet" />

</head>

<body>

    <div class="container">
        <a href="/lab3" class="mb-3">К списку сотрудников</a>

        <h1 class="mb-2">Войти</h1>

        <p class="mb-2">
            Введите логин и пароль выданный HR-менеджером
        </p>

        <?php
        if ($_GET['error']) {
            echo "<p class='error mb-2'>
                " . ($_GET['error'] == 'auth' ? 'Неверный логин или пароль' : 'Вы не заполнили все поля!') . "
            </p>";
        }
        ?>

        <form method="POST">
            <input class="mb-1" type="text" name="login" placeholder="Логин" />
            <input class="mb-1" type="password" name="password" placeholder="Пароль" />
            <input class="mb-1" type="submit" value="Войти" />
        </form>
    </div>

</body>

</html>