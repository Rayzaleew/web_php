<?php

if (isset($_POST["level"])) {
    if ($_POST["level"] == "no") {
        setcookie("level", "", time() - 3600);
        unset($_COOKIE["level"]);
        $level = "no";
    } else {
        setcookie("level", $_POST["level"], time() + 365 * 24 * 60 * 60);
        $level = $_POST["level"];
    }

    header("Location: /lab1");
} else {
    if (isset($_COOKIE["level"])) {
        $level = $_COOKIE["level"];
    } else {
        $level = "no";
    }
}

?>

<!DOCTYPE html>
<html lang="ru">


<head>

    <title>Лабораторная 1</title>
    <link href="/main.css" rel="stylesheet" />

</head>



<body>



    <div class="container mb-3">
        <h1 class="mb-1">Лабораторная №1</h1>

        <a href="/lab1/dump.sql" class="mb-3">Скачать SQL дамп</a>
    </div>

    <div class="container mb-3">
        <h1 class="mb-1">Куки</h1>

        <h2 class="mb-1">Права доступа:
            <?php
            if (isset($level)) {
                echo "Вы ";

                switch ($level) {
                    case "user":
                        echo "пользователь";
                        break;
                    case "moderator":
                        echo "модератор";
                        break;
                    case "admin":
                        echo "администратор";
                        break;
                    case "no":
                        echo "не авторизованы";
                        break;
                }

                echo "!";
            }
            ?>
        </h2>

        <form class="mb-1" method="POST">

            <div>
                <input type="radio" id="user" name="level" value="user" <?php if (isset($level) && $level == "user")
                    echo "checked" ?> />
                    <label for="user">Пользователь</label>
                </div>

                <div>
                    <input type="radio" id="moderator" name="level" value="moderator" <?php if (isset($level) && $level == "moderator")
                    echo "checked" ?> />
                    <label for="moderator">Модератор</label>
                </div>

                <div>
                    <input type="radio" id="admin" name="level" value="admin" <?php if (isset($level) && $level == "admin")
                    echo "checked" ?> />
                    <label for="admin">Администратор</label>
                </div>

                <div class="mb-1">
                    <input type="radio" id="no" name="level" value="no" <?php if (isset($level) && $level == "no")
                    echo "checked" ?> />
                    <label for="no">Нет прав</label>
                </div>

                <button class="block" type="submit">Поставить права</button>

            </form>



        </div>

        <div class="container">
            <h2 class="mb-2">Журнал</h2>

            <form method="post">
                <span>День недели:</span>

                <div>
                    <input type="radio" id="monday" name="day" value="monday" />
                    <label for="monday">Понедельник</label>
                </div>

                <div>
                    <input type="radio" id="tuesday" name="day" value="tuesday" />
                    <label for="tuesday">Вторник</label>
                </div>

                <div>
                    <input type="radio" id="wednesday" name="day" value="wednesday" />
                    <label for="wednesday">Среда</label>
                </div>

                <div>
                    <input type="radio" id="thursday" name="day" value="thursday" />
                    <label for="thursday">Четверг</label>
                </div>

                <div>
                    <input type="radio" id="friday" name="day" value="friday" />
                    <label for="friday">Пятница</label>

                </div>

                <div>
                    <input type="radio" id="saturday" name="day" value="saturday" />
                    <label for="saturday">Суббота</label>
                </div>

                <div class="mb-2">
                    <input type="radio" id="sunday" name="day" value="sunday" />
                    <label for="sunday">Воскресенье</label>
                </div>

                <div>
                    <span>Интервал времени</span>

                    <select name="time">
                        <option value="8:00 - 9:30">8:00 - 9:30</option>
                        <option value="9:40 - 11:10">9:40 - 11:10</option>
                        <option value="11:20 - 12:50">11:20 - 12:50</option>
                        <option value="13:00 - 14:30">13:00 - 14:30</option>
                        <option value="14:40 - 16:10">14:40 - 16:10</option>
                        <option value="16:20 - 17:50">16:20 - 17:50</option>
                        <option value="18:00 - 19:30">18:00 - 19:30</option>
                        <option value="19:40 - 21:10">19:40 - 21:10</option>
                    </select>
                </div>

                <button class="block" type="submit">Добавить запись</button>

            </form>

            <br>

            <?php



                if (isset($_POST["day"]) && isset($_POST["time"])) {
                    $file = @fopen(__DIR__ . "/file.txt", "a");


                    $day = $_POST["day"];
                    $time = $_POST["time"];

                    switch ($day) {
                        case "monday":
                            $day = "Понедельник";
                            break;
                        case "tuesday":
                            $day = "Вторник";
                            break;
                        case "wednesday":
                            $day = "Среда";
                            break;
                        case "thursday":
                            $day = "Четверг";
                            break;
                        case "friday":
                            $day = "Пятница";
                            break;
                        case "saturday":
                            $day = "Суббота";
                            break;
                        case "sunday":
                            $day = "Воскресенье";
                            break;
                    }

                    $line = $day . " " . $time . "\n";

                    fwrite($file, $line);


                    fclose($file);

                    header("Location: /lab1");
                }


                $file = @fopen(__DIR__ . "/file.txt", "r");

                while (!feof($file)) {
                    $line = fgets($file);
                    $line = htmlspecialchars($line);

                    echo $line . "<br>";
                }

                fclose($file);

                ?>

    </div>




</body>


</html>