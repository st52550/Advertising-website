<?php
$userList = getUsers();

if (isset($_POST["add-new-user"])) {
    $username = $_POST["new-username"];
    $email = $_POST["new-email"];
    $passwd = md5($_POST["new-password"]);
    $passwd_check = md5($_POST["new-password_check"]);
    $role = $_POST["select-role"];
    $description = $_POST["new-description"];

    if ($passwd == $passwd_check) {
        if (!existUser($email, $username)) {
            addUser($username, $email, $passwd, $role, $description);
            echo ("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"new-ad-form-alert\">
                        <br><p>Uživatel byl přidán.</p>
                    </div>    
                </div>
            </div>   
            ");
            header("Refresh:1; url=?page=manage_users");
        } else {
            echo("
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
        echo("
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
        <div class="item-details">
            <button id="new-user" type="button" class="global-button">Nový uživatel</button>
            <button id="list-users" type="button" class="global-button global-button-active">Seznam uživatelů</button>
            <br><br>

            <div id="list-div">
                <div style="overflow-x:auto;">
                <table class='messages-table'>
                    <tr><th>Uživatelské jméno</th><th>E-mail</th><th>Role</th><th>Datum registrace</th>
                        <th>Editovat</th><th>Odstranit</th></tr>
                    <?php
                    if ($userList->num_rows > 0) {
                        while ($rowUser = $userList->fetch_assoc()) {
                            $userId = $rowUser["user_id"];
                            $username = $rowUser["username"];
                            $email = $rowUser["email"];
                            $role = $rowUser["role"];
                            try {
                                $createdDate = date_format(new DateTime($rowUser["created"]), "d.m.Y H:i:s");
                            } catch (Exception $e){echo 'Message: ' .$e->getMessage();}

                            echo "
                            <tr style='border-bottom: 1px solid #cccccc'><td>$username</td><td>$email</td><td>$role</td><td>$createdDate</td>
                            <td><a class=\"information-link\" href=\"?page=edit_user&user=$userId\">Upravit</a></td>
                            <td><a class=\"information-link\" href=\"?page=delete_user&user=$userId\" onclick=\"return confirm('Opravdu chcete uživatele smazat?')\">Odstranit</a></td>
                            </tr>
                            ";
                        }
                    }
                    ?>
                </table>
                </div>
            </div>

            <div id="new-user-div" style="display: none">
                <div class="message-form">
                    <form action="" method="post">
                        <label>Přihlašovací jméno<input type="text" placeholder="Vaše nová přezdívka" name="new-username" required></label>
                        <label>E-mail<input type="email" placeholder="Váš nový e-mail" name="new-email" required></label>
                        <label>Heslo<input type="password" placeholder="Nové heslo" name="new-password" required></label>
                        <label>Potvrzení hesla<input type="password" placeholder="Ověření nového hesla" name="new-password_check" required></label>
                        <label>Vyberte roli<select name="select-role">
                            <option value="admin">admin</option>
                            <option value="inzerent" selected>inzerent</option>
                            </select></label>
                        <label>Přidat popis<textarea placeholder="Popis uživatele" name="new-description"></textarea></label>
                        <input type="submit" name="add-new-user" value="Přidat uživatele">
                    </form>
                </div>
            </div>

            <script>
                let buttonNewUser = document.getElementById('new-user');
                let buttonListUser = document.getElementById('list-users');
                let divListUser = document.getElementById('list-div');
                let divNewUser = document.getElementById('new-user-div');

                buttonNewUser.onclick = function() {
                    divNewUser.style.display = 'block';
                    divListUser.style.display = 'none';
                    this.className = 'global-button global-button-active';
                    buttonListUser.className = 'global-button';
                };
                buttonListUser.onclick = function() {
                    divNewUser.style.display = 'none';
                    divListUser.style.display = 'block';
                    this.className = 'global-button global-button-active';
                    buttonNewUser.className = 'global-button';
                };
            </script>
        </div>
    </div>
</div>
