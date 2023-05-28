<?php

include $_SERVER['DOCUMENT_ROOT'] . "/shared/db.php";
include $_SERVER['DOCUMENT_ROOT'] . "/shared/check-auth.php";

redirect_if_not_hr();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $staff_query = pg_query($dbconn, "SELECT
        staff.id,
        staff.last_name,
        staff.username,
        staff.password,
        room.id AS room_id,
        room.department_id,
        department.name AS department_name,
        computers.id AS computer_id,
        computers.name AS computer_name
        FROM staff
        INNER JOIN room ON staff.room_id = room.id
        INNER JOIN computers ON staff.computer_id = computers.id
        INNER JOIN department ON room.department_id = department.id
        WHERE staff.id = " . pg_escape_string($_GET['id']) . "
    ");
    $staff = pg_fetch_all($staff_query)[0];

    if (!$staff) {
        header("Location: /lab3/index.php?error=404");
        exit();
    }

    $rooms_query = pg_query($dbconn, "SELECT
        room.id,
        department.name AS department_name
        FROM room
        INNER JOIN department ON room.department_id = department.id
    ");
    $rooms = pg_fetch_all($rooms_query);

    $computers_query = pg_query($dbconn, "SELECT
        computers.id,
        computers.name,
        computers.ram,
        computers.cpu_cores
        FROM computers
        LEFT JOIN staff ON computers.id = staff.computer_id
        WHERE staff.computer_id IS NULL OR staff.id = " . pg_escape_string($_GET['id']) . "
    ");
    $computers = pg_fetch_all($computers_query);
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $last_name = pg_escape_string($_POST['last_name']);
    $room_id = pg_escape_string($_POST['room_id']);
    $computer_id = pg_escape_string($_POST['computer']);


    if (!$last_name || !$room_id || !$computer_id) {
        header("Location: /lab3/edit.php?error=1&id=" . $_GET['id'] . "");
        exit();
    }

    $update_query = pg_query($dbconn, "UPDATE staff SET last_name = '$last_name', room_id = $room_id, computer_id = $computer_id WHERE id = " . pg_escape_string($_GET['id']) . "");
    header("Location: /lab3/edit.php?success=true&id=" . $_GET['id'] . "");
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Лабораторная 2</title>
    <link href="/main.css?version=2" rel="stylesheet" />

</head>


<body>
    <form class="container mb-3" method="POST">
        <a href="/lab3/index.php" class="mb-3">Вернуться к списку сотрудников</a>

        <h1 class="mb-2">
            Редактирование сотрудника
        </h1>

        <?php
        if ($_GET['error'] == 1) {
            echo "<p class='error mb-3'>
                Вы не заполнили все поля!
            </p>";
        } else if ($_GET['success'] == 'true') {
            echo "<p class='mb-3'>
                Изменения успешно сохранены!
            </p>";
        }
        ?>

        <div class="mb-2">
            <h3 class="mb-1">Фамилия</h3>
            <input type="text" name="last_name" id="last_name" required value="<?= $staff['last_name'] ?>">
        </div>


        <div class="mb-2">
            <h3 class="mb-1">Имя пользователя</h3>
            <input type="text" name="username" id="username" required value="<?= $staff['username'] ?>">
        </div>

        <div class="mb-2">
            <h3 class="mb-1">Пароль</h3>
            <input type="password" name="password" id="password" required value="<?= $staff['password'] ?>">

        </div>



        <h3 class="mb-1">Выбор кабинета</h3>
        <table class="mb-2">
            <tr>
                <th>Выбор</th>
                <th>Номер</th>
                <th>Отдел</th>
            </tr>

            <?php
            foreach ($rooms as $room) {
                echo "<tr>";
                echo "<td><input type='radio' name='room_id' value='" . $room['id'] . "'
                    " . ($room['id'] == $staff['room_id'] ? 'checked' : '') . "
                ></td>";
                echo "<td>" . $room['id'] . "</td>";
                echo "<td>" . $room['department_name'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>

        <h3 class="mb-1">Выбор компьютера</h3>
        <p class="mb-1">
            В этом списке указаны только свободные компьютеры! Если их нет, приходите позже, когда у
            компании появятся средства на покупку новых компьютеров.
        </p>
        <table class="mb-2">
            <tr>
                <th>Выбор</th>
                <th>Номер</th>
                <th>Имя</th>
                <th>ОЗУ</th>
                <th>Количество ядер</th>
            </tr>

            <?php
            foreach ($computers as $computer) {
                echo "<tr>";
                echo "<td><input type='radio' name='computer' value='" . $computer['id'] . "'
                    " . ($computer['id'] == $staff['computer_id'] ? 'checked' : '') . "
                ></td>";
                echo "<td>" . $computer['id'] . "</td>";
                echo "<td>" . $computer['name'] . "</td>";
                echo "<td>" . $computer['ram'] . "</td>";
                echo "<td>" . $computer['cpu_cores'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>

        <input type="submit" value="Сохранить" class="mb-2">

        <a class="button" href="/lab3/delete.php?id=<?= $staff['id'] ?>" class="delete">Удалить сотрудника</a>
    </form>

</body>

</html>