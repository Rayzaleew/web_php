<?php
include $_SERVER['DOCUMENT_ROOT'] . "/shared/db.php";
include $_SERVER['DOCUMENT_ROOT'] . "/shared/check-auth.php";

redirect_if_not_hr();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
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
        WHERE staff.computer_id IS NULL
    ");
    $computers = pg_fetch_all($computers_query);
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $last_name = pg_escape_string($_POST['last_name']);
    $room_id = pg_escape_string($_POST['room_id']);
    $computer_id = pg_escape_string($_POST['computer']);
    $password = pg_escape_string($_POST['password']);
    $username = pg_escape_string($_POST['username']);

    if (!$last_name || !$room_id || !$computer_id || !$password || !$username) {
        header("Location: /lab4/insert.php?error=1");
        exit();
    }

    $insert_query = pg_query($dbconn, "INSERT INTO staff (last_name, room_id, computer_id, username, password) VALUES ('$last_name', $room_id, $computer_id, '$username', '$password')");

    $inserted_query = pg_query($dbconn, "SELECT
        id
        FROM staff
        WHERE username = '" . $username . "'
    ");
    $inserted = pg_fetch_all($inserted_query)[0];

    header("Location: /lab4/edit.php?success=true&id=" . $inserted['id'] . "");
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Лабораторная 4</title>
    <link href="/main.css?version=2" rel="stylesheet" />

</head>


<body>
    <form class="container mb-3" id="worker-data-form" method="POST">
        <h1 class="mb-2">Создать сотрудника</h1>

        <?php
        if ($_GET['error'] == 1) {
            echo "<p class='error mb-3'>
                Вы не заполнили все поля!
            </p>";
        }
        ?>

        <div class="mb-2">
            <h3 class="mb-1">Фамилия</h3>
            <input type="text" name="last_name" id="last_name" required>
        </div>

        <div class="mb-2">
            <h3 class="mb-1">Имя пользователя</h3>
            <input type="text" name="username" id="username" required>
        </div>

        <div class="mb-2">
            <h3 class="mb-1">Пароль</h3>
            <input type="password" name="password" id="password" required>
        </div>



        <h3 class="mb-1">Выбор кабинета</h3>
        <table class="mb-2">
            <tr>
                <th></th>
                <th>Номер</th>
                <th>Отдел</th>
            </tr>

            <?php
            foreach ($rooms as $room) {
                echo "<tr>";
                echo "<td><input type='radio' name='room_id' value='" . $room['id'] . "'></td>";
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
        <div>
            <span>Выберите производителя</span>

            <select id="brandSelect"></select>
        </div>
        <div id="modelsTable"></div>

        <input type="submit" value="Создать">
    </form>

    <script src="/shared/check-filled.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="/shared/validate.js"></script>
    <script src="/shared/fetch_computer_models.js"></script>
</body>

</html>