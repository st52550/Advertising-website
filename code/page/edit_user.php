<?php
if (isset($_GET["user"])) {
    $userId = $_GET["user"];
    $user = getByUserId($userId);

    if ($user->num_rows > 0) {
        $rowUser = $user->fetch_assoc();
    }

    if (isset($_POST["edit-new-user"])) {
        $username = $_POST["edit-username"];
        $email = $_POST["edit-email"];
        $role = $_POST["edit-role"];
        $description = $_POST["edit-description"];

        if ($username != $rowUser["username"]){
            if (!existUsername($username)){
                editUser($userId, $username, $email, $role, $description);
                echo ("
                <div class=\"full-width-wrapper\">
                    <div class=\"flex-wrap\">
                        <div class=\"new-ad-form-alert\">
                            <br><p>Uživatel byl upraven.</p>
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
                            <p>E-mail již existuje.</p>
                        </div>    
                    </div>
                </div>   
                ");
            }
        } else if ($email != $rowUser["email"]){
            if (!existEmail($email)){
                editUser($userId, $username, $email, $role, $description);
                echo ("
                <div class=\"full-width-wrapper\">
                    <div class=\"flex-wrap\">
                        <div class=\"new-ad-form-alert\">
                            <br><p>Uživatel byl upraven.</p>
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
                            <p>Uživatelské jméno již existuje.</p>
                        </div>    
                    </div>
                </div>   
                ");
            }
        } else {
            editUser($userId, $username, $email, $role, $description);
            echo("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"new-ad-form-alert\">
                        <br><p>Uživatel byl upraven.</p>
                    </div>    
                </div>
            </div>   
            ");
            header("Refresh:1; url=?page=manage_users");
        }
    }
}
?>

<div class="full-width-wrapper">
    <div class="flex-wrap">
        <div class="item-details">
            <div class="message-form">
                <form action="" method="post">
                    <label>Přihlašovací jméno<input type="text" placeholder="Nová přezdívka" name="edit-username" required value="<?php
                        echo $rowUser["username"];
                        ?>"></label>
                    <label>E-mail<input type="email" placeholder="Nový e-mail" name="edit-email" required value="<?php
                        echo $rowUser["email"];
                        ?>"></label>
                    <label>Vyberte roli<select name="edit-role">
                            <option value="admin" <?php if ($rowUser["role"] == 'admin') { echo " selected";}?>>admin</option>
                            <option value="inzerent" <?php if ($rowUser["role"] == 'inzerent') { echo " selected";}?>>inzerent</option>
                        </select></label>
                    <label>Přidat popis<textarea placeholder="Popis uživatele" name="edit-description"><?php echo $rowUser["description"]?></textarea></label>
                    <input type="submit" name="edit-new-user" value="Editovat uživatele">
                </form>
            </div>
        </div>
    </div>
</div>