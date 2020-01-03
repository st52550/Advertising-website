<?php
$actualUserId = '';
if (isset($_SESSION["user_id"])) {
    $actualUserId = $_SESSION["user_id"];
}

$user = getByUserId($actualUserId);
if ($user->num_rows > 0) {
    $rowUser = $user->fetch_assoc();
}

try {
    $createdDate = date_format(new DateTime($rowUser["created"]), "d.m.Y H:i:s");
} catch (Exception $e){echo 'Message: ' .$e->getMessage();}

if (isset($_POST["change-username"])) {
    $username = $_POST["new-username"];
    if (!existUsername($username)) {
        updateUsername($actualUserId, $username);
        echo ("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"new-ad-form-alert\">
                        <br><p>Jméno bylo změněno.</p>
                    </div>    
                </div>
            </div>   
            ");
        header("Refresh:1; url=?page=my_account");
    } else {
        echo ("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"login-register-form-alert\">
                        <p>Uživatel již existuje.</p>
                    </div>    
                </div>
            </div>   
            ");
    }
}
if (isset($_POST["change-email"])) {
    $email = $_POST["new-email"];
    if (!existEmail($email)) {
        updateEmail($actualUserId, $email);
        echo ("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"new-ad-form-alert\">
                        <br><p>Email byl změněn.</p>
                    </div>    
                </div>
            </div>   
            ");
        header("Refresh:1; url=?page=my_account");
    } else {
        echo ("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"login-register-form-alert\">
                        <p>Email již existuje.</p>
                    </div>    
                </div>
            </div>   
            ");
    }
}
if (isset($_POST["change-password"])) {
    $passwd_old = md5($_POST["old-password"]);
    $passwd = md5($_POST["new-password"]);
    $passwd_check = md5($_POST["new-password_check"]);

    if ($passwd_old == $rowUser["password"]) {
        if ($passwd == $passwd_check) {
            updatePassword($actualUserId, $passwd);
            echo ("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"new-ad-form-alert\">
                        <br><p>Heslo bylo změněno.</p>
                    </div>    
                </div>
            </div>   
            ");
            header("Refresh:2; url=?page=my_account");
        }
        else {
            echo ("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"login-register-form-alert\">
                        <p>Nová hesla se neshodují.</p>
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
                        <p>Vaše heslo není správné.</p>
                    </div>    
                </div>
            </div>   
            ");
    }
}

if (isset($_POST["change-description"])) {
    $description = $_POST["new-description"];
    updateDescription($actualUserId, $description);
    echo ("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"new-ad-form-alert\">
                        <br><p>Popis byl změněn.</p>
                    </div>    
                </div>
            </div>   
            ");
    header("Refresh:1; url=?page=my_account");
}
?>

<div class="full-width-wrapper">
    <div class="flex-wrap">
        <div class="item-details">
            <button id="edit-profile" type="button" class="global-button">Upravit údaje</button>
            <button id="profile-info" class="global-button global-button-active">Informace</button>
            <br><br>

            <div id="info-div">
                <table>
                    <tr><td>Uživatelské jméno:</td><td><b><?php echo $rowUser["username"]?></b></td></tr>
                    <tr><td>E-mail:</td><td><b><?php echo $rowUser["email"]?></b></td></tr>
                    <tr><td><br></td></tr>
                    <tr><td>Role:</td><td><b><?php echo $rowUser["role"]?></b></td></tr>
                    <tr><td><br></td></tr>
                    <tr><td>Registrace:</td><td><?php echo $createdDate?></td></tr>
                    <tr><td><br></td></tr>
                    <tr><td>Popis:</td><td><?php echo $rowUser["description"]?></td></tr>
                </table>
            </div>

            <div id="edit-div" style="display: none">
                <div class="message-form">
                <form action="" method="post">
                    <label><b>Změnit jméno</b><input type="text" placeholder="Vaše nová přezdívka" name="new-username" required></label>
                    <input type="submit" name="change-username" value="Změnit jméno">
                </form>
                <br>
                    <form action="" method="post">
                        <label><b>Změnit e-mail</b><input type="email" placeholder="Váš nový e-mail" name="new-email" required></label>
                        <input type="submit" name="change-email" value="Změnit e-mail">
                    </form>
                    <br>
                    <form action="" method="post">
                        <label><b>Změnit heslo</b><br><br></label>
                        <label>Staré heslo<input type="password" placeholder="Staré heslo" name="old-password" required></label>
                        <label>Nové heslo<input type="password" placeholder="Nové heslo" name="new-password" required></label>
                        <label>Potvrzení nového hesla<input type="password" placeholder="Ověření nového hesla" name="new-password_check" required></label>
                        <input type="submit" name="change-password" value="Změnit heslo">
                    </form>
                    <br>
                    <form action="" method="post">
                        <label><b>Změnit popis</b>
                            <textarea name="new-description" required><?php echo $rowUser["description"]?></textarea></label>
                        <input type="submit" name="change-description" value="Změnit popis">
                    </form>
                </div>
            </div>

            <script>
                let buttonEdit = document.getElementById('edit-profile');
                let buttonInfo = document.getElementById('profile-info');
                let divInfo = document.getElementById('info-div');
                let divEdit = document.getElementById('edit-div');

                buttonEdit.onclick = function() {
                    divEdit.style.display = 'block';
                    divInfo.style.display = 'none';
                    this.className = 'global-button global-button-active';
                    buttonInfo.className = 'global-button';
                };
                buttonInfo.onclick = function() {
                    divEdit.style.display = 'none';
                    divInfo.style.display = 'block';
                    this.className = 'global-button global-button-active';
                    buttonEdit.className = 'global-button';
                };
            </script>
        </div>
    </div>
</div>
