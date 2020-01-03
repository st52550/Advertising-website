<?php
if (isset($_GET["image"])) {
    $imageName = $_GET["image"];

    $id = deleteImage($imageName);

    header("Refresh:0; url=?page=edit_ad&item=$id");
}