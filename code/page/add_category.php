<?php
if (isset($_POST["add-category"])) {
    $category = $_POST["new-category"];
    if (!existCategory($category)) {
        addCategory($category);
        echo ("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"new-ad-form-alert\">
                        <br><p>Kategorie byla přidána.</p>
                    </div>    
                </div>
            </div>   
            ");
        header("Refresh:1; url=?page=manage_data");
    } else {
        echo("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"login-register-form-alert\">
                        <p>Kategorie již existuje.</p>
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
            <div class="message-form">
                <form action="" method="post">
                    <label>Název kategorie<input type="text" placeholder="Název nové kategorie" name="new-category" required></label>
                    <input type="submit" name="add-category" value="Přidat kategorii">
                </form>
            </div>
        </div>
    </div>
</div>
