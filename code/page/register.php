<?php
include_once './data/function.php';
if (isset($_POST["register"])) {
    $passwd = md5($_POST["password"]);
    $passwd_check = md5($_POST["password_check"]);
    if ($passwd == $passwd_check) {
        $email = $_POST["email"];
        $username = $_POST["username"];
        if (!existUser($email, $username)) {
            $sql = "INSERT INTO users (user_id, username, password, email, created, role, description) 
            VALUES (NULL, '" . htmlspecialchars($username) . "', '" . htmlspecialchars($passwd) . "', '" . htmlspecialchars($email) . "', NOW(), 'inzerent', 'popis uživatele...')";
            $conn->query($sql);
            echo '<script language="javascript">';
            echo 'alert("Registrace byla úspěšná. Nyní se můžete přihlásit")';
            echo '</script>';
            header("Refresh:0; url=./index.php?page=login");
        } else {
            echo 'E-mail nebo uživatel již existuje.';
        }
    } else {
        echo 'Hesla se neshodují.!';
    }
}
?>

<div class="full-width-wrapper">
    <div class="flex-wrap">
        <div class="login-register-form">
            <form action="" method="post">
                Přihlašovací jméno:<br>
                <input type="text" placeholder="Vaše přezdívka" name="username" required><br>
                E-mail:<br>
                <input type="email" placeholder="Váš e-mail" name="email" required><br>
                Heslo:<br>
                <input type="password" placeholder="Heslo" name="password" required><br>
                Potvrzení hesla:<br>
                <input type="password" placeholder="Ověření hesla" name="password_check" required><br><br>
                <input type="submit" name="register" value="Registrovat">
            </form>
        </div>
    </div>
</div>