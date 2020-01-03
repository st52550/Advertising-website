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
        <div class="full-width-wrapper">
            <a href="./index.php"><img id="header-logo" src="./img/logo.png" width="128" height="128" alt="Logo"></a>
            <div id="header-title"><b>Najdibydlení.cz</b></div>
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
        </div>
    </header>

    <section id="nav-section">
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
        }
    } else {
        if (basename($_SERVER['PHP_SELF']) == 'index.php') {
            echo "<script>let active = document.getElementById('ads'); active.className += \" nav-section-button-active\";</script>";
        }
    ?>

    <main>
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
    </main>

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