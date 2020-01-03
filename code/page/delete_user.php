<?php
if (isset($_GET["user"])) {
    $userId = $_GET["user"];

    deleteUser($userId);

    header("Refresh:0; url=?page=manage_users");
}