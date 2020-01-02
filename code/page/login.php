<?php
if (isset($_POST["login"])) {
    $name = $_POST["username"];
    $passwd = md5($_POST["password"]);
    $sql = "SELECT user_id, username, email FROM users where username = '" . htmlspecialchars($name) . "' and password = '" . htmlspecialchars($passwd) . "'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["user_email"] = $row["email"];
            if (isset($_POST["autologin"])) {
                setcookie("user_id", $_SESSION["user_id"], time() + (86400 * 7), "/");
            }
            header("Refresh:0; url=./index.php?page=my_account");
        }
    } else {
        echo ("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"login-register-form-alert\">
                        <p>Nesprávné jméno nebo heslo.</p>
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
            <h2>Přihlásit se</h2><br>
            <form method="post">
                <label>Uživatelské jméno:<input type="text" placeholder="Vaše přezdívka" name="username" required></label>
                <label>Heslo:<input type="password" placeholder="Heslo" name="password" required></label>
                <label id="form-checkbox-label">Zůstat přihlášen<input type="checkbox" name="autologin" value="1"></label>
                <input type="submit" name="login" value="Přihlásit se">
            </form>
        </div>
    </div>
</div>