<?php

include $_SERVER['DOCUMENT_ROOT'] . "/shared/db.php";
include $_SERVER['DOCUMENT_ROOT'] . "/shared/check-auth.php";

redirect_if_not_hr();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $staff_id = pg_escape_string($_GET['id']);

    $delete_query = pg_query($dbconn, "DELETE FROM staff WHERE id = $staff_id");

    header("Location: /lab2/index.php?success=delete");
}

?>