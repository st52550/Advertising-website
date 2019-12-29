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
                echo ("<button type=\"button\" onclick=\"location.href='./index.php'\">Inzeráty</button>");
                echo ("<button type=\"button\" onclick=\"location.href=''\">Druhý</button>");
                echo ("<button type=\"button\" onclick=\"location.href=''\">Kontakt</button>");
                echo ("<button type=\"button\" onclick=\"location.href='?page=my_account'\">Můj profil</button>");
                if($role == 'admin') {
                    echo ("<button type=\"button\" onclick=\"location.href=''\">Správa uživatelů</button>");
                    echo ("<button type=\"button\" onclick=\"location.href=''\">Správa inzerátů</button>");
                    echo ("<button type=\"button\" onclick=\"location.href=''\">Správa dat</button>");
                }
            } else {
                echo ("<button type=\"button\" onclick=\"location.href='./index.php'\">Inzeráty</button>");
                echo ("<button type=\"button\" onclick=\"location.href=''\">Druhý</button>");
                echo ("<button type=\"button\" onclick=\"location.href=''\">Kontakt</button>");
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
            case "login" : include './page/login.php'; break;
            case "register" : include './page/register.php'; break;
            case "my_account" : include './page/my_account.php'; break;
        }
    } else {
    ?>

    <main>
        <div id="sidenav">
            <h3>Vyhledávání inzerátů</h3><br>

            <?php
                include "./page/search-form.php";
            ?>
        </div>

        <div id="items">
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Fusce dui leo, imperdiet in, aliquam sit amet, feugiat eu, orci. Aliquam erat volutpat. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam bibendum elit eget erat. Nullam dapibus fermentum ipsum. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Etiam commodo dui eget wisi. Curabitur ligula sapien, pulvinar a vestibulum quis, facilisis vel sapien. Vivamus ac leo pretium faucibus. Etiam sapien elit, consequat eget, tristique non, venenatis quis, ante. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. Nulla accumsan, elit sit amet varius semper, nulla mauris mollis quam, tempor suscipit diam nulla vel leo. Nam quis nulla. Nunc tincidunt ante vitae massa.</p>

            <p>Nulla non lectus sed nisl molestie malesuada. Nunc tincidunt ante vitae massa. Integer lacinia. Praesent dapibus. Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? Quisque tincidunt scelerisque libero. Duis sapien nunc, commodo et, interdum suscipit, sollicitudin et, dolor. Nullam rhoncus aliquam metus. Integer in sapien. Fusce tellus odio, dapibus id fermentum quis, suscipit id erat. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Mauris elementum mauris vitae tortor. Suspendisse sagittis ultrices augue. Aliquam in lorem sit amet leo accumsan lacinia. Curabitur ligula sapien, pulvinar a vestibulum quis, facilisis vel sapien.</p>

            <p>Aenean fermentum risus id tortor. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Duis ante orci, molestie vitae vehicula venenatis, tincidunt ac pede. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Phasellus enim erat, vestibulum vel, aliquam a, posuere eu, velit. In dapibus augue non sapien. Nullam rhoncus aliquam metus. Aliquam erat volutpat. Suspendisse nisl. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Sed ac dolor sit amet purus malesuada congue.</p>

            <p>Vivamus porttitor turpis ac leo. Praesent id justo in neque elementum ultrices. Fusce tellus. Phasellus enim erat, vestibulum vel, aliquam a, posuere eu, velit. Nullam at arcu a est sollicitudin euismod. Integer malesuada. Etiam neque. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Aliquam erat volutpat. Pellentesque arcu. Fusce wisi.</p>

            <p>Praesent in mauris eu tortor porttitor accumsan. Suspendisse nisl. Mauris tincidunt sem sed arcu. Aenean vel massa quis mauris vehicula lacinia. Aliquam ornare wisi eu metus. In dapibus augue non sapien. Vestibulum fermentum tortor id mi. Nullam faucibus mi quis velit. Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? Pellentesque ipsum. Morbi imperdiet, mauris ac auctor dictum, nisl ligula egestas nulla, et sollicitudin sem purus in lacus. Phasellus rhoncus.</p>
        </div>
    </main>

        <?php
    }
    ?>

    <footer>
        <div class="full-width-wrapper">
            <div class="flex-wrap">
                <section>
                    <h4>Odkazy</h4>
                    <ul>
                        <li><a href="./index.php">Inzeráty</a> </li>
                        <li><a href="#">Přihlášení</a> </li>
                        <li><a href="#">Registrace</a> </li>
                        <li><a href="#">Kontakt</a> </li>
                    </ul>
                </section>

                <section>
                    <p><a href="https://github.com"><h4>©2020 Josef Plášil</h4></a></p>
                </section>
            </div>
        </div>
    </footer>
</body>
</html>