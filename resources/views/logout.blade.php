<?php
    setcookie("login", "", time()-(60*60*24*7), "/");
    setcookie("password", "", time()-(60*60*24*7), "/");
    header('Location: /');
    exit;
?>