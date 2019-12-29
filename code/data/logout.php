<?php
session_destroy();
setcookie("id", "", time() - 3600);
?>