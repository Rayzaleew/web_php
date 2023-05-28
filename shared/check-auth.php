<?php

include $_SERVER['DOCUMENT_ROOT'] . "/shared/db.php";

session_start();

if ($_SESSION['userid']) {
    $auth_query = pg_query($dbconn, "SELECT staff.*,
        department.id AS department_id,
        department.name AS department_name
        FROM staff 
        JOIN room ON staff.room_id = room.id
        JOIN department ON room.department_id = department.id
        WHERE staff.id = " . $_SESSION['userid'] . "
    ");
    $auth = pg_fetch_all($auth_query);
    $current_staff = $auth[0];
    $is_hr = $current_staff['department_id'] == 2;
}

function redirect_if_not_hr()
{
    global $is_hr;
    if (!$is_hr) {
        header("Location: /lab2/index.php");
        exit();
    }
}


?>