<?php
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
            echo '<script>';
            echo 'alert("Registrace byla úspěšná. Nyní se můžete přihlásit")';
            echo '</script>';
            header("Refresh:0; url=./index.php?page=login");
        } else {
            echo ("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"login-register-form-alert\">
                        <p>E-mail nebo uživatel již existuje.</p>
                    </div>    
                </div>
            </div>   
            ");
        }
    } else {
        echo ("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"login-register-form-alert\">
                        <p>Hesla se neshodují.</p>
                    </div>    
                </div>
            </div>   
            ");
    }
}
?>

<div class="full-width-wrapper">
    <div class="flex-wrap">
        <div class="login-register-form">
            <h2>Registrovat se</h2><br>
            <form action="" method="post">
                <label>Přihlašovací jméno:<input type="text" placeholder="Vaše přezdívka" name="username" required></label>
                <label>E-mail:<input type="email" placeholder="Váš e-mail" name="email" required></label>
                <label>Heslo:<input type="password" placeholder="Heslo" name="password" required></label>
                <label>Potvrzení hesla:<input type="password" placeholder="Ověření hesla" name="password_check" required></label>
                <input type="submit" name="register" value="Registrovat se">
            </form>
        </div>
    </div>
</div>