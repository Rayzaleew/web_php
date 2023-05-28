<?php
include $_SERVER['DOCUMENT_ROOT'] . "/shared/db.php";
include $_SERVER['DOCUMENT_ROOT'] . "/shared/svg.php";
include $_SERVER['DOCUMENT_ROOT'] . "/shared/check-auth.php";

$staff_query = pg_query($dbconn, "SELECT
    staff.id,
    staff.last_name,
    room.id AS room_id,
    room.department_id,
    department.name AS department_name,
    computers.id AS computer_id,
    computers.name AS computer_name
    FROM staff
    INNER JOIN room ON staff.room_id = room.id
    INNER JOIN computers ON staff.computer_id = computers.id
    INNER JOIN department ON room.department_id = department.id
    WHERE
            " . ($_GET['department'] ? "department.id = " . pg_escape_string($_GET['department']) : "1 = 1") . " AND
            " . ($_GET['room'] ? "room.id = " . pg_escape_string($_GET['room']) : "1 = 1") . " AND
            " . ($_GET['last_name'] ? "LOWER(staff.last_name) LIKE LOWER('%" . pg_escape_string($_GET['last_name']) . "%')" : "1 = 1") . " AND
            1 = 1
");
$staff = pg_fetch_all($staff_query);

$departments_query = pg_query($dbconn, "SELECT * FROM department");
$departments = pg_fetch_all($departments_query);

$rooms_query = pg_query($dbconn, "SELECT
    id
    FROM room");
$rooms = pg_fetch_all($rooms_query);
?>

<!DOCTYPE html>
<html>



<head>

    <title>Лабораторная 2</title>
    <link href="/main.css?version=2" rel="stylesheet" />

</head>


<body>

    <div class="container mb-3">
        <?php
        if (isset($_SESSION['userid'])) {
            echo "<a href='/lab2/logout.php' class='mb-3'>Выйти из 
                $current_staff[last_name] ($current_staff[username], $current_staff[department_name])
            </a>";
        } else {
            echo "<a href='/lab2/auth.php' class='mb-3'>Войти на сайт</a>";
        }
        ?>

        <h1 class="mb-1">Все сотрудники предприятия</h1>

        <?php
        if ($_GET['success'] == "delete") {
            echo "<p class='mb-3'>
                Сотрудник успешно удален!
            </p>";
        }
        ?>

        <?php
        if ($is_hr) {
            echo "<a href='/lab2/insert.php' class='mb-3 button'>
                " . $_ICONS["add"] . "
                Создать сотрудника
            </a>";
        } else {
            echo "<p class='mb-3'>
                Чтобы создавать и редактировать сотрудников, войдите на сайт под учетной записью HR.
            </p>";
        }
        ?>


        <details>
            <summary class="mb-2">Фильтры</summary>
            <form class="mb-3" method="GET">
                <h3 class="mb-1">Отдел</h3>
                <select class="mb-1" name="department" id="department">
                    <option value="0" <?php
                    if (!$_GET['department']) {
                        echo "selected";
                    }
                    ?>>Все</option>
                    <?php
                    foreach ($departments as $department) {
                        echo "<option value='" . $department['id'] . "'
                            " . ($_GET['department'] == $department['id'] ? "selected" : "") . "
                            >" . $department['name'] . "</option>";
                    }
                    ?>
                </select>

                <h3 class="mb-1">Кабинет</h3>

                <select class="mb-1" name="room" id="room">
                    <option value="0" <?php
                    if (!$_GET['room']) {
                        echo "selected";
                    }
                    ?>>Все</option>
                    <?php
                    foreach ($rooms as $room) {
                        echo "<option value='" . $room['id'] . "'
                            " . ($_GET['room'] == $room['id'] ? "selected" : "") . "
                            >" . $room['id'] . "</option>";
                    }
                    ?>
                </select>

                <h3 class="mb-1">Фамилия</h3>

                <p class="mb-1">
                    (Частичное совпадение)
                </p>

                <input class="mb-1" type="text" name="last_name" id="last_name" value="<?= $_GET['last_name'] ?>">


                <button class="button">
                    <?= $_ICONS["filter"] ?>
                    Применить
                </button>
            </form>
        </details>

        <table>
            <thead>
                <tr>
                    <th>Фамилия</th>
                    <th>Компьютер</th>
                    <th>Кабинет</th>
                    <th>Отдел</th>

                    <?php
                    if ($is_hr) {
                        echo "<th></th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($staff as $person) {
                    echo "<tr>
                        <td>" . $person['last_name'] . "</td>
                        <td>" . $person['computer_name'] . "</td>
                        <td>" . $person['room_id'] . "</td>
                        <td>" . $person['department_name'] . "</td>


                        " . ($is_hr ? "
                            <td><a href='/lab2/edit.php?id=" . $person['id'] . "'>
                                " . $_ICONS["edit"] . "
                            </a></td>
                        " : "") . "
                        
                    </tr>";
                }
                ?>
            </tbody>
    </div>

</body>

</html>