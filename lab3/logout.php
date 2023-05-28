<?php

session_unset();
session_destroy();
session_abort();

// clear cookie PHPSESSID
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

header("Location: /lab3/auth.php");

?>