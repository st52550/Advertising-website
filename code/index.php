<?php
session_start();
include './data/database.php';
include './data/auto_login.php';
include_once './data/function.php';
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./style/layout.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Najdi bydlení - inzerce bytů a domů</title>
</head>

<body>
    <header>
            <div id="header-title">
                <a href="./index.php"><img id="header-logo" src="./img/logo.png" width="100" height="100" alt="Logo"></a>
                <b>Najdibydlení.cz</b></div>
            <div id="login-buttons">
                <?php
                if (isset($_SESSION["user_id"])) {
                    $username = $_SESSION["username"];
                    echo ("Přihlášen: <b>$username</b> ");
                    echo ("<button type=\"button\" onclick=\"location.href='?page=logout'\">Odhlásit se</button>");
                } else {
                    echo ("<button type=\"button\" onclick=\"location.href='?page=login'\">Přihlášení</button>");
                    echo ("<button type=\"button\" onclick=\"location.href='?page=register'\">Registrace</button>");
                }
                ?>
            </div>
    </header>

    <section id="nav-section">
        <div class="full-width-wrapper">
        <nav>
            <?php
            if (isset($_SESSION["user_id"])) {
                $role = getRole($_SESSION["user_id"]);
                echo ("<button id=\"ads\" type=\"button\" class=\"nav-section-button\" onclick=\"location.href='?page=ads'\">Inzeráty</button>");
                echo ("<button id=\"my-ad\" type=\"button\" class=\"nav-section-button\" onclick=\"location.href='?page=my_ads'\">Moje inzeráty</button>");
                echo ("<button id=\"my-news\" type=\"button\" class=\"nav-section-button\" onclick=\"location.href='?page=my_news'\">Moje zprávy</button>");
                echo ("<button id=\"profile\" type=\"button\" class=\"nav-section-button\" onclick=\"location.href='?page=my_account'\">Můj profil</button>");
                if($role == 'admin') {
                    echo ("<button id=\"manage-users\" type=\"button\" class=\"nav-section-button\" onclick=\"location.href='?page=manage_users'\">Správa uživatelů</button>");
                    echo ("<button id=\"manage-ads\" type=\"button\" class=\"nav-section-button\" onclick=\"location.href='?page=manage_ads'\">Správa inzerátů</button>");
                    echo ("<button id=\"manage-data\" type=\"button\" class=\"nav-section-button\" onclick=\"location.href='?page=manage_data'\">Správa dat</button>");
                }
            } else {
                echo ("<button id=\"ads\" type=\"button\" class=\"nav-section-button\" onclick=\"location.href='?page=ads'\">Inzeráty</button>");
            }
            ?>
        </nav>
        </div>
    </section>

    <?php
    $page = "";
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
        if ($page == "logout") {
            include './data/logout.php';
            header("Refresh:0; url=./index.php");
        }
        switch ($page) {
            case "ads" :
                header("Refresh:0; url=./index.php");
                break;
            case "login" : include './page/login.php'; break;
            case "register" : include './page/register.php'; break;
            case "my_account" :
                include './page/my_account.php';
                echo "<script>let active = document.getElementById('profile'); active.className += \" nav-section-button-active\";</script>";
                break;
            case "my_news" :
                include './page/my_messages.php';
                echo "<script>let active = document.getElementById('my-news'); active.className += \" nav-section-button-active\";</script>";
                break;
            case "my_ads" :
                include './page/my_ads.php';
                echo "<script>let active = document.getElementById('my-ad'); active.className += \" nav-section-button-active\";</script>";
                break;
            case "manage_users" :
                include './page/manage_users.php';
                echo "<script>let active = document.getElementById('manage-users'); active.className += \" nav-section-button-active\";</script>";
                break;
            case "manage_ads" :
                include './page/manage_ads.php';
                echo "<script>let active = document.getElementById('manage-ads'); active.className += \" nav-section-button-active\";</script>";
                break;
            case "manage_data" :
                include './page/manage_data.php';
                echo "<script>let active = document.getElementById('manage-data'); active.className += \" nav-section-button-active\";</script>";
                break;
            case "details" : include './page/details.php'; break;
            case "delete_ad" : include './page/delete_ad.php'; break;
            case "edit_ad" : include './page/edit_ad.php'; break;
            case "delete_image" : include './page/delete_image.php'; break;
            case "edit_user" : include './page/edit_user.php'; break;
            case "delete_user" : include './page/delete_user.php'; break;
            case "add_region" : include './page/add_region.php'; break;
            case "edit_region" : include './page/edit_region.php'; break;
            case "delete_region" : include './page/delete_region.php'; break;
            case "add_city" : include './page/add_city.php'; break;
            case "edit_city" : include './page/edit_city.php'; break;
            case "delete_city" : include './page/delete_city.php'; break;
            case "add_category" : include './page/add_category.php'; break;
            case "edit_category" : include './page/edit_category.php'; break;
            case "delete_category" : include './page/delete_category.php'; break;
            case "add_room" : include './page/add_room.php'; break;
            case "edit_room" : include './page/edit_room.php'; break;
            case "delete_room" : include './page/delete_room.php'; break;
            case "edit_picture" : include './page/edit_picture.php'; break;
            case "delete_picture" : include './page/delete_picture.php'; break;
            case "view_picture" : include './page/view_picture.php'; break;
        }
    } else {
        if (basename($_SERVER['PHP_SELF']) == 'index.php') {
            echo "<script>let active = document.getElementById('ads'); active.className += \" nav-section-button-active\";</script>";
        }
    ?>

    <section>
        <div class="full-width-wrapper">
        <div id="sidenav">
            <h3>Vyhledávání inzerátů</h3><br>

            <?php
                include "./page/search-form.php";
            ?>
        </div>

        <div id="items">
            <?php
                include "./page/items.php";
            ?>
        </div>
        </div>
    </section>

        <?php
    }
    ?>
    <footer>
        <?php
        include "./page/footer.php";
        ?>
    </footer>
</body>
</html>