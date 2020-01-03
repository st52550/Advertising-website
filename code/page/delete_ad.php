<?php
if (isset($_GET["item"])) {
    $itemId = $_GET["item"];

    deleteItem($itemId);

    header("Refresh:0; url=?page=my_ads");
}