<?php
if (isset($_POST["add-region"])) {
    $region = $_POST["new-region"];
    if (!existRegion($region)) {
        addRegion($region);
        echo ("
            <div class=\"full-width-wrapper\">
                <div class=\"flex-wrap\">
                    <div class=\"new-ad-form-alert\">
                        <br><p>Region byl přidán.</p>
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
                        <p>Region již existuje.</p>
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
                    <label>Název kraje<input type="text" placeholder="Název nového kraje" name="new-region" required></label>
                    <input type="submit" name="add-region" value="Přidat kraj">
                </form>
            </div>
        </div>
    </div>
</div>
