<?php

if (!isset($_SESSION["id"]) && isset($_COOKIE["id"])) {
    $_SESSION["id"] = $_COOKIE["id"];
    setcookie("id", $_SESSION["id"], time() + (86400 * 7), "/");
}

?>