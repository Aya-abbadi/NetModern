<?php
session_start();

session_unset();
session_destroy();

header("Location: utilisateurs/login.php");
exit();
?>