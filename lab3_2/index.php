<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/ckeditor/ckeditor.php';

session_start();

if (isset($_POST["level"])) {
    if ($_POST["level"] == "no") {
        setcookie("level", "", time() - 3600);
        unset($_COOKIE["level"]);
        $level = "no";
    } else {
        setcookie("level", $_POST["level"], time() + 365 * 24 * 60 * 60);
        $level = $_POST["level"];
    }

    header("Location: /lab3_2");
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

    <title>Лабораторная 3.2</title>
    <link href="/main.css" rel="stylesheet" />


</head>



<body>
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script> -->


    <div class="container mb-3">
        <h1 class="mb-3">Журнал посещений</h1>

        <?php
        if (isset($_GET["error"])) {
            echo "<p class='error mb-2'>
                " . ($_GET["error"] == "captcha" ? "Неверные символы с картинки! Какая досада, попался, жалкий робот" : "") . "
            </p>";
        } else if (isset($_GET["success"])) {
            echo "<p class='success mb-2'>
                " . ($_GET["success"] == "true" ? "Запись успешно добавлена!" : "") . "
            </p>";
        }
        ?>

        <form class="mb-2" method="post">

            <h3 class="mb-1">День недели</h3>

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

            <div class="mb-2">
                <h3 class="mb-1">Время</h3>

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

            <h3 class="mb-1">Введите символы с картинки</h3>

            <div class="mb-2" style="display:flex;">


                <img width="160" height="80" style="margin-right: 10px;border-radius: 16px;"
                    src="/kcaptcha/index.php?<?php echo session_name() ?>=<?php echo session_id() ?>">

                <input type="text" name="keystring" required style="font-size:32px;width:160px;text-align:center;
                    font-family:monospace;padding: 0;
                " />
            </div>

            <h3 class="mb-1">Ваш комментарий (не обязательно)</h3>

            <textarea class="ckeditor mb-3" name="comment"></textarea>

            <button class="block" type="submit" style="margin-top:32px;">Добавить запись</button>

        </form>

        <?php



        if (isset($_POST["day"]) && isset($_POST["time"]) && isset($_POST["keystring"])) {

            if (isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] === $_POST['keystring']) {
                $file = @fopen(__DIR__ . "/file.html", "a");


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

                $line = $day . " " . htmlspecialchars($time) . "\n<br>";

                fwrite($file, $line);

                if (isset($_POST["comment"])) {
                    fwrite($file, $_POST["comment"] . "\n\n<br><br>");
                }


                fclose($file);

                header("Location: /lab3_2?success=true");
            } else {
                header("Location: /lab3_2?error=captcha");
            }
        }


        $file = @fopen(__DIR__ . "/file.html", "r");

        while (!feof($file)) {
            $line = fgets($file);

            echo $line;
        }

        fclose($file);

        ?>

    </div>




</body>


</html>